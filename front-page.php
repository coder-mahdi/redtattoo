<?php
/**
 * The template for displaying the front page
 *
 * This is the template that displays the front page by default.
 * It includes dynamic content managed through ACF and Custom Post Types (CPT).
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package redtattoo_theme
 */

get_header();
?>

<main id="primary" class="site-main">

    <?php
    while ( have_posts() ) :
        the_post();

        // Display the title as a block, dynamically managed from WordPress backend.
        echo '<h1 class="page-title">' . get_the_title() . '</h1>';

        // Hero Image: ACF Repeater Field
	// Hero Image Group: ACF Repeater Fields
// Hero Image Group: ACF Fields
echo '<div class="hero-image-slider">';


// Hero Image 1: ACF Sub Field
if( have_rows('hero_image_1') ):
    while( have_rows('hero_image_1') ) : the_row();
        $image = get_sub_field('image');
        if( $image && is_array($image) && isset($image['url']) ):
            echo '<div class="hero-image hero-image-1">';
            echo '<img src="' . esc_url($image['url']) . '" alt="' . (isset($image['alt']) ? esc_attr($image['alt']) : '') . '" />';
            echo '</div>';
        endif;
    endwhile;
endif;

// Hero Image 2: ACF Sub Field
if( have_rows('hero_image_2') ):
    while( have_rows('hero_image_2') ) : the_row();
        $image = get_sub_field('image');
        if( $image && is_array($image) && isset($image['url']) ):
            echo '<div class="hero-image hero-image-2">';
            echo '<img src="' . esc_url($image['url']) . '" alt="' . (isset($image['alt']) ? esc_attr($image['alt']) : '') . '" />';
            echo '</div>';
        endif;
    endwhile;
endif;

// Hero Image 3: ACF Sub Field
if( have_rows('hero_image_3') ):
    while( have_rows('hero_image_3') ) : the_row();
        $image = get_sub_field('image');
        if( $image && is_array($image) && isset($image['url']) ):
            echo '<div class="hero-image hero-image-3">';
            echo '<img src="' . esc_url($image['url']) . '" alt="' . (isset($image['alt']) ? esc_attr($image['alt']) : '') . '" />';
            echo '</div>';
        endif;
    endwhile;
endif;

echo '</div>';




// Booking Button: Static
echo '<a href="#booking-section" class="booking-button">Book Now</a>';

// Button to Gallery: Static
echo '<a href="/gallery" class="gallery-button">View Gallery</a>';


        // Schedule Box: ACF Group Field
        if( have_rows('schedule_box') ):
            echo '<div class="schedule-box">';
            while( have_rows('schedule_box') ) : the_row();
                $day = get_sub_field('day');
                $time = get_sub_field('time');
				$address = get_sub_field('address');
                echo '<div class="schedule-item">';
                echo '<span class="schedule-day">' . esc_html($day) . '</span>: ';
                echo '<span class="schedule-time">' . esc_html($time) . '</span>';
				echo '<span class="schedule-address">' . esc_html($address) . '</span>';
                echo '</div>';
            endwhile;
            echo '</div>';
        endif;

// About Us: ACF Group Field
if( have_rows('about_us') ):
    while( have_rows('about_us') ) : the_row();
        $title = get_sub_field('title');
        $image = get_sub_field('image');
        $description = get_sub_field('description');

        echo '<div class="about-us-section">';

        // Display Title
        if( !empty($title) ) {
            echo '<h2>' . esc_html($title) . '</h2>';
        }

        // Display Image
        if( !empty($image) && is_array($image) && isset($image['url']) ) {
            echo '<img src="' . esc_url($image['url']) . '" alt="' . esc_attr($image['alt']) . '" />';
        }

        // Display Description
        if( !empty($description) ) {
            echo '<p>' . esc_html($description) . '</p>';
        }

        echo '</div>';
    endwhile;
endif;



        // Team Members: CPT and ACF Group Field
		
		// Query to get Team Members
		$team_members = new WP_Query(array(
			'post_type' => 'readtattoo-team', // Post type slug defined for team members
			'posts_per_page' => -1, // Retrieve all team members
		));
		
		// Check if there are any team members
		if( $team_members->have_posts() ):
			echo '<div class="team-members-section">';
			
			// Loop through the team members
			while( $team_members->have_posts() ): $team_members->the_post();
				
				// Display the team member details
				echo '<div class="team-member">';
				
				// Display the featured image if exists
				if( has_post_thumbnail() ) {
					echo '<div class="team-member-image">';
					the_post_thumbnail('medium'); // Displays the featured image with medium size
					echo '</div>';
				}

				echo '<h3>' . get_the_title() . '</h3>';
				
				// Display the content (editor content)
				echo '<div class="team-member-content">';
				the_content();
				echo '</div>';
				
				echo '</div>';
			endwhile;
			
			echo '</div>';
		
			// Reset Post Data
			wp_reset_postdata();
		else:
			// If no team members are found
			echo '<p>No team members found</p>';
		endif;
		
		

        // Services: CPT with Custom Taxonomy and ACF
        $services = new WP_Query(array('post_type' => 'service', 'posts_per_page' => -1));
        if( $services->have_posts() ):
            echo '<div class="services-section">';
            while( $services->have_posts() ) : $services->the_post();
                $title = get_the_title();
                $taxonomy_terms = get_the_terms(get_the_ID(), 'service_category');
                $short_description = get_field('short_description');
                echo '<div class="service-item">';
                if( $title ) echo '<h3>' . esc_html($title) . '</h3>';
                if( $taxonomy_terms ):
                    foreach( $taxonomy_terms as $term ):
                        echo '<span class="service-category">' . esc_html($term->name) . '</span> ';
                    endforeach;
                endif;
                if( $short_description ) echo '<p>' . esc_html($short_description) . '</p>';
                echo '</div>';
            endwhile;
            echo '</div>';
            wp_reset_postdata();
        endif;

        // Gallery: ACF Link Field
        $gallery_image = get_field('gallery_image');
        if( $gallery_image ):
            echo '<div class="gallery-link">';
            echo '<a href="' . esc_url($gallery_image['link']) . '"><img src="' . esc_url($gallery_image['url']) . '" alt="' . esc_attr($gallery_image['alt']) . '" /></a>';
            echo '</div>';
        endif;

        // Testimonials: CPT
        $testimonials = new WP_Query(array('post_type' => 'testimonial', 'posts_per_page' => -1));
        if( $testimonials->have_posts() ):
            echo '<div class="testimonials-section">';
            while( $testimonials->have_posts() ) : $testimonials->the_post();
                $content = get_the_content();
                $author = get_field('author');
                echo '<div class="testimonial-item">';
                if( $content ) echo '<blockquote>' . esc_html($content) . '</blockquote>';
                if( $author ) echo '<p class="testimonial-author">' . esc_html($author) . '</p>';
                echo '</div>';
            endwhile;
            echo '</div>';
            wp_reset_postdata();
        endif;

        // Booking Section: Plugin Booking Form
        echo '<div id="booking-section" class="booking-section">';
        // این بخش برای نمایش پلاگین بوکینگ هست که باید از وردپرس اضافه بشه
        echo do_shortcode('[booking_form_shortcode]');
        echo '</div>';

    endwhile; // End of the loop.
    ?>

</main><!-- #main -->

<?php
get_footer();