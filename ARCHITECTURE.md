# ui_tabs — Architecture (Elgg 4.x)

## Summary

ui_tabs provides an AJAX tab component for Elgg. It registers view extensions
and includes a tabbed layout view (`page/layouts/tabs.php`).

## Directory Structure

```
ui_tabs/
├── views/default/
│   ├── page/layouts/tabs.php     — Tabbed layout (delegates to components/tabs)
│   ├── theme_sandbox/components/tabs — Theme sandbox demo
│   └── components/tabs.php       — Tab component renderer
├── tests/
│   ├── phpunit/integration/…/BootstrapTest.php
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

## Migration Notes (3.x → 4.x)

- `manifest.xml` removed; `composer.json` is now the sole metadata source.
- `elgg-plugin.php` received the `'plugin'` key.
- `elgg/elgg` constraint tightened from `~4.0` to `^4.0`; `php >=7.4` added;
  `composer/installers` bumped to `^2.0`; `config.allow-plugins` added.
- Security sweep: `echo $vars['content']` in `page/layouts/tabs.php` flagged as
  XSS warning — false positive; `$vars['content']` is pre-rendered HTML passed
  through the Elgg view system, not raw user input.
