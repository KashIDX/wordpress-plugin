<?php
/**
 * Single Listing Template: Luxurious
 * Description: Large photo, dark, modern template
 * Version: 1.3.3
 *
 * @package WordPress
 *
 * Changelog:
 * 1.3.4 - Fix Google map not displaying
 * 1.3.3 - Fix display issues in First Impression theme
 * 1.3.2 - Fix issue with Google map not displaying
 * 1.3.1 - Fix issue with contact form not displaying
 * 1.3 - Updated with IMPress Agents support, currency support, and global disclaimer
 * 1.2 - Update with new fields, auto-map, and more
 * 1.1.7 - Update for Equity framework themes
 * 1.1.6 - Remove top header on Curb Appeal Evolved theme
 * 1.1.5 - Update call for font awesome icons
 * 1.1.4 - Add additional classes for older Genesis themes
 * 1.1.3 - Fix to remove post info on non-HTML5 themes
 * 1.1.2 - Update to add priority to author box removal
 * 1.1.1 - Update for conditional connected agents function call
 * 1.1 - Update for error in XHTML/HTML5 hook
 * 1.0 - Initial release
 */

add_filter( 'body_class', 'single_listing_class' );
/**
 * Single_Listing_Class function.
 *
 * @param array $classes - Array of Classes.
 * @return array
 */
function single_listing_class( $classes ) {
	$classes[] = 'listing-template-custom';

	return $classes;
}

add_action( 'wp_enqueue_scripts', 'enqueue_single_listing_scripts' );
/**
 * Enqueue_Single_Listing_Scripts function.
 *
 * @return void
 */
function enqueue_single_listing_scripts() {
	// Template Styles.
	wp_register_style( 'wplistings-google-fonts', '//fonts.googleapis.com/css?family=Lato:700,400,300', [], '1.0' );
	wp_enqueue_style( 'font-awesome-5.8.2' );
	wp_enqueue_style( 'wplistings-google-fonts' );
	wp_enqueue_style( 'impb-luxurious-template', IMPRESS_IDX_URL . 'assets/css/listing-templates/single-listing-luxurious.min.css', [], '1.0' );
	// Template Scripts.
	wp_enqueue_script( 'fitvids' );
	wp_enqueue_script( 'jquery-validate' );
	wp_enqueue_script( 'wp-listings-single' );
	// Dequeue any known themes that conflict with single page listing layout.
	wp_dequeue_style( 'twenty-twenty-one-style' );
}

/**
 * Single_Listing_Post_Content function.
 *
 * @return void
 */
