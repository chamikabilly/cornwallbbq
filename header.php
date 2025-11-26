<?php

/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Miheli_Solutions
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>
	<div id="page" class="site">
		<a class="skip-link screen-reader-text"
			href="#primary"><?php esc_html_e('Skip to content', 'miheli-solutions'); ?></a>

		<?php
		// Define cart variables at the top so they're available everywhere
		$cart_url = home_url('/cart');
		$cart_count = 0;
		$account_url = wp_login_url();

		if (class_exists('WooCommerce')) {
			$cart_url = wc_get_cart_url();
			if (function_exists('wc_get_page_permalink')) {
				$account_url = wc_get_page_permalink('myaccount') ?: $account_url;
			}
			if (function_exists('WC') && WC()->cart) {
				$cart_count = WC()->cart->get_cart_contents_count();
			}
		}
		?>

		<header id="masthead" class="site-header">
			<div class="header-container container">
				<div class="site-branding">
					<?php the_custom_logo(); ?>
				</div>

				<!-- Mobile Menu Toggle -->
				<button class="mobile-menu-toggle" aria-label="Toggle menu">
					<span class="hamburger-line"></span>
					<span class="hamburger-line"></span>
					<span class="hamburger-line"></span>
				</button>

				<div class="nav-container">
					<!-- Mobile Menu Close Button -->
					<button class="mobile-menu-close" aria-label="Close menu">
						<i class="fa-solid fa-times"></i>
					</button>

					<nav id="site-navigation" class="main-navigation">
						<?php
						wp_nav_menu(
							array(
								'theme_location' => 'menu-1',
								'menu_id' => 'primary-menu',
								'menu_class' => 'primary-menu',
							)
						);
						?>
					</nav>

					<div class="site-cart-account">
						<!-- SEARCH: toggle button + inline/hidden form -->
						<button type="button" class="icon-btn search-toggle" aria-expanded="false"
							aria-controls="header-search" id="search-toggle">
							<i class="fa-solid fa-magnifying-glass"></i>
							<span class="screen-reader-text">Search</span>
						</button>

						<div id="header-search" class="header-search">
							<?php
							// Prefer WooCommerce product search if available
							if (function_exists('get_product_search_form')) {
								ob_start();
								get_product_search_form();
								echo ob_get_clean();
							} else {
								get_search_form();
							}
							?>
							<button class="search-close" aria-label="Close search">
								<i class="fa-solid fa-times"></i>
							</button>
						</div>

						<!-- CART: link with count (works when WooCommerce active) -->
						<?php
						$header_count = intval($cart_count);
						?>
						<a class="icon-btn site-cart open-cart-drawer" href="<?php echo esc_url($cart_url); ?>"
							aria-label="<?php esc_attr_e('Open cart', 'miheli-solutions'); ?>" data-open-drawer="1">
							<i class="fa-solid fa-cart-shopping" aria-hidden="true"></i>
							<span class="cart-count <?php echo $header_count ? 'has-count' : ''; ?>"
								data-count="<?php echo $header_count; ?>"
								aria-hidden="true"><?php echo $header_count; ?></span>
						</a>



						<!-- ACCOUNT: My Account or Login -->
						<a class="icon-btn site-account" href="<?php echo esc_url($account_url); ?>"
							aria-label="My account">
							<i class="fa-regular fa-user" aria-hidden="true"></i>
						</a>
					</div>
				</div>
			</div>
		</header>

		<!-- Mobile Bottom Navigation -->
		<nav class="mobile-bottom-nav">
			<div class="mobile-nav-container">
				<a href="<?php echo esc_url(home_url()); ?>" class="mobile-nav-item" aria-label="Home">
					<i class="fa-solid fa-house"></i>
					<span class="mobile-nav-label">Home</span>
				</a>

				<button class="mobile-nav-item mobile-search-toggle" aria-expanded="false"
					aria-controls="header-search">
					<i class="fa-solid fa-magnifying-glass"></i>
					<span class="mobile-nav-label">Search</span>
				</button>

				<a href="<?php echo esc_url($cart_url); ?>" class="mobile-nav-item mobile-cart open-cart-drawer"
					aria-label="Cart" data-open-drawer="1">
					<div class="mobile-cart-icon">
						<i class="fa-solid fa-cart-shopping"></i>
						<span class="mobile-cart-count <?php echo $header_count ? 'has-count' : ''; ?>"
							data-count="<?php echo $header_count; ?>"
							aria-hidden="true"><?php echo $header_count; ?></span>
					</div>
					<span class="mobile-nav-label">Cart</span>
				</a>


				<a href="<?php echo esc_url($account_url); ?>" class="mobile-nav-item" aria-label="Account">
					<i class="fa-regular fa-user"></i>
					<span class="mobile-nav-label">Account</span>
				</a>

				<button class="mobile-nav-item mobile-menu-toggle-bottom" aria-label="Menu">
					<div class="mobile-menu-icon">
						<span class="menu-line"></span>
						<span class="menu-line"></span>
						<span class="menu-line"></span>
					</div>
					<span class="mobile-nav-label">Menu</span>
				</button>
			</div>
		</nav>


		<?php if ((is_page() && !is_front_page()) || is_home()) { ?>

			<section class="title-holder">
				<div class="container">
					<div class="row">
						<div class="col-12">
							<h1 class="header-page-title">
								<?php
								if (is_home()) {
									// Get the title of the page set as posts page
									$blog_page_id = get_option('page_for_posts');
									echo get_the_title($blog_page_id);
								} else {
									the_title();
								}
								?>
							</h1>

							<?php
							if (function_exists('yoast_breadcrumb')) {
								yoast_breadcrumb('<div class="breadcrumbs">', '</div>');
							} else if (function_exists('rank_math_the_breadcrumbs')) {
								echo '<div class="breadcrumbs">';
								rank_math_the_breadcrumbs();
								echo '</div>';
							} else {
								custom_breadcrumbs();
							}
							?>
						</div>
					</div>
				</div>
			</section>

		<?php } ?>