define(function (require) {

	var elgg = require('elgg');
	var $ = require('jquery');
	require('jquery-ui');
	var spinner = require('elgg/spinner');

	$('.elgg-tabs-nav a').uniqueId();

	//set original state
	var $pageTabs = $('.elgg-tabs-container:has(.elgg-content[data-url]):has(li.elgg-state-selected a)');
	if ($pageTabs.length) {
		var tabData = $pageTabs.find('.elgg-content[data-url]').data();
		tabData.replacedState = true;
		tabData.activeTabSelector = '#' + $pageTabs.find('li.elgg-state-selected a').attr('id');
		window.history.replaceState(tabData, $('title').text() || '', window.location.href);
	}

	$(document).on('click', '.elgg-tabs-nav a', function (e) {

		var $link = $(this);
		var $tab = $(this).closest('li');
		var $container = $(this).closest('.elgg-tabs-container');
		var id = $container.attr('id');
		var $content = $container.find('.elgg-tabs-content');
		var $target;

		$tab.siblings().find('a').uniqueId();

		// give precedence to data-href attribute, in case we want use /ajax/view/
		var href = $link.data('href') || $link.attr('href');
		if (href.indexOf('#') === 0) {
			// inline content
			// not using e.preventDefault, so that #target is pushed to broswer history
			$target = $content.find(href);
			if ($target.length) {
				$target.siblings().hide().removeClass('elgg-state-active');
				$target.show().addClass('elgg-state-active');
				$tab.siblings().andSelf().removeClass('elgg-state-selected');
				$tab.addClass('elgg-state-selected');
			}
			return;
		}

		e.preventDefault();
		elgg.ajax(href, {
			data: $link.data(),
			beforeSend: spinner.start,
			complete: spinner.stop,
			success: function (response) {
				var html;
				if ($(response).find('#' + id).length) {
					// first check if we are loading a full page,
					// if so, parse out the content of the new tab
					html = $(response).find('#' + id).find('.elgg-tabs-content').html();
				} else if ($(response).find('.elgg-main').length) {
					// check if we page was generated using an elgg layout
					html = $(response).find('.elgg-main').html();
				} else if ($(response).find('body').length) {
					// check if we have a body tag
					html = $(response).find('body').html();
				} else {
					// assume we just loaded the content we need to show
					html = response;
				}

				// remove all items that we loaded via ajax and .elgg-content items that do not have an id
				$content.find('[data-ajax],.elgg.content:not([id])').remove();

				// wrap content if it's not wrapped and mark as data-ajax
				if ($(html).is('.elgg-content')) {
					$target = $(html).attr('data-ajax', true);
				} else {
					$target = $('<div data-ajax />').html(html);
				}

				$content.append($target);
				$target.siblings().hide().removeClass('elgg-state-active');
				$target.show().addClass('elgg-state-active');

				// if new content element has a title and title selector
				// replace content of the title selector
				if ($target.data('title')) {
					$('title').text($target.data('title')); // replace page <title>
					if ($target.data('titleSelector')) {
						$($target.data('titleSelector')).html($target.data('title'));
					}
				}
				// if new content element has associated url
				// replace browser url
				if ($target.data('url')) {
					var tabData = $target.data();
					tabData.activeTabSelector = '#' + $link.attr('id');
					if (window.history.state.activeTabSelector !== tabData.activeTabSelector) {
						window.history.pushState(tabData, $target.data('title'), $target.data('url'));
					}
				}

				$tab.siblings().andSelf().removeClass('elgg-state-selected');
				$tab.addClass('elgg-state-selected');
			}
		});

	});

	$(window).on('popstate', function (event) {
		if (event.originalEvent.state.activeTabSelector) {
			$(event.originalEvent.state.activeTabSelector).trigger('click');
		}
	});

});

