<?php
/**
 * The template for displaying singular post-types: posts, pages and user-defined custom post types.
 *
 * @package HelloElementor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?>

<main id="content" <?php post_class( 'site-main' ); ?> role="main">

<section class="travel-catalog">
				<div class="container">
					<div class="row">
						<div class="col-lg-3">
							<div class="left-sidebar">
								<div class="sidebar-in">
									<div class="sidebar-title">
										<p>Выберите курорт</p>
									</div>
									<label class="control control--checkbox">
										<input type="checkbox" checked="checkbox"/>
										<div class="control__indicator"></div>
										<span class="active">Все направления <span class="resort-number">(1567)</span></span>
									</label>
									<div class="all-collapse collapse show" id="collapseAll">
										<div class="card card-body">
											<div class="sidebar-checks">
												<div class="side-btn">
													<label class="control control--checkbox">
														<input type="checkbox"/>
														<div class="control__indicator"></div>
													</label>
													<button class="resort-btn" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="true" aria-controls="collapseExample">
														<span>Турция <span class="resort-number">(145)</span></span>
													</button>
												</div>
												<div class="collapse-in collapse show" id="collapseExample">
													<div class="card card-body">
														<label class="control control--checkbox">
															<input type="checkbox"/>
															<div class="control__indicator"></div>
															<span>Алания <span class="resort-number">(45)</span></span>
														</label>
														<label class="control control--checkbox">
															<input type="checkbox"/>
															<div class="control__indicator"></div>
															<span>Белек <span class="resort-number">(50)</span></span>
														</label>
														<label class="control control--checkbox">
															<input type="checkbox"/>
															<div class="control__indicator"></div>
															<span>Кемер <span class="resort-number">(50)</span></span>
														</label>
													</div>
												</div>
											</div>
											<div class="sidebar-checks">
												<div class="side-btn">
													<label class="control control--checkbox">
														<input type="checkbox"/>
														<div class="control__indicator"></div>
													</label>
													<button class="resort-btn" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample2" aria-expanded="false" aria-controls="collapseExample2">
														<span>Греция <span class="resort-number">(345)</span></span>
													</button>
												</div>
												<div class="collapse-in collapse" id="collapseExample2">
													<div class="card card-body">
														<label class="control control--checkbox">
															<input type="checkbox"/>
															<div class="control__indicator"></div>
															<span>Крит <span class="resort-number">(150)</span></span>
														</label>
														<label class="control control--checkbox">
															<input type="checkbox"/>
															<div class="control__indicator"></div>
															<span>Родос <span class="resort-number">(145)</span></span>
														</label>
														<label class="control control--checkbox">
															<input type="checkbox"/>
															<div class="control__indicator"></div>
															<span>Халкидики <span class="resort-number">(100)</span></span>
														</label>
													</div>
												</div>
											</div>
										</div>
									</div>
									<button class="side-drop" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAll" aria-expanded="true" aria-controls="collapseAll">
										<span class="text">Показать меньше</span>
										<span class="icon">
											<svg width="12" height="8" viewBox="0 0 12 8" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path d="M1.4 7.4L0 6L6 0L12 6L10.6 7.4L6 2.8L1.4 7.4Z" fill="#0181DE"/>
											</svg>											
										</span>
									</button>
								</div>

								<div class="for-border"></div>

								<div class="sidebar-rating">
									<div class="sidebar-title">
										<p>Выбор звезд</p>
									</div>
									<div class="rating-stars"> 
										<?php for ($rating=1;$rating<=5;$rating++):?>
										<label class="control control--checkbox">
											<input value="<?php echo $rating; ?>" type="checkbox"/>
											<div class="control__indicator"></div>
											<span class="star-icon">
											<?php for ($i=1;$i<=$rating;$i++):?>
											<img src="<?php echo get_theme_file_uri('images/star-icon.svg');?>" alt="">
											<?php endfor;?>
											</span>
										</label>
										<?php endfor;?>
									</div>
								</div>
							</div>
						</div>

						<div class="col-lg-9">
							<div class="blog-content">
								<div class="blog-search">
									<form action="#!" id="blog-search-id">
										<input type="text" id="blog-search" name="search" placeholder="Введите название отеля...">
										<button type="submit" class="search-btn"><img src="images/search-icon.svg" alt=""></button>
									</form>
								</div>
								<?php /*
								<div class="blog-select">
									<select>
										<option value="25">25</option>
										<option value="10">10</option>
										<option value="50">50</option>
										<option value="50">80</option>
									</select>
								</div> 
								*/?>
<?php


while ( have_posts() ) {
	the_post();
	$Parent = get_post(get_the_ID());
}

$my_posts = get_posts( array(
	'numberposts' => 50,
	'category'    => $Parent->id,
	'orderby'     => 'date',
	'order'       => 'DESC', 
	'post_type'   => 'hotels',
	'suppress_filters' => true, // подавление работы фильтров изменения SQL запроса
) );

foreach( $my_posts as $Post ){
	  
	$rating=get_post_meta($Post->ID,'stars',true);
    if ($rating>5) $rating=5;
	?>


								<div class="blog-item">
									<div class="blog-img">
										<img src="<?php get_the_post_thumbnail( $Post, 'large' );?>" alt="">
									</div>
									<div class="blog-text">
										<div class="blog-info">
											<p><?php echo $Parent->post_title;?></p>
											<h4><?php echo  $Post->post_title;?></h4>
										</div>
										<div class="blog-btn">
											<div class="blog-stars">
											<?php for ($i=1;$i<=$rating;$i++):?>
											<img src="<?php echo get_theme_file_uri('images/star-icon.svg');?>" alt="">
											<?php endfor;?>
											</div>
											<div class="blog-link">
												<a href="<?php echo get_permalink($Post);?>">смотреть</a>
											</div>
										</div>
									</div>
								</div>

 

	<?php
}
wp_reset_postdata();
?>

								<div class="pagination">
									<?php wp_link_pages(); ?>
									<?php /*
									<ul>
										<li><a href="#!" class="prev"><img src="images/pagination-icon.svg" alt=""></a></li>
										<li><a href="#!" class="active">1</a></li>
										<li><a href="#!">2</a></li>
										<li><a href="#!">3</a></li>
										<li><a href="#!">4</a></li>
										<li><a href="#!">5</a></li>
										<li><a href="#!">...</a></li>
										<li><a href="#!">10</a></li>
										<li><a href="#!" class="next"><img src="images/pagination-icon.svg" alt=""></a></li>
									</ul>
									*/?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>

<?php comments_template(); ?>
</main>