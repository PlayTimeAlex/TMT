<?php 
	/*
	Template Name: Страница "Главная"
	*/
	get_header(); 
	while (have_posts()) : the_post(); 
?>

<div class="b-page">
    <div class="b-slider__container">
        <div class="b-slider__w-container">
            <div class="b-slider">
                <ul class="slides">
                <?php 
					if( have_rows('slides') ) {

						while ( have_rows('slides') ) : the_row();
				?>
                            <li><img src="<?php the_sub_field('slide'); ?>" alt=""/></li>
				<?php	
						endwhile;

					}
				?>
                </ul>
                <div class="b-slider__content">
                    <table class="b-slider__table">
                        <tr>
                            <td><?php the_field('slider_text'); ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="b-home">
            <div class="row">
                <div class="span6">
				<h2 class="b-home__title"><?php the_field('left_title'); ?></h2>
				<?php 
					$posts = get_posts(array('category' => get_field('left_category'), 'posts_per_page'   => 2));
					$i = 0;
					foreach ( $posts as $post ) : setup_postdata( $post ); 
					$authorId = get_the_author_meta('ID');	
					if($i == 0) {
				?>
                    <article class="b-aitem">
                        <div class="row b-aitem__header">
                            <img class="b-aitem__photo" src="<?php echo get_avatar_url($authorId, 150); ?>" alt=""/>
                            <div class="b-aitem__detalis">
                                <h2 class="b-aitem__title"><a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a></h2>
                                <span class="b-aitem__autor">By <a href="<?php echo get_author_posts_url($authorId); ?>"><?php echo get_the_author(); ?></a></span>
                                <span class="b-aitem__date"><?php the_time('d.m.Y'); ?></span>
                            </div>
                        </div>
                        <div class="b-text b-aitem__text">
                            <p><?php echo get_the_excerpt(); ?><a class="b-aitem__more" href="<?php echo get_permalink();?>">больше</a></p>
                        </div>
                    </article>
				<?php 
					} else {
				?>
                    <article class="b-aitem b-aitem_short">
                        <div class="row b-aitem__header">
                            <img class="b-aitem__photo" src="<?php echo get_avatar_url($authorId, 150); ?>" width="66" height="66" alt=""/>
                            <div class="b-aitem__detalis">
                                <h2 class="b-aitem__title"><a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a></h2>
                                <span class="b-aitem__autor">By <a href="<?php echo get_author_posts_url($authorId); ?>"><?php echo get_the_author(); ?></a></span>
                                <span class="b-aitem__date"><?php the_time('d.m.Y'); ?></span>
                            </div>
                        </div>
                    </article>
				<?php
					}
					$i++;
					endforeach; 
					wp_reset_postdata();
				?>
                </div>
                <div class="span6">
				<h2 class="b-home__title"><?php the_field('right_title'); ?></h2>
				<?php 
					$posts = get_posts(array('category' => get_field('right_category'), 'posts_per_page'   => 2));
					$i = 0;
					foreach ( $posts as $post ) : setup_postdata( $post ); 
					$authorId = get_the_author_meta('ID');	
					if($i == 0) {
				?>
                    <article class="b-aitem">
                        <div class="row b-aitem__header">
                            <img class="b-aitem__photo" src="<?php echo get_avatar_url($authorId, 150); ?>" alt=""/>
                            <div class="b-aitem__detalis">
                                <h2 class="b-aitem__title"><a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a></h2>
                                <span class="b-aitem__autor">By <a href="<?php echo get_author_posts_url($authorId); ?>"><?php echo get_the_author(); ?></a></span>
                                <span class="b-aitem__date"><?php the_time('d.m.Y'); ?></span>
                            </div>
                        </div>
                        <div class="b-text b-aitem__text">
                            <p><?php echo get_the_excerpt(); ?><a class="b-aitem__more" href="<?php echo get_permalink();?>">больше</a></p>
                        </div>
                    </article>
				<?php 
					} else {
				?>
                    <article class="b-aitem b-aitem_short">
                        <div class="row b-aitem__header">
                            <img class="b-aitem__photo" src="<?php echo get_avatar_url($authorId, 150); ?>" width="66" height="66" alt=""/>
                            <div class="b-aitem__detalis">
                                <h2 class="b-aitem__title"><a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a></h2>
                                <span class="b-aitem__autor">By <a href="<?php echo get_author_posts_url($authorId); ?>"><?php echo get_the_author(); ?></a></span>
                                <span class="b-aitem__date"><?php the_time('d.m.Y'); ?></span>
                            </div>
                        </div>
                    </article>
				<?php
					}
					$i++;
					endforeach; 
					wp_reset_postdata();
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