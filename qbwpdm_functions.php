<?php
/**
 * function to list all packages
 *
 */
function wpdm_available_packages($params = array())
{
    global $wpdb, $current_user, $wp_query;
    $items = isset($params['items_per_page']) && $params['items_per_page'] > 0 ? $params['items_per_page'] : 20;
    $cp = isset($wp_query->query_vars['paged']) && $wp_query->query_vars['paged'] > 0 ? $wp_query->query_vars['paged'] : 1;
    $terms = isset($params['categories']) ? explode(",", $params['categories']) : array();
    if (isset($_GET['wpdmc'])) $terms = array(esc_attr($_GET['wpdmc']));
    $offset = ($cp - 1) * $items;
    $total_files = wp_count_posts('wpdmpro')->publish;
    if (count($terms) > 0) {
        $tax_query = array(array(
            'taxonomy' => 'wpdmcategory',
            'field' => 'slug',
            'terms' => $terms,
            'operator' => 'IN'
        ));
    }

    //foreach($files as $file){
    //$users = explode(',',get_option("wpdm_package_selected_members_only_".$file['ID']));
    //$roles = unserialize($file['access']);
    //$myrole = $current_user->roles[0];
    //if(@in_array($current_user->user_login,$users)||@in_array($myrole, $roles))
    //$myfiles[] = $file;
    //}
    ob_start();
    include("wpdm-available-downloads.php");
    $data = ob_get_contents();
    ob_clean();
    return $data;
}
add_shortcode('wpdm-available-packages', 'wpdm_available_packages');