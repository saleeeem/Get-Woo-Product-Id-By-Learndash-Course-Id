//Get product Id by Course Id
function ecare_get_product_id_by_course_id($course_id) {
    $product_id = 0;
    if (!empty($course_id)) {
      global $wpdb;
      $q = "SELECT post_id, meta_value FROM $wpdb->postmeta WHERE meta_key = '_related_course' and meta_value LIKE '%$course_id%' ";
      $products = $wpdb->get_results( $q, ARRAY_A  );
  
      if (!empty($products)) {
        foreach ($products as $product) {
          if ('product' != get_post_type( $product['post_id'] ) || 'publish' != get_post_status( $product['post_id'])) {
            continue;
          }
          $related_courses = unserialize($product['meta_value']);
  
          if (!empty($related_courses) && is_array($related_courses) && in_array($course_id, $related_courses)) {
            // course is attached to product
            $product_id = $product['post_id'];
            break;
  
          }
        }
      }
    }
  
    return $product_id;
  }
