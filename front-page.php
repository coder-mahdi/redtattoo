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
        if( have_rows('hero_image_repeater') ):
            echo '<div class="hero-image-slider">';
            while( have_rows('hero_image_repeater') ) : the_row();
                $image = get_sub_field('image');
                if( $image ):
                    echo '<img src="' . esc_url($image['url']) . '" alt="' . esc_attr($image['alt']) . '" />';
                endif;
            endwhile;
            echo '</div>';
        endif;

        // Booking Button: ACF Radio Button
        $booking_button = get_field('booking_button');
        if( $booking_button ):
            echo '<a href="#booking-section" class="booking-button">' . esc_html($booking_button) . '</a>';
        endif;

        // Button to Gallery: ACF Link Field
        $gallery_link = get_field('gallery_button_link');
        if( $gallery_link ):
            echo '<a href="' . esc_url($gallery_link['url']) . '" class="gallery-button">' . esc_html($gallery_link['title']) . '</a>';
        endif;

        // Schedule Box: ACF Group Field
        if( have_rows('schedule_box') ):
            echo '<div class="schedule-box">';
            while( have_rows('schedule_box') ) : the_row();
                $day = get_sub_field('day');
                $time = get_sub_field('time');
                echo '<div class="schedule-item">';
                echo '<span class="schedule-day">' . esc_html($day) . '</span>: ';
                echo '<span class="schedule-time">' . esc_html($time) . '</span>';
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
                if( $title ) echo '<h2>' . esc_html($title) . '</h2>';
                if( $image ) echo '<img src="' . esc_url($image['url']) . '" alt="' . esc_attr($image['alt']) . '" />';
                if( $description ) echo '<p>' . esc_html($description) . '</p>';
                echo '</div>';
            endwhile;
        endif;

        // Team Members: CPT and ACF Group Field
        $team_members = new WP_Query(array('post_type' => 'team_member', 'posts_per_page' => -1));
        if( $team_members->have_posts() ):
            echo '<div class="team-members-section">';
            while( $team_members->have_posts() ) : $team_members->the_post();
                $title = get_the_title();
                $image = get_field('team_member_image');
                echo '<div class="team-member">';
                if( $image ) echo '<img src="' . esc_url($image['url']) . '" alt="' . esc_attr($image['alt']) . '" />';
                if( $title ) echo '<h3>' . esc_html($title) . '</h3>';
                echo '</div>';
            endwhile;
            echo '</div>';
            wp_reset_postdata();
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