# Eggxi WP Theme Scaffold Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Scaffold a classic WordPress theme in `eggxi-wp/` with full template set, setup/enqueue includes, and assets copied from `eggxi-html`.

**Architecture:** Flat theme root. Root `style.css` is WP metadata only. Visual CSS/JS/fonts/images live under `assets/` (copied from HTML). `functions.php` loads `inc/setup.php` and `inc/enqueue.php`. Templates use a minimal WP shell and standard Loop stubs.

**Tech Stack:** WordPress classic PHP theme, Bootstrap 4 asset stack from Eggxi HTML, no build step.

## Global Constraints

- Theme path: `G:\kodesolution\htdocs\unlockdesign\eggxi-wp\` (folder *is* the theme)
- Source assets: `G:\kodesolution\htdocs\unlockdesign\eggxi-html\{css,js,fonts,images}`
- Do not port full Eggxi header/footer HTML in this plan
- Do not commit unless the user explicitly asks
- Do not create a full WordPress core install

## File map

| File | Responsibility |
|------|----------------|
| `style.css` | Theme header metadata only |
| `functions.php` | Bootstrap theme; require `inc/*` |
| `inc/setup.php` | Supports, menus, sidebars |
| `inc/enqueue.php` | Enqueue CSS/JS from `assets/` |
| `header.php` / `footer.php` | Minimal WP document shell |
| `index.php`, `front-page.php`, `home.php`, `single.php`, `page.php`, `archive.php`, `search.php`, `404.php` | Template entry points |
| `sidebar.php`, `comments.php` | Sidebar + comments stubs |
| `template-parts/content.php`, `content-none.php` | Loop partials |
| `assets/*` | Copied HTML assets |

---

### Task 1: Copy assets from HTML package

**Files:**
- Create: `assets/css/` (copy of `eggxi-html/css/`)
- Create: `assets/js/` (copy of `eggxi-html/js/`)
- Create: `assets/fonts/` (copy of `eggxi-html/fonts/`)
- Create: `assets/images/` (copy of `eggxi-html/images/`)

**Interfaces:**
- Consumes: HTML asset directories on disk
- Produces: Theme-relative URIs usable as `get_template_directory_uri() . '/assets/...'`

- [ ] **Step 1: Create asset directories and copy**

Run (PowerShell):

```powershell
$src = "G:\kodesolution\htdocs\unlockdesign\eggxi-html"
$dst = "G:\kodesolution\htdocs\unlockdesign\eggxi-wp\assets"
New-Item -ItemType Directory -Force -Path $dst | Out-Null
Copy-Item -Recurse -Force "$src\css" "$dst\css"
Copy-Item -Recurse -Force "$src\js" "$dst\js"
Copy-Item -Recurse -Force "$src\fonts" "$dst\fonts"
Copy-Item -Recurse -Force "$src\images" "$dst\images"
```

- [ ] **Step 2: Verify copy**

Run:

```powershell
@("css","js","fonts","images") | ForEach-Object {
  $p = "G:\kodesolution\htdocs\unlockdesign\eggxi-wp\assets\$_"
  "$_ : $((Get-ChildItem $p -Recurse -File | Measure-Object).Count) files"
}
Test-Path "G:\kodesolution\htdocs\unlockdesign\eggxi-wp\assets\css\bootstrap.min.css"
Test-Path "G:\kodesolution\htdocs\unlockdesign\eggxi-wp\assets\js\script.js"
```

Expected: each folder has files; both `Test-Path` results are `True`.

---

### Task 2: Theme bootstrap (`style.css`, `functions.php`, `inc/`)

**Files:**
- Create: `style.css`
- Create: `functions.php`
- Create: `inc/setup.php`
- Create: `inc/enqueue.php`

**Interfaces:**
- Consumes: `assets/` from Task 1
- Produces: `eggxi_setup()`, `eggxi_widgets_init()`, `eggxi_scripts()` hooked correctly

- [ ] **Step 1: Create `style.css`**

```css
/*
Theme Name: Eggxi
Theme URI: https://unlockdesign.com/
Author: unlockdesign
Author URI: https://unlockdesign.com/
Description: Eggxi personal blog theme converted from the Eggxi Bootstrap 4 HTML template.
Version: 1.0.0
Requires at least: 6.0
Tested up to: 6.7
Requires PHP: 7.4
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Text Domain: eggxi
Tags: blog, custom-logo, custom-menu, featured-images, threaded-comments, translation-ready
*/
```

- [ ] **Step 2: Create `inc/setup.php`**

```php
<?php
/**
 * Theme setup: supports, menus, widgets.
 *
 * @package Eggxi
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register theme supports and navigation menus.
 */
