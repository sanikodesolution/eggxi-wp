# Featured Post Title Fit Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Make Featured Post grid titles readable and compact via CSS overrides only.

**Architecture:** Scoped CSS in theme root `style.css` under `.feature_blog_post .home1_blog_post`. Stronger bottom overlay, smaller title sizes, line-clamp, light text-shadow. No PHP/markup changes.

**Tech Stack:** WordPress theme CSS (`eggxi-wp/style.css`)

## Global Constraints

- Scope only to `.feature_blog_post` featured grid cards
- Do not edit compiled `assets/css/style.css` for this fix
- Do not truncate titles in PHP
- Keep badges/meta/card heights unchanged

---

## File map

| File | Responsibility |
|------|----------------|
| `style.css` | Theme overrides for featured title fit/readability |
| `docs/superpowers/specs/2026-08-04-featured-post-title-fit-design.md` | Approved design (reference only) |

---

### Task 1: Add featured title CSS overrides

**Files:**
- Modify: `style.css`

- [ ] **Step 1:** Append a `/* Featured Post grid — title fit & readability */` block to `style.css` with:
  - Deeper/taller `.thumb .overlay` gradient (style2/3 ~65–75%, style4 ~80%)
  - Title sizes: style2 `22px`, style3 `18px`, style4 `15px`; line-height `1.3`
  - Line-clamp: style2/3 = 3 lines; style4 = 2 lines
  - `text-shadow: 0 1px 2px rgba(0,0,0,.55)` on titles/links
- [ ] **Step 2:** If WP install has a separate copy at `wp-content/themes/eggxi-wp`, mirror the same CSS there so the live site picks it up
- [ ] **Step 3:** Hard-refresh homepage Featured Post section and confirm titles are readable, clamped, and do not overflow cards

---

### Task 2: Done when

- Featured titles readable on light images
- Titles no longer dominate card height
- No overflow outside cards on desktop/mobile
