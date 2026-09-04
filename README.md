# Batavia

A WordPress block theme for a personal site: a home page, a notes index,
selected work and a rate card, built entirely from core blocks.

Ink on paper, a monospace accent for the parts of the page that are really data,
and hairline rules doing the work that boxes and shadows usually do. Dark mode
follows the operating system. No external requests, no contact page -- buttons
open WhatsApp or email from the theme settings.

- **Requires** WordPress 6.6+, PHP 7.4+
- **Licence** GPL-2.0-or-later
- **Text domain** `batavia`

The `batavia` slug was confirmed available on the WordPress.org theme
directory before this theme was renamed to it; re-verify immediately before
submitting, since availability is first-come-first-served.

## Design constraints

Batavia is built to pass the WordPress.org theme review, which shapes the code
more than any aesthetic decision does:

- **No custom post types, taxonomies or meta boxes.** Content types are
  separated with the built-in Category taxonomy, so a user who switches away
  keeps everything they wrote.
- **One settings option.** Personal details (name, contact, social profiles)
  live in a single `batavia_settings` option, written through the Customizer
  and read into patterns via the Block Bindings API. Everything else
  configurable lives in `theme.json`.
- **No external requests.** Fonts are bundled and served from the site's own
  domain.
- **Everything is a core block.** The theme registers block *styles*, never
  blocks.

## Layout

```
batavia/
├── theme.json              Colour, type, spacing, layout. Nearly all styling.
├── style.css               Only what theme.json cannot express.
├── functions.php           Theme supports, two stylesheets, block styles,
│                           pattern category, font preloading.
├── inc/
│   ├── settings.php         The settings schema and the accessors that read it.
│   ├── bindings.php          Connects settings to core blocks via Block Bindings.
│   ├── customizer.php        The Customizer panel: sections, controls, sanitisation.
│   └── media.php             Placeholder for a post with no featured image.
├── assets/
│   ├── css/color-scheme.css  The prefers-color-scheme dark palette.
│   ├── js/                    The editor bindings script.
│   └── fonts/                IBM Plex woff2 subsets + OFL licence.
├── styles/                  Four style variations (forest, indigo, newsprint, slate).
├── parts/                   header.html, footer.html
├── patterns/                Seventeen patterns; four are template plumbing.
├── templates/               Seven templates.
├── languages/batavia.pot   Translation template.
└── tools/                   Development tooling. Not distributed.
```

## Local development

### Without Docker

