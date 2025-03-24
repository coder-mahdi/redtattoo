<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package redtattoo_theme
 */

get_header();
?>
<main id="primary" class="site-main">
    <?php while ( have_posts() ) : the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            
            <header class="entry-header">
                <h1 class="entry-title"><?php the_title(); ?></h1>
				<h2 class="page-title">Tattoo Artworks</h2>
            </header>

            <div class="gallery-images">
            <?php $gallery_images = get_field('gallery-images'); 
                 if ($gallery_images): 
                    usort($gallery_images, function ($a, $b) {
                     
                        $date_a = isset($a['upload_date']) ? strtotime($a['upload_date']) : strtotime($a['date']); 
                        $date_b = isset($b['upload_date']) ? strtotime($b['upload_date']) : strtotime($b['date']);
                        
                        return $date_b - $date_a; 
                    });
            ?>
    <div class="gallery-grid">
        <?php foreach ($gallery_images as $index => $image): ?>
            <?php if ($index >= 20) break;?>
            <div class="gallery-item">
                <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <p>This gallery does not have any photo</p>
<?php endif; ?>

            </div>

			<a href="<?php echo site_url('https://redtattoo.ca/'); ?>" class="back-button">‌Back To Home</a>
			<?php
			 echo '<div class="booking-bar">';
             echo '<a href="http://localhost:8888/redtattoo/booking/" class="booking-link">Book Now</a>';
             echo '</div>';
             ?>;

        </article>
    <?php endwhile; ?>;
</main>

<?php
get_footer();
