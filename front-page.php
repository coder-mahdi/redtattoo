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

// Hero Image Group: ACF Fields
echo '<div class="hero-image-slider">';

// Hero Image 1: ACF Gallery Field
echo '<div class="hero-image hero-image-1">';
$hero_images_1 = get_field('hero_image_1');

if ($hero_images_1) {
    foreach ($hero_images_1 as $image_id) {
        echo '<div class="hero-image-wrapper">';
        echo wp_get_attachment_image($image_id, 'hero-image'); 
        echo '<div class="overlay"></div>'; 
        echo '</div>';
    }

    foreach ($hero_images_1 as $image_id) {
        echo '<div class="hero-image-wrapper">';
        echo wp_get_attachment_image($image_id, 'hero-image'); 
        echo '<div class="overlay"></div>'; 
        echo '</div>';
    }
     }
 
echo '</div>';

// Hero Image 2: ACF Gallery Field
echo '<div class="hero-image hero-image-2">';
$hero_images_2 = get_field('hero_image_2');
if ($hero_images_2) {
    foreach ($hero_images_2 as $image_id) {
        echo '<div class="hero-image-wrapper">';
        echo wp_get_attachment_image($image_id, 'hero-image'); 
        echo '<div class="overlay"></div>'; 
        echo '</div>';
    }

    foreach ($hero_images_2 as $image_id) {
        echo '<div class="hero-image-wrapper">';
        echo wp_get_attachment_image($image_id, 'hero-image'); 
        echo '<div class="overlay"></div>'; 
        echo '</div>';
    }
}
echo '</div>';

// Hero Image 3: ACF Gallery Field
echo '<div class="hero-image hero-image-3">';
$hero_images_3 = get_field('hero_image_3');
if ($hero_images_3) {
    foreach ($hero_images_3 as $image_id) {

        echo '<div class="hero-image-wrapper">';
        echo wp_get_attachment_image($image_id, 'hero-image'); 
        echo '<div class="overlay"></div>'; 
        echo '</div>';
    }

    foreach ($hero_images_3 as $image_id) {

        echo '<div class="hero-image-wrapper">';
        echo wp_get_attachment_image($image_id, 'hero-image'); 
        echo '<div class="overlay"></div>'; 
        echo '</div>';
    }
}
echo '</div>';
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

        echo '<div id="about-us-section" class="about-us-section">';

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
			echo '<div id="readtattoo-team-section" class="team-members-section">';
			
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

    
    
// Query to get Testimonials CPT posts
$testimonials_query = new WP_Query(array(
    'post_type'      => 'testimonial', // Post type slug defined for Testimonials
    'posts_per_page' => -1,            // Retrieve all testimonials
));

// Check if there are any testimonials
if ($testimonials_query->have_posts()) :
    echo '<div class="testimonials-section">';

    // Loop through the testimonials
    while ($testimonials_query->have_posts()) : $testimonials_query->the_post();

        // Get ACF fields
        $customer_name = get_field('customer_name');
        $customer_image = get_field('customer_image');
        $customer_profile_link = get_field('customer_profile_link');
        $review_or_rating = get_field('review_or_rating');

        echo '<div class="testimonial-item">';

        // Display Customer Image
        if ($customer_image) {
            echo '<div class="customer-image">';
            echo '<img src="' . esc_url($customer_image['url']) . '" alt="' . esc_attr($customer_image['alt']) . '">';
            echo '</div>';
        }

        // Display Customer Name
        if ($customer_name) {
            echo '<h3 class="customer-name">' . esc_html($customer_name) . '</h3>';
        }

        if ($title) {
            echo '<h3>' . get_the_title() . '</h3>';
        }

        // Display Review or Rating
        if ($review_or_rating) {
            echo '<div class="review">' . esc_html($review_or_rating) . '</div>';
        }

        // Display Profile Link
        if ($customer_profile_link) {
            echo '<a href="' . esc_url($customer_profile_link) . '" class="customer-profile-link" target="_blank">View Profile</a>';
        }

        echo '</div>';

    endwhile;

    echo '</div>';

    // Reset Post Data
    wp_reset_postdata();

else :
    echo '<p>No testimonials found</p>';
endif;


     

// Booking Services Section
echo '<div id="services-section" class="services-section">';
echo do_shortcode('[salon_booking_services styled=true]');
echo '</div>';



    endwhile; // End of the loop.
    ?>

</main><!-- #main -->

<?php
get_footer();