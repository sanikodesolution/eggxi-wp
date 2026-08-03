# Eggxi WP Theme Scaffold Design

**Date:** 2026-08-03  
**Status:** Approved (pending final spec review)  
**Source HTML:** `eggxi-html/`  
**Output:** `eggxi-wp/` as a drop-in classic WordPress theme

## Goal

Create a basic classic PHP theme structure in `eggxi-wp` so Eggxi HTML can be converted page-by-page into WordPress. This pass is scaffolding only — not a full visual port.

## Decisions

| Decision | Choice |
|----------|--------|
| Package type | Theme only (not a full WP install) |
| Theme layout | Flat root — `eggxi-wp/` *is* the theme |
| Assets | Copy CSS/JS/fonts/images from `eggxi-html` into `assets/` |
| Templates | Full classic set + `template-parts/` stubs |
| Markup port | Deferred — header/footer use minimal WP shell for now |

## Folder structure

```
eggxi-wp/
  style.css                 # Theme metadata header only
  functions.php
  header.php
  footer.php
  index.php
  front-page.php
  home.php
  single.php
  page.php
  archive.php
  search.php
  404.php
  comments.php
  sidebar.php
  inc/
    setup.php               # supports, menus, widget areas
    enqueue.php             # styles & scripts
  template-parts/
    content.php
    content-none.php
  assets/
    css/                    # from eggxi-html/css
    js/                     # from eggxi-html/js
    fonts/                  # from eggxi-html/fonts
    images/                 # from eggxi-html/images
  docs/superpowers/specs/   # this design doc
```

## Theme setup (`inc/setup.php`)

- `after_setup_theme` callback:
  - `title-tag`
  - `post-thumbnails`
  - `html5` (search-form, comment-form, comment-list, gallery, caption, style, script)
  - `custom-logo`
  - post formats: `image`, `gallery`, `video`, `audio` (matches HTML demos)
- Nav menus: `primary`, `header-top`, `footer`
- Widget areas: `sidebar-1` (Blog Sidebar), `footer-1` (Footer)

## Enqueue (`inc/enqueue.php`)

Enqueue from `assets/` in HTML order:

**CSS:** `bootstrap.min.css` → `all-plugins.css` → `style.css` (theme assets, not root `style.css`) → `theme-color.css` → `responsive.css`

**JS:** jQuery (WP bundled preferred; deregister conflict if needed later) → Popper → Bootstrap → bootsnav → mmenu → bootstrap-select → parallax → scrollto → scrolltofixed → counterup → gallery → wow → slider → video-player → timepicker → tweetie → theme `script.js`

Root `style.css` remains metadata-only for WordPress; visual CSS lives at `assets/css/style.css`.

## Template behavior (this pass)

- `header.php` / `footer.php`: valid WP document shell (`language_attributes`, `wp_head`, `body_class`, `wp_body_open`, `wp_footer`). No full Eggxi chrome yet.
- Content templates: standard Loop with `get_template_part( 'template-parts/content' )`.
- `front-page.php` / `home.php`: placeholder loops ready for homepage sections later.
- `sidebar.php`: `dynamic_sidebar( 'sidebar-1' )`.
- `comments.php`: standard comment list + form stub.

## Out of scope

- Porting Eggxi header/nav/footer HTML
- Front-page section markup
- Customizer / theme options
- Contact form backend
- RTL stylesheet switching UI
- Screenshot / ThemeForest packaging extras
- Committing or installing into a live `wp-content/themes` path

## Success criteria

1. `eggxi-wp/style.css` has a valid WordPress theme header so WP recognizes the theme.
2. All listed PHP templates and `inc/` files exist.
3. `assets/{css,js,fonts,images}` contain copied HTML assets.
4. Activating the theme does not fatally error (blank/minimal front output is OK).
5. Ready for a follow-up pass to port `index.html` shell into `header.php` / `footer.php`.

## Follow-up (after scaffold)

1. Port shared header/footer from `eggxi-html/index.html`.
2. Map blog layouts and post formats.
3. Build `front-page.php` sections from homepage HTML.
