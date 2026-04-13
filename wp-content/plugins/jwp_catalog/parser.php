<?php

//require_once('./pq.php');


function parsePage($url){
	$content = file_get_contents($url);
	$html = phpQuery::newDocument($content);
	$posts = $html->find('td.product-note');
	$results = array();
	foreach($posts as $post){
		$result = array();
		$title = pq($post)->find('img.catalog_image');
		$img = pq($post)->find('a');
		$pqPrice = pq($post)->find('span.price');
		$result['title'] = $title->attr('alt');
		$result['img'] = saveImage('http://www.anturage-decor.ru/'.$img->attr('href'));
		$result['price'] = (floor(intval($pqPrice->text())/4));
		$results[] = $result; 
	}
	return $results;
}

function saveImage($url = false){
	if(!$url) return false;
	$url = trim($url);
	//$dir = './img/';
	$upload_dir = wp_upload_dir();
	$dir = $upload_dir['path'];
	$ext = substr(strrchr($url, '.'), 1);
	$fname = md5(rand(1111,9999).date('U').$url).$ext;
	$imgFile = @file_get_contents($url);
	if(!$imgFile) {
		$imgFile = @file_get_contents($url);
		if(!$imgFile) return false;
	}
	$res = file_put_contents($dir.'/'.$fname, $imgFile);
	if(!$res) return false;
	return $upload_dir['subdir'].'/'.$fname;
}


$res = array();
$url = 'http://www.anturage-decor.ru/price-plastic-blinds/jalouse/';
$n = 6;
$cat_id = 68;
for($i=1;$i<=$n;$i++){
	$res = '';
	$res = parsePage($url.$i);
	foreach($res as $element){
		if($element){
			$my_post = array(
				 'post_title' => (string)$element['title'],
				 'post_content' => '',
				 'post_status' => 'publish',
				 'post_author' => 1,
				 'post_type' => 'post',
				 'post_category' => array($cat_id)
			  );


			$post_id = wp_insert_post( $my_post );
			
			add_post_meta($post_id, 'jwp_catalog_img', $element['img'], true);
			add_post_meta($post_id, 'jwp_catalog_price', $element['price'], true);
		}
	}
}

?>
