# Featured Post Title Fit & Readability

**Date:** 2026-08-04  
**Theme:** Eggxi WP  
**Status:** Approved approach A — awaiting implementation after review

## Problem

In the Featured Post grid (`.feature_blog_post`), long post titles on `.home1_blog_post.style2` / `.style3` / `.style4` cards:

1. Use white text over bright/busy images with only a partial bottom gradient, so titles are hard to read.
2. Inherit large `h4`/`h5` sizing and wrap into many lines, eating most of the card and crowding meta.
3. On the shorter `.style4` cards (~235px), titles clip or overflow awkwardly.

## Goal

Make featured-card titles readable and compact without changing PHP markup or truncating titles in the HTML.

## Approach (A — CSS override)

Add scoped overrides in the theme root `style.css` (already used for small theme patches). Do **not** edit the large compiled `assets/css/style.css` unless later required.

### Scope

Only:

```css
.feature_blog_post .home1_blog_post …
```

Do not change other `.home1_blog_post` usages outside the featured grid.

### Changes

1. **Stronger overlay**  
   Increase bottom gradient coverage/opacity on `.thumb .overlay` so white text stays readable on light images (especially style3/style4).

2. **Smaller title sizes**  
   - style2 (large left): ~22px  
   - style3 (middle tall): ~18px  
   - style4 (right stack): ~15–16px  
   Tight line-height (~1.25–1.35).

3. **Line clamp**  
   - style2 / style3: max 3 lines  
   - style4: max 2 lines  
   Use `-webkit-line-clamp` + overflow hidden so excess ends with ellipsis.

4. **Contrast aid**  
   Light `text-shadow` on `.details .title` / links (and optionally meta) so text holds up if the image still shows through.

5. **Leave alone**  
   Category badges, meta icons, card heights, and grid markup in `content-featured-grid.php`.

## Out of scope

- PHP title truncation (`wp_trim_words`)
- Redesigning the featured grid layout
- Global typography changes outside this section

## Success criteria

- Titles remain readable on light and dark featured images.
- Titles no longer dominate the card height; image area stays visible.
- Cards stay visually aligned; no overflow outside the card.
- Desktop and mobile layouts still look correct after a hard refresh.

## Implementation notes

- Prefer theme `style.css` so overrides load with the theme stylesheet and survive template HTML updates.
- Keep selectors specific to `.feature_blog_post` to avoid side effects on other blog cards.
