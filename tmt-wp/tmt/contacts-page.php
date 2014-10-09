<?php 
	/*
	Template Name: Страница "Контакты"
	*/
	get_header(); 
	while (have_posts()) : the_post(); 
?>
<div class="b-page">
    <div class="container">
        <div class="row">
            <div class="span12">
                <h1 class="b-page__title">Контакты</h1>
                <div class="b-text">
                    <div class="row">
                        <div class="span7">
                            <?php 
								$form = get_field('contact_form');
								echo do_shortcode('[contact-form-7 id="'.$form->ID.'" title="'.$form->post_title.'"]');
							?>
                        </div>
                        <div class="span5 b-contacts__detalis">
					<?php 
						if( have_rows('adresses') ) {

							while ( have_rows('adresses') ) : the_row();
								$false_adress = get_sub_field('false_adress');
								$map = get_sub_field('adress');
								if($false_adress) {
									echo '<p><strong>'.get_sub_field('title').': </strong>'.$false_adress.'</p>';
								} else {
									echo '<p><strong>'.get_sub_field('title').': </strong>'.$map['address'].'</p>';
								}	
					?>
					<?php	
							endwhile;

						}
						if( have_rows('other_contacts') ) {

							while ( have_rows('other_contacts') ) : the_row();
					?>
								<p><strong><?php the_sub_field('title'); ?>: </strong><?php the_sub_field('content'); ?></p>
					<?php	
							endwhile;

						}
					?>
						<div class="b-contacts__tabs">
					<?php	
						if( have_rows('adresses') ) {
							$i = 0;
							while ( have_rows('adresses') ) : the_row();
								$map = get_sub_field('adress');
								$title = get_sub_field('title');
								$false_adress = get_sub_field('false_adress');
								($false_adress) ? $content = $false_adress : $content = $map['address'];
								($i) ? $current = '' : $current = 'current';
								if($map &&$title) {
									if($i) echo '|';
									echo '<a class="b-contacts__map-link '.$current.'" href="#" data-coord="['.$map['lat'].','.$map['lng'].']" data-adress="'.$content.'">'.$title.'</a>';
								}	
								$i++;
							endwhile;

						}
					?>
						</div>
                            <script src="http://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
                            <script type="text/javascript">
									jQuery(document).ready(function(){
										ymaps.ready(init);
										var myMap;
										var $link = jQuery('.b-contacts__map-link:first-child');
										var coord = $link.data('coord');
										var text = $link.data('adress');
										
										function init(){
											myMap = new ymaps.Map("b-contacts__map", {
												center: coord,
												zoom: 13
											});
											myPlacemark = new ymaps.Placemark(coord, {
												balloonContent: text
											});

											myMap.geoObjects.add(myPlacemark);
											jQuery('.b-contacts__map-link').click(function(){
												if(jQuery(this).hasClass('current')) return;
											
												var coord = jQuery(this).data('coord');
												var text = jQuery(this).data('adress');
												
												myMap.geoObjects.remove(myPlacemark);

												myPlacemark = new ymaps.Placemark(coord, {
													balloonContent: text
												});
												myMap.geoObjects.add(myPlacemark);

												myMap.setCenter(coord);
												
												jQuery('.b-contacts__map-link').removeClass('current');
												jQuery(this).addClass('current');
												
												
												return false;
											});
										}
									});
                            </script>
                            <div class="b-contacts__map" id="b-contacts__map">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php 
	endwhile;
	get_footer();
 ?>