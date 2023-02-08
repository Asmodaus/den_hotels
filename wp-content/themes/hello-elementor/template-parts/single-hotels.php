<?php
/**
 * The template for displaying singular post-types: posts, pages and user-defined custom post types.
 *
 * @package HelloElementor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

while ( have_posts() ) :
	the_post();
	$Post = get_post(get_the_ID());
	$custom = get_post_custom( get_the_ID() );

	$category_detail=get_the_category( get_the_ID());
	foreach($category_detail as $cd){
		$catname= $cd->cat_name;
		$caturl = $cd->slug;
	}
    $rating=get_post_meta($Post->ID,'rating');
    if ($rating>5) $rating=5;
	?>

<main id="content" <?php post_class( 'site-main' ); ?> role="main">
 

			<section class="blog-description">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="desc-title">
							 
								<?php the_title( '<h3>', '</h3>' ); ?>   
                                <div class="desc-rating">
									<?php for ($i=1;$i<=$rating;$i++):?>
                                    <img src="<?= dirname( __FILE__ ) ?>/../images/star-icon.svg" alt="">
                                    <?php endfor;?>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row desc-rov">
                        <div class="col-xl-5 col-lg-6">
                            <div class="dec-slide-content">
                                <div class="desc-slide">
                                    <div class="swiper mySwiper2">
                                        <div class="swiper-wrapper gallery-big">
										<?php 
										$media = get_attached_media( 'image', $Post->ID );
										foreach ($media as $img):
										?>
                                            <div class="swiper-slide">
                                                <a href="<?=$img->guid?>" data-lightbox="roadtrip">
                                                    <img src="<?php echo $img->guid;?>"/>
                                                </a>
                                            </div>
                                        <?php endforeach;?>
                                        </div>
                                    </div>
                                    <div thumbsSlider="" class="swiper mySwiper">
                                        <div class="swiper-button-next"><img src="images/slide-right-arrow.svg" alt=""></div>
                                        <div class="swiper-button-prev"><img src="images/slide-left-arrow.svg" alt=""></div>

                                        <div class="swiper-wrapper gallery-small">
											<?php 
											foreach ($media as $img):
											?> 
												<div class="swiper-slide">
													<img src="<?php echo $img->guid;?>"/>
												</div>
											<?php endforeach;?>
                                             
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="desc-assets">
                                <div class="row">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col">
                                        <div class="desc-assets-link">
                                            <a href="/hotels"><img src="images/otel-icon.svg" alt=""> Больше отелей</a>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col">
                                        <div class="desc-assets-link">
                                            <a href="#!"><img src="images/globus-icon.svg" alt=""> О стране</a>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-6">
                                        <div class="desc-assets-link">
                                            <a href="#!"><img src="images/man-icon.svg" alt=""> Экскурсии</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-7 col-lg-6">
                            <div class="desc-block">
                                <div class="desc-info-title">
                                    <span>Описание</span>
                                </div>
                                <div class="desc-info">
                                    <div class="desc-info-item">
                                        <?php echo $Post->post_content; ?>
                                    </div>
 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
		</main>

	  

	<?php
endwhile;
