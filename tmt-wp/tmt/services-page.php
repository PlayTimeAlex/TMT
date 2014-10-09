<?php 
	/*
	Template Name: Страница "Услуги"
	*/
	get_header(); 
	while (have_posts()) : the_post(); 
?>
<div class="b-page">
    <div class="container">
        <div class="row">
            <aside class="span4 b-sidebar">
                <div class="widget">
                    <div class="menu-container">
                        <ul class="menu">
                <?php 
					if( have_rows('services') ) {

						while ( have_rows('services') ) : the_row();
						$title = get_sub_field('item__title');
				?>
                            <li class="menu-item">
                                <a class="anim-scroll" href="#<?php echo md5($title); ?>"><?php echo $title; ?></a>
                            </li>
				<?php	
						endwhile;

					}
				?>
                        </ul>
                    </div>
                </div>
            </aside>
            <div class="span8">
                <?php 
					if( have_rows('services') ):

						while ( have_rows('services') ) : the_row();
						$title = get_sub_field('item__title');
				?>
                <section class="b-service" id="<?php echo md5($title); ?>">
                    <h1 class="b-page__title"><?php echo $title; ?></h1>
                    <div class="b-service__item b-text">
                        <?php the_sub_field('item'); ?>
                    </div>
                </section>
				<?php	
						endwhile;

					else :

						echo '<h1 class="b-page__title">Не добавлено услуг</h1>';

					endif;
				?>
            </div>
        </div>
    </div>
</div>
<?php 
	endwhile;
	get_footer();
 ?>