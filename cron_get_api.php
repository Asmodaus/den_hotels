<?php 


define('WP_DEBUG', true); 
define( 'WP_DEBUG_LOG', false ); 
define( 'WP_DEBUG_DISPLAY', true ); 
@ini_set( 'display_errors', 0 );
require_once(dirname(__FILE__) . '/wp-load.php');
require_once(dirname(__FILE__) . '/wp-config.php'); 
require_once(dirname(__FILE__) . '/wp-includes/class-wpdb.php'); 
require_once(dirname(__FILE__) . '/wp-admin/includes/taxonomy.php');
require_once(dirname(__FILE__) . '/wp-content/plugins/polylang/polylang.php'); 
//require_once(dirname(__FILE__) . '/wp-content/plugins/polylang/include/api.php'); 


function c_get($url)
{
    
$curl = curl_init(); // инициализируем cURL
/*Дальше устанавливаем опции запроса в любом порядке*/
//Здесь устанавливаем URL к которому нужно обращаться
curl_setopt($curl, CURLOPT_URL,$url);
//Настойка опций cookie 
//устанавливаем наш вариат клиента (браузера) и вид ОС
curl_setopt($curl, CURLOPT_USERAGENT, "Opera/10.00 (Windows NT 5.1; U; ru) Presto/2.2.0");
//Установите эту опцию в ненулевое значение, если вы хотите, чтобы PHP завершал работу скрыто, если возвращаемый HTTP-код имеет значение выше 300. По умолчанию страница возвращается нормально с игнорированием кода.
curl_setopt($curl, CURLOPT_FAILONERROR, 1); 
//Максимальное время в секундах, которое вы отводите для работы CURL-функций.
curl_setopt($curl, CURLOPT_TIMEOUT, 3); 
//ответственный момент здесь мы передаем наши переменные 
//Установите эту опцию в ненулевое значение, если вы хотите, чтобы шапка/header ответа включалась в вывод.
curl_setopt($curl, CURLOPT_HEADER, 1);
//Внимание, важный момент, сертификатов, естественно, у нас нет, так что все отключаем
curl_setopt ($curl, CURLOPT_SSL_VERIFYPEER, 0);// не проверять SSL сертификат
curl_setopt ($curl, CURLOPT_SSL_VERIFYHOST, 0);// не проверять Host SSL сертификата
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);// разрешаем редиректы
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_SSL_CIPHER_LIST, 'DEFAULT@SECLEVEL=1');
$html = curl_exec($curl); // выполняем запрос и записываем в переменную
//echo curl_error($curl);
curl_close($curl); // заканчиваем работу curl
return $html;
}

function parse_data($url)
{
        
    $xmlfile = c_get($url);
	$xml = explode('<xml>',$xmlfile);
	$xml='<xml>'.$xml[1];
    // Convert xml string into an object
    $new = simplexml_load_string($xml); 
    // Convert into json
    $con = json_encode($new);
    // Convert into associative array
    return $newArr = json_decode($con, true);


}

function add_post($params)
{
	if (strlen($params['name'])<1) return false;
    $params['name']=sanitize_text_field($params['name']);
	if (strlen($params['name'])<1) return false;
	 
    $ppp = get_page_by_title($params['name']);
	print_r($ppp);
    if (isset($ppp->ID)) $post_id=$ppp->ID;
    else 
    {
		
        if ($params['is_cat'])
        {
            $post_id = wp_create_category($params['name'],$params['category']);
        }
        else {
            $post_data = array(
                'post_title' => $params['name'],
                'post_content' => $params['text'],
                'post_status' => 'publish',
                'post_author' => 1,
				'post_type'=>'hotels',
                'post_category' => [$params['category']]
            ); 
            
            // Вставляем запись в базу данных
            $post_id = wp_insert_post($post_data, true); 
			
        }
        echo '<br>Пост добавлен '.$params['name'].' '.$post_id;
        if (isset($params['imgs']) && is_array($params['imgs']))
        foreach ($params['imgs'] as $url)
        { 
            // Установим данные файла
            $file_array = array();
            $tmp = download_url($url); 
            // Получаем имя файла
            preg_match('/[^\?]+\.(jpg|jpe|jpeg|gif|png)/i', $url, $matches );
            $file_array['name'] = basename($matches[0]);
            $file_array['tmp_name'] = $tmp;
            // загружаем файл
            $media_id = media_handle_sideload( $file_array, $post_id, $params['name']);
            // Проверяем на наличие ошибок
            if( is_wp_error($media_id) ) {
                @unlink($file_array['tmp_name']);
                echo $media_id->get_error_messages();
            }
            // Удаляем временный файл
            @unlink( $file_array['tmp_name'] );
            // Файл сохранён и добавлен в медиатеку WP. Теперь назначаем его в качестве облож
            set_post_thumbnail($post_id, $media_id);
        }
    }
  
    foreach ($params as $param=>$value)
        if (!in_array($param,['name','text','category','imgs','is_cat']))
            update_post_meta($post_id , $param, $value); 
	
    return $post_id;
}
$resorts=parse_data('https://agents.alida.lv/xml.php?what=resorts');
  
foreach ($resorts['resort'] as $resort)
{
    $params_ru = $params=['name'=>$resort['name_lv'],'is_cat'=>true,'category'=>120];
    $params_ru['name']=$resort['name_ru'];
    $post_id = add_post($params);
    $post_id_ru = add_post($params_ru);
    $translations = [
        'lv' => $post_id, 
        'ru' => $post_id_ru, 
    ] ;
    if ($post_id && $post_id_ru)
	{
		foreach ($translations as $lang=>$pid) pll_set_post_language($pid,$lang);
		pll_save_post_translations( $translations );

		//берем уже отели
		$hotels=parse_data($resort['hotels_xml']);
		foreach ($hotels['hotel'] as $hotel)
		{
			$params=['name'=>$hotel['name'],'rating'=>$hotel['stars'],'post_content'=>$hotel['description_lv'],'category'=>$post_id];
		   
			foreach ($hotel['images'] as $img)
			{
				$params['imgs'][]=$img['image']['path_big'];
			}

			$params_ru = $params;
			$params_ru['post_content']=$hotel['description_ru'];
			$params_ru['category']=$post_id_ru;

			$h_post_id = add_post($params);
			$h_post_id_ru = add_post($params_ru);
			$translations = [
				'lv' => $h_post_id, 
				'ru' => $h_post_id_ru, 
			] ;
			
			foreach ($translations as $lang=>$pid) pll_set_post_language($pid,$lang);
			pll_save_post_translations( $translations );
		}
	}
}