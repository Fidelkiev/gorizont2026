<?php

add_action( 'init', 'create_catalog_taxonomy', 0 );


function create_catalog_taxonomy(){
  // заголовки
  $labels = array(
    'name' => _x( 'Рубрики', 'taxonomy general name' ),
    'singular_name' => _x( 'Рубрики', 'taxonomy singular name' ),
    'search_items' =>  __( 'Поиск по рубрикам' ),
    'all_items' => __( 'Все рубрики' ),
    'parent_item' => __( 'Родительские рубрики' ),
    'parent_item_colon' => __( 'Родительская рубрика:' ),
    'edit_item' => __( 'Редактировать рубрику' ),
    'update_item' => __( 'Обновить рубрику' ),
    'add_new_item' => __( 'Добавить рубрику' ),
    'new_item_name' => __( 'Имя новой рубрики' ),
    'menu_name' => __( 'Рубрики' ),
  );

  // Добавляем древовидную таксономию
  register_taxonomy('xuipizda', array('material'), array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'materiali' )
  ));


}


add_action('init', 'jwp_catalog_init');  
function jwp_catalog_init(){  
  $labels = array(  
    'name' => 'Материалы', // Основное название типа записи  
    'singular_name' => 'ОМатериалы', // отдельное название записи
    'add_new' => 'Добавить новое',  
    'add_new_item' => 'Добавить новый материал',  
    'edit_item' => 'Редактировать оматериал',  
    'new_item' => 'Новый материал',  
    'view_item' => 'Посмотреть материал',  
    'search_items' => 'Найти материал',  
    'not_found' =>  'материал не найдено',  
    'not_found_in_trash' => 'В корзине оматериал не найдено',  
    'parent_item_colon' => '',  
    'menu_name' => 'Материалы'  
  
  );  
  $args = array(  
    'labels' => $labels,  
    'public' => true,  
    'publicly_queryable' => true,  
    'show_ui' => true,  
    'show_in_menu' => true,  
    'query_var' => true,  
    'rewrite' => true,  
    'capability_type' => 'post',  
    'has_archive' => true,  
    'hierarchical' => false,  
    'menu_position' => null,  
    'supports' => array('title', 'editor', 'thumbnail'),
    'taxonomies' => array('xuipizda') 
  );  
  register_post_type('material',$args);  
}  
  
add_theme_support('post-thumbnails', array('material'));

?>
