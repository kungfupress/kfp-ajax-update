<?php
/**
 * Plugin Name:  KFP Ajax Update
 * Description:  Probando a actualizar campos con Ajax
 * Version:      0.1.1
 * Author:       Juanan Ruiz
 * Author URI:   https://kungfupress.com/
 */

add_action("admin_menu", "Kfp_Ajax_Update_menu");

/**
 * Agrega el menú del plugin al formulario de WordPress
 *
 * @return void
 */
function Kfp_Ajax_Update_menu()
{
    add_menu_page("Formulario Ajax Update", "Ajax Update", "manage_options",
        "kfp_ajax_update_menu", "Kfp_Ajax_Update_admin", "dashicons-feedback", 45);
}

function Kfp_Ajax_Update_admin()
{
    wp_enqueue_script('kfp-ajax-update', plugins_url('../js/ajax-update.js', __FILE__));
    $args = array( 'post_type' => 'post', 'posts_per_page' => -1, 'orderby' => 'title', 
        'order' => 'DESC', 'post_status' => 'publish' );
    $myposts = get_posts( $args );

    $html = '<div class="wrap"><h1>Ajax Update</h1>';
    $html .= '<table class="wp-list-table widefat fixed striped posts">';
    $html .= '<thead><tr>';
    $html .= '<th class="manage-column column-columnname"  width="30%">Title</th>';
    $html .= '<th class="manage-column column-columnname">Excerpt</th>';
    $html .= '</tr></thead><tbody>';
    foreach($myposts as $post) {
        $html .= "<tr data-post_id='$post->ID'>";
        $html .= "<td>$post->post_title</td>";
        $html .= "<td><textarea style='width:100%;'>$post->post_excerpt</textarea></td>";
        $html .= "</tr>";
    }
    $html .= '</tbody></table></div>';
    echo $html;
}