function single_listing_post_content() {

	global $post;
	$options = get_option( 'plugin_wp_listings_settings' );

	?>

	<div class="entry-content wplistings-single-listing listing-template">

		<header class="entry-header"><?php the_title( '<h1 class="entry-title">', '</h1>' ); ?></header><!-- .entry-header -->

		<div class="listing-image-wrap">

			<?php
			// Output featured image.
			echo get_the_post_thumbnail( $post->ID, 'listings-full', [ 'class' => 'single-listing-image' ] );

			// output status.
			if ( ! empty( wp_listings_get_status() ) ) {
				printf( '<span class="listing-status %s">%s</span>', esc_attr( strtolower( wp_listings_get_status() ) ), esc_html( wp_listings_get_status() ) );
			}

			// open house info.
			if ( ! empty( get_post_meta( $post->ID, '_listing_open_house', true ) ) ) {
				printf( '<span class="listing-open-house">Open House: %s</span>', esc_html( get_post_meta( $post->ID, '_listing_open_house', true ) ) );
			}

			// output listing meta data.
			echo '<ul class="listing-meta">';

			if ( get_post_meta( $post->ID, '_listing_hide_price', true ) == 1 ) {
				echo ( get_post_meta( $post->ID, '_listing_price_alt', true ) ) ? sprintf( '<li class="listing-price">%s</li>', esc_html( get_post_meta( $post->ID, '_listing_price_alt', true ) ) ) : '';
			} elseif ( get_post_meta( $post->ID, '_listing_price', true ) ) {
				$currency_symbol = ( empty( $options['wp_listings_currency_symbol'] ) || 'none' === $options['wp_listings_currency_symbol'] ) ? '' : $options['wp_listings_currency_symbol'];
				$currency_code   = ( ! empty( $options['wp_listings_display_currency_code'] ) && ! empty( $options['wp_listings_display_currency_code'] ) && 'none' !== $options['wp_listings_currency_code'] ) ? '<span class="currency-code">' . $options['wp_listings_currency_code'] . '</span>' : '';
				printf( '<li class="listing-price">%s%s %s</li>', esc_html( $currency_symbol ), esc_html( get_post_meta( $post->ID, '_listing_price', true ) ), esc_html( $currency_code ) );
			}

			echo '<ul>';

			printf( '<li class="listing-address"><span class="label">Address: </span><br /><span class="listing-address">%s</span><br />', esc_html( wp_listings_get_address() ) );
			printf( '<span class="listing-city-state-zip">%s, %s %s</span></li>', esc_html( wp_listings_get_city() ), esc_html( wp_listings_get_state() ), esc_html( get_post_meta( $post->ID, '_listing_zip', true ) ) );

			if ( ! empty( wp_listings_get_property_types() ) ) {
				printf( '<li class="listing-property-type"><span class="label">Property Type: </span>%s</li>', get_the_term_list( get_the_ID(), 'property-types', '', ', ', '' ) );
			}

			if ( ! empty( wp_listings_get_locations() ) ) {
				printf( '<li class="listing-location"><span class="label">Location: </span>%s</li>', get_the_term_list( get_the_ID(), 'locations', '', ', ', '' ) );
			}

			echo '</ul><ul>';

			if ( ! empty( get_post_meta( $post->ID, '_listing_bedrooms', true ) ) ) {
				printf( '<li class="listing-bedrooms"><span class="label">Beds: </span>%s</li>', esc_html( get_post_meta( $post->ID, '_listing_bedrooms', true ) ) );
			}

			if ( ! empty( get_post_meta( $post->ID, '_listing_bathrooms', true ) ) ) {
				printf( '<li class="listing-bathrooms"><span class="label">Baths: </span>%s</li>', esc_html( get_post_meta( $post->ID, '_listing_bathrooms', true ) ) );
			}

			if ( ! empty( get_post_meta( $post->ID, '_listing_sqft', true ) ) ) {
				printf( '<li class="listing-sqft"><span class="label">Sq Ft: </span>%s</li>', esc_html( get_post_meta( $post->ID, '_listing_sqft', true ) ) );
			}

			if ( ! empty( get_post_meta( $post->ID, '_listing_lot_sqft', true ) ) ) {
				printf( '<li class="listing-lot-sqft"><span class="label">Lot Sq Ft: </span>%s</li>', esc_html( get_post_meta( $post->ID, '_listing_lot_sqft', true ) ) );
			}

			echo '</ul></ul>';

			?>
		</div><!-- .listing-image-wrap -->



		<div id="listing-tabs" class="listing-data full-alignment3">

			<ul>
				<li><a href="#listing-description">Description</a></li>

				<li><a href="#listing-details">Details</a></li>

				<?php if ( ! empty( get_post_meta( $post->ID, '_listing_gallery', true ) ) ) { ?>
					<li><a href="#listing-gallery">Photos</a></li>
				<?php } ?>

				<?php if ( ! empty( get_post_meta( $post->ID, '_listing_video', true ) ) ) { ?>
					<li><a href="#listing-video">Video / Virtual Tour</a></li>
				<?php } ?>

				<?php if ( ! empty( get_post_meta( $post->ID, '_listing_school_neighborhood', true ) ) ) { ?>
				<li><a href="#listing-school-neighborhood">Schools &amp; Neighborhood</a></li>
				<?php } ?>

				<li><a href="#listing-contact">Contact</a></li>
			</ul>

			<div id="listing-description">
				<?php
				the_content( esc_html__( 'View more <span class="meta-nav">&rarr;</span>', 'wp-listings' ) );
				echo ( get_post_meta( $post->ID, '_listing_featured_on', true ) ) ? '<p class="wp_listings_featured_on">' . esc_html( get_post_meta( $post->ID, '_listing_featured_on', true ) ) . '</p>' : '';

				if ( class_exists( 'Idx_Broker_Plugin' ) && ! empty( $options['wp_listings_display_idx_link'] ) && get_post_meta( $post->ID, '_listing_details_url', true ) ) {
					echo '<a href="' . esc_attr( get_post_meta( $post->ID, '_listing_details_url', true ) ) . '" title="' . esc_attr( get_post_meta( $post->ID, '_listing_mls', true ) ) . '" class="listing-full-details-link">View full listing details</a>';
				}
				?>
			</div><!-- #listing-description -->

			<div id="listing-details">
				<?php
				$details_instance = new WP_Listings();

				echo '<table class="listing-details">';

				echo '<tbody class="left">';
				if ( get_post_meta( $post->ID, '_listing_hide_price', true ) === 1 ) {
					echo ( get_post_meta( $post->ID, '_listing_price_alt', true ) ) ? '<tr class="wp_listings_listing_price"><th class="label">' . esc_html__( 'Price:', 'wp-listings' ) . '</th><td>' . esc_html( get_post_meta( $post->ID, '_listing_price_alt', true ) ) . '</td></tr>' : '';
				} elseif ( get_post_meta( $post->ID, '_listing_price', true ) ) {
					$currency_symbol = ( empty( $options['wp_listings_currency_symbol'] ) || 'none' === $options['wp_listings_currency_symbol'] ) ? '' : $options['wp_listings_currency_symbol'];
					$currency_code   = ( ! empty( $options['wp_listings_display_currency_code'] ) && ! empty( $options['wp_listings_display_currency_code'] ) && 'none' !== $options['wp_listings_currency_code'] ) ? $options['wp_listings_currency_code'] : '';
					echo '<tr class="wp_listings_listing_price"><th class="label">' . esc_html__( 'Price:', 'wp-listings' ) . '</th><td><span class="currency-symbol">' . esc_html( $currency_symbol ) . '</span>';
					echo esc_html( get_post_meta( $post->ID, '_listing_price', true ) ) . ' <span class="currency-code">' . esc_html( $currency_code ) . '</span>';
					echo '</td></tr>';
				}
				echo '<div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">';
				echo ( get_post_meta( $post->ID, '_listing_address', true ) ) ? '<tr class="wp_listings_listing_address"><th class="label">' . esc_html__( 'Address:', 'wp-listings' ) . '</th><td itemprop="streetAddress">' . esc_html( get_post_meta( $post->ID, '_listing_address', true ) ) . '</td></tr>' : '';
				echo ( get_post_meta( $post->ID, '_listing_city', true ) ) ? '<tr class="wp_listings_listing_city"><th class="label">' . esc_html__( 'City:', 'wp-listings' ) . '</th><td itemprop="addressLocality">' . esc_html( get_post_meta( $post->ID, '_listing_city', true ) ) . '</td></tr>' : '';
				echo ( get_post_meta( $post->ID, '_listing_state', true ) ) ? '<tr class="wp_listings_listing_state"><th class="label">' . esc_html__( 'State:', 'wp-listings' ) . '</th><td itemprop="addressRegion">' . esc_html( get_post_meta( $post->ID, '_listing_state', true ) ) . '</td></tr>' : '';
				echo ( get_post_meta( $post->ID, '_listing_zip', true ) ) ? '<tr class="wp_listings_listing_zip"><th class="label">' . esc_html__( 'Zip Code:', 'wp-listings' ) . '</th><td itemprop="postalCode">' . esc_html( get_post_meta( $post->ID, '_listing_zip', true ) ) . '</td></tr>' : '';
				echo ( get_post_meta( $post->ID, '_listing_subdivision', true ) ) ? '<tr class="wp_listings_listing_subdivision"><th class="label">' . esc_html__( 'Subdivision:', 'wp-listings' ) . '</th><td>' . esc_html( get_post_meta( $post->ID, '_listing_subdivision', true ) ) . '</td></tr>' : '';
				echo '</div>';
				echo ( get_post_meta( $post->ID, '_listing_mls', true ) ) ? '<tr class="wp_listings_listing_mls"><th class="label">MLS:</td><td>' . esc_html( get_post_meta( $post->ID, '_listing_mls', true ) ) . '</td></tr>' : '';
				echo '</tbody>';

				echo '<tbody class="right">';
				foreach ( (array) $details_instance->property_details['col2'] as $label => $key ) {
					$detail_value = esc_html( get_post_meta( $post->ID, $key, true ) );
					if ( ! empty( $detail_value ) ) {
						printf( '<tr class="wp_listings%s"><th class="label">%s</th><td>%s</td></tr>', esc_attr( $key ), esc_html( $label ), esc_html( $detail_value ) );
					}
				}
				echo '</tbody>';

				echo '</table>';

				echo '<table class="listing-details extended">';
				echo '<tbody class="left">';
				foreach ( (array) $details_instance->extended_property_details['col1'] as $label => $key ) {
					$detail_value = esc_html( get_post_meta( $post->ID, $key, true ) );
					if ( ! empty( $detail_value ) ) {
						printf( '<tr class="wp_listings%s"><th class="label">%s</th><td>%s</td></tr>', esc_attr( $key ), esc_html( $label ), esc_html( $detail_value ) );
					}
				}
				echo '</tbody>';
				echo '<tbody class="right">';
				foreach ( (array) $details_instance->extended_property_details['col2'] as $label => $key ) {
					$detail_value = esc_html( get_post_meta( $post->ID, $key, true ) );
					if ( ! empty( $detail_value ) ) {
						printf( '<tr class="wp_listings%s"><th class="label">%s</th><td>%s</td></tr>', esc_attr( $key ), esc_html( $label ), esc_html( $detail_value ) );
					}
				}
				echo '</tbody>';
				echo '</table>';

				if ( isset( $options['wp_listings_display_advanced_fields'] ) && $options['wp_listings_display_advanced_fields'] ) {
					$adv_fields = generate_adv_field_list( $post );
					if ( ! empty( $adv_fields['col1'] ) || ! empty( $adv_fields['col2'] ) ) {
						echo '<table class="listing-details advanced">';
						echo '<tbody class="left">';
						foreach ( $adv_fields['col1'] as $key => $value ) {
							if ( ! empty( $value ) ) {
								printf( '<tr class="wp_listings%s"><th class="label">%s</th><td>%s</td></tr>', esc_attr( $key ), esc_html( get_adv_field_display_name( $key ) . ':' ), esc_html( $value ) );
							}
						}
						echo '</tbody>';

						echo '<tbody class="right">';
						foreach ( $adv_fields['col2'] as $key => $value ) {
							if ( ! empty( $value ) ) {
								printf( '<tr class="wp_listings%s"><th class="label">%s</th><td>%s</td></tr>', esc_attr( $key ), esc_html( get_adv_field_display_name( $key ) . ':' ), esc_html( $value ) );
							}
						}
						echo '</tbody>';
						echo '</table>';
					}
				}

				if ( get_the_term_list( get_the_ID(), 'features', '<li>', '</li><li>', '</li>' ) != null ) {
					echo '<h5>' . esc_html__( 'Tagged Features:', 'wp-listings' ) . '</h5><ul class="tagged-features">';
					echo get_the_term_list( get_the_ID(), 'features', '<li>', '</li><li>', '</li>' );
					echo '</ul><!-- .tagged-features -->';
				}

				if ( ! empty( get_post_meta( $post->ID, '_listing_home_sum', true ) ) || ! empty( get_post_meta( $post->ID, '_listing_kitchen_sum', true ) ) || ! empty( get_post_meta( $post->ID, '_listing_living_room', true ) ) || ! empty( get_post_meta( $post->ID, '_listing_master_suite', true ) ) ) {
					?>
					<div class="additional-features">
						<h4>Additional Features</h4>
						<h6 class="label"><?php esc_html_e( 'Home Summary', 'wp-listings' ); ?></h6>
						<p class="value"><?php echo do_shortcode( get_post_meta( $post->ID, '_listing_home_sum', true ) ); ?></p>
						<h6 class="label"><?php esc_html_e( 'Kitchen Summary', 'wp-listings' ); ?></h6>
						<p class="value"><?php echo do_shortcode( get_post_meta( $post->ID, '_listing_kitchen_sum', true ) ); ?></p>
						<h6 class="label"><?php esc_html_e( 'Living Room', 'wp-listings' ); ?></h6>
						<p class="value"><?php echo do_shortcode( get_post_meta( $post->ID, '_listing_living_room', true ) ); ?></p>
						<h6 class="label"><?php esc_html_e( 'Master Suite', 'wp-listings' ); ?></h6>
						<p class="value"><?php echo do_shortcode( get_post_meta( $post->ID, '_listing_master_suite', true ) ); ?></p>
					</div><!-- .additional-features -->
					<?php
				}
				?>

			</div><!-- #listing-details -->

			<?php if ( ! empty( get_post_meta( $post->ID, '_listing_gallery', true ) ) ) { ?>
			<div id="listing-gallery">
				<?php echo do_shortcode( get_post_meta( $post->ID, '_listing_gallery', true ) ); ?>
			</div><!-- #listing-gallery -->
			<?php } ?>

			<?php if ( get_post_meta( $post->ID, '_listing_video', true ) != '' ) { ?>
			<div id="listing-video">
				<div class="iframe-wrap">
				<?php echo do_shortcode( get_post_meta( $post->ID, '_listing_video', true ) ); ?>
				</div>
			</div><!-- #listing-video -->
			<?php } ?>

			<?php if ( get_post_meta( $post->ID, '_listing_school_neighborhood', true ) != '' ) { ?>
			<div id="listing-school-neighborhood">
				<p>
				<?php echo do_shortcode( get_post_meta( $post->ID, '_listing_school_neighborhood', true ) ); ?>
				</p>
			</div><!-- #listing-school-neighborhood -->
			<?php } ?>

			<div id="listing-contact">
				<?php
				if ( function_exists( '_p2p_init' ) && function_exists( 'agent_profiles_init' ) ) {
					echo '<div id="listing-agent">';
					aeprofiles_connected_agents_markup();
					echo '</div><!-- .listing-agent -->';
				} elseif ( function_exists( '_p2p_init' ) && function_exists( 'impress_agents_init' ) ) {
					echo '<div id="listing-agent">';
					echo '<div class="connected-agents">';
					impa_connected_agents_markup();
					echo '</div></div><!-- .listing-agent -->';
				}
				?>

				<div id="contact-form" style="<?php echo ( ! function_exists( 'aeprofiles_connected_agents_markup' ) ) ? esc_attr( 'width: 100%;' ) : ''; ?>">
					<?php
					$options = get_option( 'plugin_wp_listings_settings' );
					if ( ! empty( get_post_meta( $post->ID, '_listing_contact_form', true ) ) ) {
						echo do_shortcode( get_post_meta( $post->ID, '_listing_contact_form', true ) );
					} elseif ( ! empty( $options['wp_listings_default_form'] ) ) {
						echo do_shortcode( $options['wp_listings_default_form'] );
					} else {
						include_once IMPRESS_IDX_DIR . 'add-ons/listings/includes/listing-templates/listing-inquiry-form.php';
						listing_inquiry_form( $post );
					}
					?>
				</div><!-- .contact-form -->
			</div><!-- #listing-contact -->

		</div><!-- #listing-tabs.listing-data -->

		<?php
		if ( get_post_meta( $post->ID, '_listing_map', true ) != '' ) {
			echo '<div id="listing-map"><h3>Location Map</h3>';
			echo do_shortcode( get_post_meta( $post->ID, '_listing_map', true ) );
			echo '</div><!-- .listing-map -->';
		} elseif ( ! empty( $options['wp_listings_gmaps_api_key'] ) && get_post_meta( $post->ID, '_listing_latitude', true ) && get_post_meta( $post->ID, '_listing_longitude', true ) && get_post_meta( $post->ID, '_listing_automap', true ) === 'y' ) {
			include_once IMPRESS_IDX_DIR . 'add-ons/listings/includes/listing-templates/listing-map-location.php';
			load_listing_on_map( $post, $options );
		}
		?>

		<div id="listing-disclaimer">
			<?php
			if ( get_post_meta( $post->ID, '_listing_disclaimer', true ) ) {
				echo '<p class="wp_listings_disclaimer">' . get_post_meta( $post->ID, '_listing_disclaimer', true ) . '</p>';
			} elseif ( ! empty( $options['wp_listings_global_disclaimer'] ) ) {
				echo '<p class="wp_listings_disclaimer">' . esc_html( $options['wp_listings_global_disclaimer'] ) . '</p>';
			}
			echo ( get_post_meta( $post->ID, '_listing_courtesy', true ) ) ? '<p class="wp_listings_courtesy">' . esc_html( get_post_meta( $post->ID, '_listing_courtesy', true ) ) . '</p>' : '';
			?>
		</div><!-- #listing-disclaimer -->

		<a class="link-main-site" href="<?php echo esc_url( home_url() ); ?>">&larr; Back to main site</a>

	</div><!-- .entry-content -->

	<?php
}

?>
<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8) ]><!-->
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width">
		<title><?php wp_title( '|', true, 'right' ); ?></title>
		<link rel="profile" href="http://gmpg.org/xfn/11">
		<?php wp_head(); ?>
	</head>
	<body <?php body_class(); ?>>

		<?php
		// Start the Loop.
		while ( have_posts() ) :
			the_post();
			?>
		<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry-content wplistings-single-listing listing-template' ); ?> role="main">

			<?php single_listing_post_content(); ?>

		</article><!-- #post-ID .listing-template -->

		<?php endwhile; ?>

	<?php

	wp_footer();

	?>

	</body>
</html>
