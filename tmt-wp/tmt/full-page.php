<?php 
	/*
	Template Name: Страница без сайдбара
	*/
	get_header(); 
	while (have_posts()) : the_post(); 
?>
<div class="b-page">
    <div class="container">
        <div class="row">
            <div class="span12">
                <h1 class="b-page__title"><?php the_title(); ?></h1>
				<div class="b-text">
                <?php 
					if(has_post_thumbnail()){
						$featuredImage = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full');
						echo '<img src="'.$featuredImage[0].'" class="b-page__featured" alt="'.get_the_title().'" />';
					}
					the_content(); 
				?>
				</div>
            </div>
        </div>
    </div>
</div>
<?php 
	endwhile;
	get_footer();
 ?>