Needs PHP 8.0+ with `pdo_sqlite` and [WP-CLI](https://wp-cli.org/):
`brew install php wp-cli`.

```bash
npm run start
```

Provisions WordPress on SQLite in `.wp-local/`, symlinks this directory in as
the active theme, seeds content covering every template, and serves it.

| | |
| --- | --- |
| Site | http://localhost:8420 |
| Admin | http://localhost:8420/wp-admin (`admin` / `password`) |
| PHP log | `.wp-local/wp-content/debug.log` |

The theme is symlinked, so edits are live — no build step. `npm run start:fresh`
rebuilds the install.

### With Docker

```bash
npm install && composer install && npm run dev
```

`wp-env` on http://localhost:8888, same login.

## The Customizer panel

`Appearance -> Customize -> Batavia` has one section per group in
`batavia_settings_schema()`: Profile, Contact, Social profiles, Hero, Selected
work, Experience, Consulting, Notes and Closing call to action. Together they
hold the personal details the patterns read through Block Bindings -- name,
role, email, WhatsApp number, up to fourteen social profiles -- plus which
sections the front page shows. It lives in `inc/customizer.php`.

Theme review requires a theme's own options to be edited in the Customizer, and
forbids custom options panels, demo importers, outbound HTTP requests and usage
tracking inside a theme. Anything requiring more belongs in a companion plugin.

Core hides the Customizer on block themes unless something hooks
`customize_register` (see `wp-admin/menu.php`), so registering the panel is also
what puts `Appearance -> Customize` back on the menu.

The Customizer has no repeating control, so Experience and Consulting are laid
out as a fixed number of numbered slots -- `BATAVIA_EXPERIENCE_SLOTS` and
`BATAVIA_CONSULTING_SLOTS`. A slot is stored against its own index so the slots
stay put on screen; `batavia_get_repeater_rows()` sorts them, drops the blank
ones and reindexes, so the front end only ever sees the rows that were filled
in.

## Debugging

**Which file produced this?** The local install loads `tools/dev-markers.php`,
which annotates the output:

```html
<!-- batavia: template = batavia//front-page -->
<!-- batavia: part/header --> … <!-- /batavia: part/header -->
<!-- batavia: pattern/batavia/hero --> … <!-- /batavia: pattern/batavia/hero -->
<!-- batavia: theme stylesheets in order = batavia-style, batavia-color-scheme -->
```

**PHP notices:** `npm run start:log`. Should be empty.

**Queries and template hierarchy:** Query Monitor, installed automatically.

**Changes not appearing?** Two caches, both already handled: `WP_DEVELOPMENT_MODE
= 'theme'` disables theme.json caching, and the dev server runs with
`-d opcache.enable=0` because PHP's built-in server honours OPcache under the
`cli-server` SAPI with a two-second revalidation.

## Editing in wp-admin

Appearance → Editor is the right place to build layouts. But **it saves to the
database, not to the theme's files**, and WordPress then prefers the database
copy. So an edited template is invisible to git, absent from the zip, and makes
further edits to the file appear to do nothing.

```bash
npm run editor:status    # what is customised in the database?
npm run editor:pull      # write it onto the theme's files
npm run editor:reset     # clear the database copies
```

The official [Create Block Theme](https://wordpress.org/plugins/create-block-theme/)
plugin does the same from a button in the editor, and is the standard way. Note
that it rewrites `theme.json` wholesale, so prefer `npm run editor:pull:styles`
for Styles changes if you want a readable diff.

## Checks

```bash
npm run core     # fetch a WordPress checkout into .wp-core (once)
npm run lint     # everything below
```

| Command | What it checks |
| --- | --- |
| `npm run lint:blocks` | Runs the block editor's own parser over every template, part and pattern. Fails if markup differs from what the editor would save. |
| `npm run lint:structure` | WordPress's PHP block parser: unknown blocks, undeclared attributes, unresolved references, templates missing `<main>`, malformed pattern headers. |
| `npm run lint:contrast` | Every colour pair the theme paints, against WCAG 2.1 AA, in both schemes. |
| `npm run lint:php` | `php -l` then PHPCS against the WordPress Coding Standards. |
| `npm run preflight` | The built zip against the WordPress.org submission requirements, including the slug-collision check. |
| `npm run theme-check` | The review team's own plugin. |

## Releasing

1. Bump `Version:` in `style.css` and `Stable tag:` in `readme.txt`. They must match.
2. Move `## [Unreleased]` entries in `CHANGELOG.md` under the new version.
3. `npm run lint`
4. `npm run zip`
5. `npm run preflight`
6. `npm run theme-check`
7. Tag in git, then upload the zip at
   [wordpress.org/themes/upload](https://wordpress.org/themes/upload/).

Updates work the same way: bump the version, rebuild, upload again. Theme authors
do not commit to WordPress.org's SVN; the directory imports the uploaded zip.

## Before the first submission

- **`screenshot.png`**, 1200×900, 4:3. Bundled already; regenerate it if the
  front page changes -- the hero with its label rule and the top of the
  experience timeline. It renders at ~387×290 in the directory, so favour
  readable type over a zoomed-out full page.
- **`Author`, `Author URI`, `Theme URI`** in `style.css`, and `Contributors` in
  `readme.txt` (a WordPress.org username).
- **`accessibility-ready`** routes you into a separate, slower audit queue.
  Remove it from both files if you would rather ship sooner.

## Contributing

`npm run lint` must pass. PHP follows the WordPress Coding Standards
(`composer lint:fix` applies them). Block markup is easiest to write by building
in the Site Editor and pulling it back; `npm run lint:blocks` catches hand-edits
that broke it. New user-facing strings need `esc_html_e()` or a sibling with the
`batavia` text domain, and a regenerated POT.

## Licence

GPL-2.0-or-later. See [LICENSE](LICENSE). IBM Plex Sans and Plex Mono are
© IBM Corp., licensed under the SIL Open Font Licence 1.1.