function eggxi_setup() {
	load_theme_textdomain( 'eggxi', get_template_directory() . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);
	add_theme_support( 'custom-logo', array(
		'height'      => 80,
		'width'       => 240,
		'flex-height' => true,
		'flex-width'  => true,
	) );
	add_theme_support(
		'post-formats',
		array( 'image', 'gallery', 'video', 'audio' )
	);

	register_nav_menus(
		array(
			'primary'    => __( 'Primary Menu', 'eggxi' ),
			'header-top' => __( 'Header Top Menu', 'eggxi' ),
			'footer'     => __( 'Footer Menu', 'eggxi' ),
		)
	);
}
add_action( 'after_setup_theme', 'eggxi_setup' );

/**
 * Register widget areas.
 */
function eggxi_widgets_init() {
	register_sidebar(
		array(
			'name'          => __( 'Blog Sidebar', 'eggxi' ),
			'id'            => 'sidebar-1',
			'description'   => __( 'Widgets for blog and single post sidebars.', 'eggxi' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);

	register_sidebar(
		array(
			'name'          => __( 'Footer', 'eggxi' ),
			'id'            => 'footer-1',
			'description'   => __( 'Footer widget area.', 'eggxi' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);
}
add_action( 'widgets_init', 'eggxi_widgets_init' );
```

- [ ] **Step 3: Create `inc/enqueue.php`**

```php
<?php
/**
 * Enqueue scripts and styles.
 *
 * @package Eggxi
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue front-end assets from /assets.
 */
function eggxi_scripts() {
	$uri = get_template_directory_uri() . '/assets';
	$ver = wp_get_theme()->get( 'Version' );

	wp_enqueue_style( 'eggxi-bootstrap', $uri . '/css/bootstrap.min.css', array(), $ver );
	wp_enqueue_style( 'eggxi-plugins', $uri . '/css/all-plugins.css', array( 'eggxi-bootstrap' ), $ver );
	wp_enqueue_style( 'eggxi-main', $uri . '/css/style.css', array( 'eggxi-plugins' ), $ver );
	wp_enqueue_style( 'eggxi-theme-color', $uri . '/css/theme-color.css', array( 'eggxi-main' ), $ver );
	wp_enqueue_style( 'eggxi-responsive', $uri . '/css/responsive.css', array( 'eggxi-theme-color' ), $ver );

	wp_enqueue_script( 'eggxi-popper', $uri . '/js/popper.min.js', array( 'jquery' ), $ver, true );
	wp_enqueue_script( 'eggxi-bootstrap', $uri . '/js/bootstrap.min.js', array( 'jquery', 'eggxi-popper' ), $ver, true );
	wp_enqueue_script( 'eggxi-bootsnav', $uri . '/js/bootsnav.js', array( 'jquery', 'eggxi-bootstrap' ), $ver, true );
	wp_enqueue_script( 'eggxi-mmenu', $uri . '/js/jquery.mmenu.all.js', array( 'jquery' ), $ver, true );
	wp_enqueue_script( 'eggxi-bootstrap-select', $uri . '/js/bootstrap-select.min.js', array( 'jquery', 'eggxi-bootstrap' ), $ver, true );
	wp_enqueue_script( 'eggxi-parallax', $uri . '/js/parallax.js', array( 'jquery' ), $ver, true );
	wp_enqueue_script( 'eggxi-scrollto', $uri . '/js/scrollto.js', array( 'jquery' ), $ver, true );
	wp_enqueue_script( 'eggxi-scrolltofixed', $uri . '/js/jquery-scrolltofixed-min.js', array( 'jquery' ), $ver, true );
	wp_enqueue_script( 'eggxi-counterup', $uri . '/js/jquery.counterup.js', array( 'jquery' ), $ver, true );
	wp_enqueue_script( 'eggxi-gallery', $uri . '/js/gallery.js', array( 'jquery' ), $ver, true );
	wp_enqueue_script( 'eggxi-wow', $uri . '/js/wow.min.js', array( 'jquery' ), $ver, true );
	wp_enqueue_script( 'eggxi-slider', $uri . '/js/slider.js', array( 'jquery' ), $ver, true );
	wp_enqueue_script( 'eggxi-video-player', $uri . '/js/video-player.js', array( 'jquery' ), $ver, true );
	wp_enqueue_script( 'eggxi-timepicker', $uri . '/js/timepicker.js', array( 'jquery' ), $ver, true );
	wp_enqueue_script( 'eggxi-tweetie', $uri . '/js/tweetie.js', array( 'jquery' ), $ver, true );
	wp_enqueue_script( 'eggxi-mc-validator', $uri . '/js/mc-validator.js', array( 'jquery' ), $ver, true );
	wp_enqueue_script( 'eggxi-script', $uri . '/js/script.js', array( 'jquery', 'eggxi-bootstrap', 'eggxi-bootsnav' ), $ver, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'eggxi_scripts' );
```

- [ ] **Step 4: Create `functions.php`**

```php
<?php
/**
 * Eggxi theme functions.
 *
 * @package Eggxi
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'EGGXI_VERSION', '1.0.0' );
define( 'EGGXI_DIR', get_template_directory() );
define( 'EGGXI_URI', get_template_directory_uri() );

require EGGXI_DIR . '/inc/setup.php';
require EGGXI_DIR . '/inc/enqueue.php';
```

- [ ] **Step 5: PHP lint bootstrap files**

Run:

```powershell
php -l "G:\kodesolution\htdocs\unlockdesign\eggxi-wp\functions.php"
php -l "G:\kodesolution\htdocs\unlockdesign\eggxi-wp\inc\setup.php"
php -l "G:\kodesolution\htdocs\unlockdesign\eggxi-wp\inc\enqueue.php"
```

Expected: each prints `No syntax errors detected`.

---

### Task 3: Header, footer, sidebar, comments, template-parts

**Files:**
- Create: `header.php`, `footer.php`, `sidebar.php`, `comments.php`
- Create: `template-parts/content.php`, `template-parts/content-none.php`

**Interfaces:**
- Consumes: menus/sidebars from `eggxi_setup` / `eggxi_widgets_init`
- Produces: `get_header()` / `get_footer()` / `get_sidebar()` usable from templates

- [ ] **Step 1: Create `header.php`**

```php
<?php
/**
 * Theme header.
 *
 * @package Eggxi
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div class="wrapper ovh">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'eggxi' ); ?></a>
```

- [ ] **Step 2: Create `footer.php`**

```php
<?php
/**
 * Theme footer.
 *
 * @package Eggxi
 */
?>
	<footer class="site-footer">
		<?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
			<div class="footer-widgets">
				<?php dynamic_sidebar( 'footer-1' ); ?>
			</div>
		<?php endif; ?>
		<p class="site-info">
			&copy; <?php echo esc_html( date_i18n( 'Y' ) ); ?>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
		</p>
	</footer>
</div><!-- .wrapper -->
<?php wp_footer(); ?>
</body>
</html>
```

- [ ] **Step 3: Create `sidebar.php`**

```php
<?php
/**
 * Primary sidebar.
 *
 * @package Eggxi
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>
<aside id="secondary" class="widget-area" role="complementary">
	<?php dynamic_sidebar( 'sidebar-1' ); ?>
</aside>
```

- [ ] **Step 4: Create `comments.php`**

```php
<?php
/**
 * Comments template.
 *
 * @package Eggxi
 */

if ( post_password_required() ) {
	return;
}
?>
<div id="comments" class="comments-area">
	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title">
			<?php
			$eggxi_count = get_comments_number();
			printf(
				/* translators: 1: comment count number, 2: post title. */
				esc_html( _nx( '%1$s thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', $eggxi_count, 'comments title', 'eggxi' ) ),
				esc_html( number_format_i18n( $eggxi_count ) ),
				esc_html( get_the_title() )
			);
			?>
		</h2>
		<ol class="comment-list">
			<?php
			wp_list_comments(
				array(
					'style'      => 'ol',
					'short_ping' => true,
				)
			);
			?>
		</ol>
		<?php the_comments_navigation(); ?>
	<?php endif; ?>

	<?php if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
		<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'eggxi' ); ?></p>
	<?php endif; ?>

	<?php comment_form(); ?>
</div>
```

- [ ] **Step 5: Create `template-parts/content.php`**

```php
<?php
/**
 * Default post/page content partial.
 *
 * @package Eggxi
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php
		if ( is_singular() ) {
			the_title( '<h1 class="entry-title">', '</h1>' );
		} else {
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		}
		?>
	</header>

	<?php if ( has_post_thumbnail() && ! is_singular() ) : ?>
		<div class="post-thumbnail">
			<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'large' ); ?></a>
		</div>
	<?php endif; ?>

	<div class="entry-content">
		<?php
		if ( is_singular() ) {
			the_content();
			wp_link_pages();
		} else {
			the_excerpt();
		}
		?>
	</div>
</article>
```

- [ ] **Step 6: Create `template-parts/content-none.php`**

```php
<?php
/**
 * No results partial.
 *
 * @package Eggxi
 */
?>
<section class="no-results not-found">
	<header class="page-header">
		<h1 class="page-title"><?php esc_html_e( 'Nothing Found', 'eggxi' ); ?></h1>
	</header>
	<div class="page-content">
		<?php if ( is_search() ) : ?>
			<p><?php esc_html_e( 'Sorry, nothing matched your search. Please try again.', 'eggxi' ); ?></p>
			<?php get_search_form(); ?>
		<?php else : ?>
			<p><?php esc_html_e( 'It looks like nothing was found at this location.', 'eggxi' ); ?></p>
			<?php get_search_form(); ?>
		<?php endif; ?>
	</div>
</section>
```

- [ ] **Step 7: PHP lint these files**

Run `php -l` on each new PHP file in this task. Expected: no syntax errors.

---

### Task 4: Main template files

**Files:**
- Create: `index.php`, `front-page.php`, `home.php`, `single.php`, `page.php`, `archive.php`, `search.php`, `404.php`

**Interfaces:**
- Consumes: header/footer/sidebar/template-parts from Task 3
- Produces: Recognizable WP theme with Loop on all major views

- [ ] **Step 1: Create `index.php`**

```php
<?php
/**
 * Main fallback template.
 *
 * @package Eggxi
 */

get_header();
?>
<main id="primary" class="site-main">
	<?php if ( have_posts() ) : ?>
		<?php while ( have_posts() ) : ?>
			<?php the_post(); ?>
			<?php get_template_part( 'template-parts/content' ); ?>
		<?php endwhile; ?>
		<?php the_posts_navigation(); ?>
	<?php else : ?>
		<?php get_template_part( 'template-parts/content', 'none' ); ?>
	<?php endif; ?>
</main>
<?php
get_sidebar();
get_footer();
```

- [ ] **Step 2: Create `front-page.php`**

```php
<?php
/**
 * Front page template (homepage sections ported later).
 *
 * @package Eggxi
 */

get_header();
?>
<main id="primary" class="site-main">
	<?php if ( have_posts() ) : ?>
		<?php while ( have_posts() ) : ?>
			<?php the_post(); ?>
			<?php get_template_part( 'template-parts/content' ); ?>
		<?php endwhile; ?>
	<?php else : ?>
		<?php get_template_part( 'template-parts/content', 'none' ); ?>
	<?php endif; ?>
</main>
<?php
get_footer();
```

- [ ] **Step 3: Create `home.php`**

```php
<?php
/**
 * Blog posts index.
 *
 * @package Eggxi
 */

get_header();
?>
<main id="primary" class="site-main">
	<?php if ( have_posts() ) : ?>
		<header class="page-header">
			<h1 class="page-title"><?php esc_html_e( 'Blog', 'eggxi' ); ?></h1>
		</header>
		<?php while ( have_posts() ) : ?>
			<?php the_post(); ?>
			<?php get_template_part( 'template-parts/content' ); ?>
		<?php endwhile; ?>
		<?php the_posts_navigation(); ?>
	<?php else : ?>
		<?php get_template_part( 'template-parts/content', 'none' ); ?>
	<?php endif; ?>
</main>
<?php
get_sidebar();
get_footer();
```

- [ ] **Step 4: Create `single.php`**

```php
<?php
/**
 * Single post template.
 *
 * @package Eggxi
 */

get_header();
?>
<main id="primary" class="site-main">
	<?php while ( have_posts() ) : ?>
		<?php the_post(); ?>
		<?php get_template_part( 'template-parts/content' ); ?>
		<?php the_post_navigation(); ?>
		<?php
		if ( comments_open() || get_comments_number() ) {
			comments_template();
		}
		?>
	<?php endwhile; ?>
</main>
<?php
get_sidebar();
get_footer();
```

- [ ] **Step 5: Create `page.php`**

```php
<?php
/**
 * Page template.
 *
 * @package Eggxi
 */

get_header();
?>
<main id="primary" class="site-main">
	<?php while ( have_posts() ) : ?>
		<?php the_post(); ?>
		<?php get_template_part( 'template-parts/content' ); ?>
		<?php
		if ( comments_open() || get_comments_number() ) {
			comments_template();
		}
		?>
	<?php endwhile; ?>
</main>
<?php
get_footer();
```

- [ ] **Step 6: Create `archive.php`**

```php
<?php
/**
 * Archive template.
 *
 * @package Eggxi
 */

get_header();
?>
<main id="primary" class="site-main">
	<?php if ( have_posts() ) : ?>
		<header class="page-header">
			<?php the_archive_title( '<h1 class="page-title">', '</h1>' ); ?>
			<?php the_archive_description( '<div class="archive-description">', '</div>' ); ?>
		</header>
		<?php while ( have_posts() ) : ?>
			<?php the_post(); ?>
			<?php get_template_part( 'template-parts/content' ); ?>
		<?php endwhile; ?>
		<?php the_posts_navigation(); ?>
	<?php else : ?>
		<?php get_template_part( 'template-parts/content', 'none' ); ?>
	<?php endif; ?>
</main>
<?php
get_sidebar();
get_footer();
```

- [ ] **Step 7: Create `search.php`**

```php
<?php
/**
 * Search results template.
 *
 * @package Eggxi
 */

get_header();
?>
<main id="primary" class="site-main">
	<?php if ( have_posts() ) : ?>
		<header class="page-header">
			<h1 class="page-title">
				<?php
				printf(
					/* translators: %s: search query. */
					esc_html__( 'Search Results for: %s', 'eggxi' ),
					'<span>' . esc_html( get_search_query() ) . '</span>'
				);
				?>
			</h1>
		</header>
		<?php while ( have_posts() ) : ?>
			<?php the_post(); ?>
			<?php get_template_part( 'template-parts/content' ); ?>
		<?php endwhile; ?>
		<?php the_posts_navigation(); ?>
	<?php else : ?>
		<?php get_template_part( 'template-parts/content', 'none' ); ?>
	<?php endif; ?>
</main>
<?php
get_sidebar();
get_footer();
```

- [ ] **Step 8: Create `404.php`**

```php
<?php
/**
 * 404 template.
 *
 * @package Eggxi
 */

get_header();
?>
<main id="primary" class="site-main">
	<section class="error-404 not-found">
		<header class="page-header">
			<h1 class="page-title"><?php esc_html_e( 'Page Not Found', 'eggxi' ); ?></h1>
		</header>
		<div class="page-content">
			<p><?php esc_html_e( 'It looks like nothing was found at this location. Try a search.', 'eggxi' ); ?></p>
			<?php get_search_form(); ?>
		</div>
	</section>
</main>
<?php
get_footer();
```

- [ ] **Step 9: Final verification**

Run:

```powershell
$root = "G:\kodesolution\htdocs\unlockdesign\eggxi-wp"
$required = @(
  "style.css","functions.php","header.php","footer.php","index.php",
  "front-page.php","home.php","single.php","page.php","archive.php",
  "search.php","404.php","comments.php","sidebar.php",
  "inc\setup.php","inc\enqueue.php",
  "template-parts\content.php","template-parts\content-none.php",
  "assets\css\style.css","assets\js\script.js"
)
$required | ForEach-Object {
  $ok = Test-Path (Join-Path $root $_)
  "{0} {1}" -f ($(if ($ok) {'OK'} else {'MISSING'}), $_)
}
Get-ChildItem $root -Filter "*.php" -Recurse | ForEach-Object { php -l $_.FullName }
```

Expected: all paths `OK`; all PHP files report no syntax errors. Theme header present in `style.css`.

---

## Spec coverage check

| Spec requirement | Task |
|------------------|------|
| Flat theme root | Tasks 1–4 |
| Copy assets | Task 1 |
| `style.css` metadata | Task 2 |
| Menus + sidebars + supports | Task 2 (`setup.php`) |
| Enqueue CSS/JS stack | Task 2 (`enqueue.php`) |
| Full classic templates | Task 4 |
| `template-parts` | Task 3 |
| Minimal header/footer (no Eggxi chrome yet) | Task 3 |
| Out of scope items skipped | — |
