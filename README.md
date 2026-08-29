# Celestine

A WordPress block theme for engineers who want one site instead of three: a
project portfolio, a technical blog and a consulting rate card under a single
typographic system.

Ink on paper, a monospace accent for the parts of the page that are really data,
and hairline rules doing the work that boxes and shadows usually do. Dark mode
follows the operating system. No external requests, no theme JavaScript, no
settings screen.

- **Requires** WordPress 6.6+, PHP 7.4+
- **Licence** GPL-2.0-or-later
- **Text domain** `celestine`

The `celestine` slug was confirmed available on the WordPress.org theme
directory before this theme was renamed to it; re-verify immediately before
submitting, since availability is first-come-first-served.

## Design constraints

Celestine is built to pass the WordPress.org theme review, which shapes the code
more than any aesthetic decision does:

- **No custom post types, taxonomies or meta boxes.** Content types are
  separated with the built-in Category taxonomy, so a user who switches away
  keeps everything they wrote.
- **No settings screen.** Everything configurable lives in `theme.json`.
- **No external requests.** Fonts are bundled and served from the site's own
  domain.
- **Everything is a core block.** The theme registers block *styles*, never
  blocks.

## Layout

```
celestine/
├── theme.json              Colour, type, spacing, layout. Nearly all styling.
├── style.css               Only what theme.json cannot express.
├── functions.php           Theme supports, two stylesheets, block styles,
│                           pattern category, font preloading.
├── assets/
│   ├── css/color-scheme.css  The prefers-color-scheme dark palette.
│   └── fonts/                IBM Plex woff2 subsets + OFL licence.
├── parts/                  header.html, footer.html
├── patterns/               Twelve patterns; four are template plumbing.
├── templates/              Seven templates.
├── languages/celestine.pot Translation template.
└── tools/                  Development tooling. Not distributed.
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

## The Appearance sub-page

`Appearance -> Celestine` explains the theme's content model, links into the
Site Editor, and lists the sections it ships. It lives in `inc/admin/` and loads
only in the admin.

Theme review permits an Appearance sub-page but forbids demo importers, outbound
HTTP requests and usage tracking inside a theme. This page does none of those --
every link is either an admin screen on the same site or a plain documentation
link. Anything requiring more belongs in a companion plugin.

## Debugging

**Which file produced this?** The local install loads `tools/dev-markers.php`,
which annotates the output:

```html
<!-- celestine: template = celestine//front-page -->
<!-- celestine: part/header --> … <!-- /celestine: part/header -->
<!-- celestine: pattern/celestine/hero --> … <!-- /celestine: pattern/celestine/hero -->
<!-- celestine: theme stylesheets in order = celestine-style, celestine-color-scheme -->
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

- **`screenshot.png`**, 1200×900, 4:3. Recommended: the front page in light mode
  at a ~1600px viewport, scaled down — the hero with its label rule, the
  tech-stack columns, the top of the timeline. It renders at ~387×290 in the
  directory, so favour readable type over a zoomed-out full page.
- **`Author`, `Author URI`, `Theme URI`** in `style.css`, and `Contributors` in
  `readme.txt` (a WordPress.org username).
- **`accessibility-ready`** routes you into a separate, slower audit queue.
  Remove it from both files if you would rather ship sooner.

## Contributing

`npm run lint` must pass. PHP follows the WordPress Coding Standards
(`composer lint:fix` applies them). Block markup is easiest to write by building
in the Site Editor and pulling it back; `npm run lint:blocks` catches hand-edits
that broke it. New user-facing strings need `esc_html_e()` or a sibling with the
`celestine` text domain, and a regenerated POT.

## Licence

GPL-2.0-or-later. See [LICENSE](LICENSE). IBM Plex Sans and Plex Mono are
© IBM Corp., licensed under the SIL Open Font Licence 1.1.
