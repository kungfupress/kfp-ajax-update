<?php
/**
 * Plugin Name:  KFP Ajax Update
 * Description:  Probando a actualizar campos con Ajax
 * Version:      0.1.1
 * Author:       Juanan Ruiz
 * Author URI:   https://kungfupress.com/
 */

// Admin menu
add_action("admin_menu", "Kfp_Ajax_Update_menu");

// Links the hook to the function that handles the ajax post update
add_action('wp_ajax_kfp_ajax_update', 'Kfp_Ajax_update');

/**
 * Add the admin menu 
 *
 * @return void
 */
function Kfp_Ajax_Update_menu()
{
    add_menu_page("Formulario Ajax Update", "Ajax Update", "manage_options",
        "kfp_ajax_update_menu", "Kfp_Ajax_Update_admin", "dashicons-feedback", 45);
}

/**
 * Create the admin page where you show and edit your data
 *
 * @return void
 */
function Kfp_Ajax_Update_admin()
{
    
    wp_enqueue_script('kfp-ajax-update', plugins_url('/js/ajax-update.js', __FILE__));
    wp_localize_script('kfp-ajax-update', 'ajax_object', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'ajax_nonce' => wp_create_nonce('ajax_update_' . admin_url('admin-ajax.php')),
    ));
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
        $html .= "<td><textarea class='auto-update' style='width:100%;'>$post->post_excerpt</textarea></td>";
        $html .= "</tr>";
    }
    $html .= '</tbody></table></div>';
    echo $html;
}

/**
 * Handle ajax post
 *
 * @return void
 */
function Kfp_Ajax_update() {
    if ( defined('DOING_AJAX') && DOING_AJAX
        && wp_verify_nonce($_POST['nonce'], 'ajax_update_' . admin_url( 'admin-ajax.php'))) {
        $args = array(
            'ID' => $_POST['post_id'],
            'post_excerpt' => $_POST['post_excerpt']
        );
        wp_update_post($args);
        echo "Ok";
        die();
    } else {
        die('Error');
    }
}
