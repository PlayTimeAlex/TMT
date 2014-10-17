<?php 
	get_header(); 
	while (have_posts()) : the_post(); 
	$authorId = get_the_author_meta('ID');	
	$category = get_the_category();
	$cat_tree = get_category_parents($category[0]->term_id, FALSE, ':', TRUE);
	$top_cat = explode(':',$cat_tree);
	$parent = $top_cat[0];
?>
<div class="b-page">
    <div class="container">
        <div class="row">
            <aside class="span4 b-sidebar">
				<?php
					if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('post_sidebar') ) : endif; 
				?>
            </aside>
            <div class="span8">
                <h2 class="b-page__title"><?php echo get_category_by_slug($parent)->name; ?></h2>
                <div class="b-aitem">
                    <div class="row b-aitem__header">
                        <img class="b-aitem__photo" src="<?php echo get_avatar_url($authorId, 150); ?>" alt=""/>
                        <div class="b-aitem__detalis">
                            <h1 class="b-aitem__title"><?php the_title(); ?></h1>
                            <span class="b-aitem__autor">By <a href="<?php echo get_author_posts_url($authorId); ?>"><?php echo get_the_author(); ?></a></span>
                            <span class="b-aitem__date"><?php the_time('d.m.Y'); ?></span>
							<?php
								if( have_rows('files') ) {
									while ( have_rows('files') ) : the_row();
									
									$file = get_sub_field('file');
									if($file){
									$fileSize = round(filesize(get_attached_file($file['id']))/1024/1024, 2);
							?>
                            <span class="b-aitem__file"><a href="<?php echo $file['url'];?>">Скачать PDF файл</a> (<?php echo $fileSize;?> мб ~ <?php echo round($fileSize/0.125)?> сек)</span>
							<?php 
									}
									endwhile;
								} 
							?>
                        </div>
                    </div>
                </div>
                <div class="b-text">
                    <?php the_content(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php 
	endwhile;
	get_footer();
 ?>