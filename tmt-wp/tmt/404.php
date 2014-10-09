<?php 
	get_header(); 
	while (have_posts()) : the_post(); 
?>
<div class="b-page">
    <div class="container">
        <div class="row">
            <div class="span12">
                <h1 class="b-page__title">404</h1>
            </div>
        </div>
    </div>
</div>
<?php 
	endwhile;
	get_footer();
 ?>