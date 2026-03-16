# Forms Microsite

Static bilingual microsite for Standard Doors forms. PHP source files are pre-rendered to static HTML at build time and served via GitHub Pages. Pages use clean directory-based URLs (`/en/service/` instead of `service-en.html`).

## How it works

`build.php` recursively processes each `src/pages/**/*.php` file through PHP, captures the output as static HTML, and writes it to `dist/` preserving directory structure. Non-index pages get their own directory (`service.php` → `service/index.html`). No PHP runs on the server. A `dist/404.html` redirects legacy `.php` URLs to their `.html` equivalents.

## Quick start

```bash
composer install  # Install dependencies
composer build    # Generate static HTML in dist/
composer serve    # Preview source at localhost:8000
```

## Project structure

- `src/pages/` — Page source files (root index + en/fr subdirectories)
- `src/partials/` — Shared components (header, footer, tally-embed)
- `src/i18n/` — Translation strings (en.php, fr.php)
- `src/config.php` — Site config (Tally form ID, site names)
- `src/assets/` — CSS, logos
- `dist/` — Generated output (git-ignored)
- `tests/` — PHPUnit tests

## Quality tools

Run `composer check` before committing — it runs the full suite:

```bash
composer lint          # PSR-12 code style check
composer lint:fix      # Auto-fix style issues
composer analyse       # PHPStan static analysis (level 5)
composer test          # Build + unit tests
composer validate-html # HTML structure validation (PHPUnit)
composer check         # All of the above
```

## Pages

- `/` — Language selector (EN / FR)
- `/en/` — English home
- `/fr/` — French home
- `/en/service/` — Service request form (Tally embed)
- `/fr/service/` — Demande de service (Tally embed)
- `/en/find-your-production-number/` — Find your production number
- `/fr/find-your-production-number/` — Trouver votre numéro de production

## i18n

Translations live in `src/i18n/en.php` and `src/i18n/fr.php` as key-value arrays. Each page sets `$lang` before including the header partial, which loads the correct file into `$t`.

## Tally form

The embedded form ID is configured in `src/config.php` (`tally_form_id`). Change it there to swap forms site-wide.

## CI/CD

**On pull request** — lint, static analysis, unit tests, build check, HTML validation.

**On push to `main`** — same as above, then deploy to GitHub Pages.

**Daily at 2:00 AM EST** — full rebuild and deploy.

## Requirements

- PHP 8.5+
- Composer
- Docker (optional — only needed for `make ci` which runs the W3C Nu HTML Checker)
