# ui_tabs — Architecture (Elgg 5.x)

## Summary

ui_tabs provides an AJAX tab component for Elgg. It overrides the default
page body rendering to wrap filtered content pages in a tabbed layout, and
exposes a reusable `page/layouts/tabs` layout view for direct use.

## Directory Structure

```
ui_tabs/
├── views/default/
│   ├── page/layouts/elements/body.php  — Elgg 5.x hook: wraps filter+content in tabs
│   ├── page/layouts/content.php        — Legacy 4.x layout (still works; not called by core 5.x pages)
│   ├── page/layouts/content/filter.php — Registers all/mine/friends menu items (legacy path)
│   ├── page/layouts/tabs.php           — Tabbed layout (delegates to components/tabs)
│   ├── plugins/ui_tabs/settings.php    — Admin settings form
│   ├── theme_sandbox/components/tabs   — Theme sandbox demo
│   └── components/tabs.php             — Tab component renderer
├── tests/
│   ├── phpunit/integration/UiTabs/
│   ├── playwright/tests/
│   ├── bootstrap.php
│   └── phpunit.xml
├── composer.json
└── elgg-plugin.php
```

## View Extensions

| Extends | With |
|---------|------|
| `theme_sandbox/components` | `theme_sandbox/components/tabs` |

## Dependencies

None — leaf plugin.

## Migration Notes (4.x → 5.x)

- `elgg/elgg` bumped to `^5.0`, PHP to `>=8.2`.
- `view_extensions` key now requires flat `'view' => 'extension'` format; nested
  array format removed in 5.x.
- `jquery-ui` AMD module split in Elgg 5.x — `views/default/components/tabs.js`
  updated to `require('jquery-ui/unique-id')`.
- `page/layouts/content` was removed from Elgg 5.x core (all pages now use
  `page/layouts/default`). A new view `page/layouts/elements/body.php` was added
  to intercept the 5.x default-layout body rendering and apply the same tabs
  wrapping when a filter menu is present. The legacy `page/layouts/content`
  override is kept for any plugin that explicitly calls `elgg_view_layout('content', ...)`.
- PHPUnit tests updated: `elgg_get_session()->setLoggedInUser()` replaced with
  `_elgg_services()->session_manager->setLoggedInUser()` (method removed in 5.x).
- Docker test stack: PHP 8.2-apache, MySQL 8.0, Playwright v1.59.1-noble.
- `elgg_clear_caches()` (not `elgg_invalidate_caches()`) required after plugin
  activation in the install script to properly wipe the `localFileCache`-backed
  `view_locations` cache.

## Migration Notes (3.x → 4.x)

- `manifest.xml` removed; `composer.json` is now the sole metadata source.
- `elgg-plugin.php` received the `'plugin'` key.
- `elgg/elgg` constraint tightened from `~4.0` to `^4.0`; `php >=7.4` added;
  `composer/installers` bumped to `^2.0`; `config.allow-plugins` added.
- Security sweep: `echo $vars['content']` in `page/layouts/tabs.php` flagged as
  XSS warning — false positive; `$vars['content']` is pre-rendered HTML passed
  through the Elgg view system, not raw user input.
