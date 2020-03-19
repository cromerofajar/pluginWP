<?php
/*
 * Plugin Name: MiPluginPruebas
 */

function contrasinal_olvidada(){
return 'La contraseña es la misma de simepre!';
}

add_filter( 'login_errors', 'contrasinal_olvidada' );

function base_de_datos() {
    global $wpdb;
    
    $charset_collate = $wpdb->get_charset_collate();
    
    // le añado el prefijo a la tabla
    $table_name = $wpdb->prefix . 'insultos';
    
    // creamos la sentencia sql
    
    $sql = "CREATE TABLE $table_name (
    insulto varchar(20) NOT NULL,
    PRIMARY KEY (insulto)
    ) $charset_collate;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
}

add_action('plugins_loaded','base_de_datos');

function insertar_datos(){
    global $wpdb;
    
    $table_name = $wpdb->prefix."insultos";
    
    $wpdb->insert( $table_name, array("insulto"=>"cabron"));
    $wpdb->insert( $table_name, array("insulto"=>"mamon"));
    $wpdb->insert( $table_name, array("insulto"=>"idiota"));
    $wpdb->insert( $table_name, array("insulto"=>"subnormal")); 
}
add_action('plugins_loaded','insertar_datos');

function filtrar($text){
    global $wpdb;
    
    $aInsultos = $wpdb -> get_results("SELECT insulto from wp_WordPressinsultos");
    $todos = array();
    
    foreach($aInsultos as $valor){
        $todos[]=$valor ->insulto;
    }
    return str_replace($todos,'*****',$text);
}

add_filter('the_content','filtrar');

?>