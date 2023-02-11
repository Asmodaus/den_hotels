<?php 
 
require_once(ABSPATH . '/wp-load.php');
require_once(ABSPATH . '/wp-config.php'); 
require_once(ABSPATH . '/wp-includes/class-wpdb.php'); 
require_once(ABSPATH . '/wp-admin/includes/taxonomy.php');
require_once(ABSPATH . "wp-admin" . '/includes/image.php');
require_once(ABSPATH . "wp-admin" . '/includes/file.php');
require_once(ABSPATH . "wp-admin" . '/includes/media.php');
//require ABSPATH . '/wp-content/plugins/polylang/vendor/autoload.php';
//require_once(ABSPATH . '/wp-content/plugins/polylang/polylang.php'); 
//require_once(dirname(__FILE__) . '/wp-content/plugins/polylang/include/api.php'); 

if (is_array($_GET['cats'])) $cats=$_GET['cats'];
else $cats=$_GET['category'];
$page=(int)($_GET['c_page'] ?? 0);
$page_count=(int)($_GET['count'] ?? 10);
$query=array(
	'number' => $page_count,
    'offset'=>$page*$page_count,
	'category'    => $cats,
	'orderby'     => 'date',
	'order'       => 'DESC', 
	'post_type'   => 'hotels',
	//'suppress_filters' => true, // подавление работы фильтров изменения SQL запроса
);

if (is_array($_GET['stars']) && count($_GET['stars']))
{
    $query['meta_key']='stars';
    $query['meta_value']=$_GET['stars'];
}


if (strlen($_GET['b_search'])  )
{
    $query['s']=$_GET['b_search']; 
}

$my_posts = get_pages( $query );

unset($query['page']);
unset($query['paged']);
$all_posts = count(get_pages( $query ));

foreach( $my_posts as $Post )
if (strlen($_GET['b_search'])==0 || strpos($Post->post_content,$_GET['b_search'])!==false  || strpos($Post->post_title,$_GET['b_search'])!==false )
{
	  
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

if ($all_posts>$page_count):
?>
<div class="pagination">
									 
    <ul>
        <li><a href="#!" class="prev"><img src="<?php echo get_theme_file_uri('images/pagination-icon.svg');?>" alt=""></a></li>
        <?php for($i=0;$i<=ceil($all_posts/$page_count);$i++):?>
        <li><a href="#!" OnClick="renew_hotel(<?php echo $i;?>)" <?php if ($i==$page)  echo 'class="active"'; ?> ><?php echo $i+1; ?></a></li>
        <?php endfor;?>
        <li><a href="#!" class="next"><img src="<?php echo get_theme_file_uri('images/pagination-icon.svg');?>" alt=""></a></li>
    </ul>
    
</div>
<?php endif;?>