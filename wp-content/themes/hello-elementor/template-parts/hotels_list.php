<?php
/**
 * The template for displaying singular post-types: posts, pages and user-defined custom post types.
 *
 * @package HelloElementor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

while ( have_posts() ) {
	the_post(); 
}
$Parent = get_post(get_the_ID());

$cats = get_posts( array(
	'numberposts' => 200, 
	'orderby'     => 'name',
	'order'       => 'ASC', 
	'post_type'   => 'city',
	'suppress_filters' => true, // подавление работы фильтров изменения SQL запроса
) );


$all = get_posts( array(
	'numberposts' => -1, 
	'post_type'   => 'hotels',
	//'suppress_filters' => true, // подавление работы фильтров изменения SQL запроса
) );

?>

<main id="content" <?php post_class( 'site-main' ); ?> role="main">

<section class="travel-catalog pt-5">
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
										<span class="active">Все направления <span class="resort-number">(<?php echo count($all);?>)</span></span>
									</label>
									<div class="all-collapse collapse show" id="collapseAll">
										<div class="card card-body">
										<?php foreach ($cats as $Cat):?>
											<div class="sidebar-checks">
												<div class="side-btn">
													<label class="control control--checkbox">
														<input type="checkbox" class="hotel_cats" <?php if ($Cat->ID==$Parent->ID) echo 'checked'; ?> OnClick="renew_hotels();" value="<?php echo $Cat->ID;?>" />
														<div class="control__indicator"></div>
													</label>
													<button class="resort-btn" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="true" aria-controls="collapseExample">
														<span><?php echo $Cat->post_title; ?> <span class="resort-number">(<?php echo count(get_pages( array( 'category' => $Cat->ID, 'post_type' => 'hotels'))); ?>)</span></span>
													</button>
												</div> 
											</div>
										<?php endforeach; ?>	 
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
											<input  OnClick="renew_hotels();" class="hotel_stars" value="<?php echo $rating; ?>" type="checkbox"/>
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

						<div class="col-lg-9 pt-5">
							<div class="blog-content" >
								<div class="blog-search">
									<form action="#!" id="blog-search-id">
										<input type="text" id="blog-search" name="search" placeholder="Введите название отеля...">
										<button type="submit"  OnClick="renew_hotels();" class="search-btn"><img src="<?php echo get_theme_file_uri('images/search-icon.svg');?>" alt=""></button>
									</form>
								</div>
								 
								<div class="blog-select">
									<select id="hotel_count"  OnChange="renew_hotels();" >
										<option value="10">10</option>
										<option value="25">25</option>
										<option value="50">50</option>
										<option value="100">100</option>
									</select>
								</div> 
								 

								<div id="ajax_hotels">
<?php



$my_posts = get_posts( array(
	'numberposts' => 10,
	'category'    => $Parent->ID,
	'orderby'     => 'date',
	'order'       => 'DESC', 
	'post_type'   => 'hotels',
	'suppress_filters' => true, // подавление работы фильтров изменения SQL запроса
) );

foreach( $my_posts as $Post ){
	  
	$rating=get_post_meta($Post->ID,'stars',true);
    if ($rating>5) $rating=5;

	 $media = get_attached_media( 'image', $Post->ID );
	foreach ($media as $img) $main_img=$img->guid;
	?>


								<div class="blog-item">
									<div class="blog-img">
										<img src="<?php echo $main_img;?>" alt="">
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
								<?php /*
								<div class="pagination">
									<?php wp_link_pages(); ?>
									
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
									
								</div>
								*/?>
								</div>

							</div>
						</div>
					</div>
				</div>
			</section>
<script>
function renew_hotels(page=0)
{ 
	var div = '#ajax_hotels';
	var search = $('#blog-search').val();
	query='';
	$( ".hotel_cats" ).each(function( i ) {
		if (this.checked)
		{
			var id = this.value;
			query=query+'&cats['+id+']='+id;
		}		
	});
	$( ".hotel_stars" ).each(function( i ) {
		if (this.checked)
		{
			var id = this.value;
			query=query+'&stars['+id+']='+id;
		}		
	});

		$.ajax({
				   type: "GET",
				   url: '/?ajax=hotels_list&page='+page+'&count='+$('#hotel_count').val()+'&category=<?=$Parent->id?>'+query+'&name='+search,
				    cache:false,
					contentType: false,
					processData: false, 
				   success: function(data)
				   {
					    $(div).html(data);  
				   }
		});

	
}
</script>

<?php comments_template(); ?>
</main>