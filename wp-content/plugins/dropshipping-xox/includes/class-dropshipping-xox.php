<?php
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://xolluteon.com
 * @since      1.0.0
 *
 * @package    Dropshipping_Xox
 * @subpackage Dropshipping_Xox/includes
 */
/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Dropshipping_Xox
 * @subpackage Dropshipping_Xox/includes
 * @author     xolluteon <developer@xolluteon.com>
 */
class Dropshipping_Xox {
	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Dropshipping_Xox_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		$this->plugin_name = 'dropshipping-xox';
		$this->version = '3.1.10';
		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
	}
	
	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Dropshipping_Xox_Loader. Orchestrates the hooks of the plugin.
	 * - Dropshipping_Xox_i18n. Defines internationalization functionality.
	 * - Dropshipping_Xox_Admin. Defines all hooks for the admin area.
	 * - Dropshipping_Xox_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {
		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-dropshipping-xox-loader.php';
		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-dropshipping-xox-i18n.php';
		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-dropshipping-xox-admin.php';
		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-dropshipping-xox-public.php';
		$this->loader = new Dropshipping_Xox_Loader();
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Dropshipping_Xox_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {
		$plugin_i18n = new Dropshipping_Xox_i18n();
		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {
		$plugin_admin = new Dropshipping_Xox_Admin( $this->get_plugin_name(), $this->get_version() );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {
		$plugin_public = new Dropshipping_Xox_Public( $this->get_plugin_name(), $this->get_version() );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Dropshipping_Xox_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

	public function optionSetting()
	{
		include_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/templates/homesetting.php';
	}

	public function searchPage()
	{
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-dropshipping-xox-connection.php';
		// include_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/templates/search-product.php';
		$connect = new xDropShipConnect();
		$url = $connect->loadSearchUri();

		$return = '';
		$return .= '<div class="wrap" style="margin: 0; position: relative;">';
		?>
		<div class="nav-to-dropshix" style="padding: 5px;">
			<ul>
				<li><a href="javascript:;" class="changeSupplier btn btn-primary" data-source="ae">AliExpress</a></li>
				<li><a href="javascript:;" class="changeSupplier btn btn-primary" data-source="amus">Amazon US</a></li>
			</ul>
		</div>
		<?php
		$return .= '<div class="welcome-panel" style="border: 0; margin: 0; padding: 0;">';
		if($url != ''){
			$return .= '<iframe src="'. $url .'" id="dropshix-frame" class="dropshix_load_iframe"></iframe>';
		}else{
			$return .= '<h3 class="alert alert-error">You have not chose your source store.</h3>';
		}
		$return .= '</div>';
		$return .= '<div class="loading-layer"><h3>Waiting supplier server respond, this process can take a while...<br>Please Wait!</h3></div>';
		$return .= '</div>';
		echo $return;
	}

	public function getSourceStore($source)
	{
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-dropshipping-xox-connection.php';
		// include_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/templates/search-product.php';
		$connect = new xDropShipConnect();
		$url = $connect->getSupplierURL($source);

		return $url;
	}

	public function listQueued($type = 'xox-pending')
	{
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-dropshipping-xox-connection.php';
		$connect = new xDropShipConnect();
		$return = $connect->getQueuedListings($type);
		return $return;
	}

	public function updateSetting( $data ){
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-dropshipping-xox-connection.php';
		$connect = new xDropShipConnect();
		$connect->createOrUpdateSetting($data);
		return $connect;
	}
	
	public function importProduct( $id, $data ){
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-dropshipping-xox-connection.php';
		$post = array(
                'post_title' => $data['title'],
                'post_content' => $data['description'],
                'post_status' => 'publish',
                'post_type' => 'product'
            );
        $wooid = wp_insert_post($post);

        $src = $data['source'];
		$connect = new xDropShipConnect();
		$result = $connect->actionProduct( 'import-product', $id, $src, $wooid);

		if($result->status == 'ERROR'){
			$data['status'] = false;
			$data['msg'] = $result->errorMsg;
			return json_encode($data);
		}else{
			$result = $result->result;
			// var_dump($result); exit;
			$importwoocomerce = $this->addToWoocomerce( $id, $wooid, $result);
			// var_dump($importwoocomerce); exit;
			if($importwoocomerce){
				$data['status'] = true;
				$data['url'] = get_edit_post_link($wooid);
				$data['view'] = get_permalink($wooid);
				$data['source'] = $src;
				$data['wooid'] = $wooid;
				return json_encode($data);
			}else{
				$data['status'] = false;
				wp_delete_post( $wooid, true);
				return json_encode($data);
			}
		}
	}

	private function addToWoocomerce( $id, $post_id, $result )
	{
		$product_type = 'simple';
        wp_set_object_terms($post_id, $product_type, 'product_type');
        update_post_meta($post_id, '_stock_status', 'instock');
        update_post_meta($post_id, '_sku', $result->productId);
        update_post_meta($post_id, '_product_url', $result->productUrl);
        update_post_meta($post_id, 'import_type', $result->packageType);
        update_post_meta($post_id, 'external_id', $result->productId);
        update_post_meta($post_id, 'seller_url', $result->storeUrl);
        update_post_meta($post_id, 'product_url', $result->productUrl);
        update_post_meta($post_id, '_regular_price', (float) str_replace('US $', '', $result->price));
        if(isset($result->salePrice)){
            update_post_meta($post_id, '_sale_price', (float) str_replace('US $', '', $result->salePrice));
        }
        update_post_meta($post_id, '_price', (float) str_replace('US $', '', $result->price));
        update_post_meta($post_id, '_manage_stock', 'yes');
        $stock = isset($result->availQuantity) ? $result->availQuantity : 1;
        update_post_meta($post_id, '_stock', $stock );
        update_post_meta($post_id, '_visibility', 'visible');
        if(isset($result->productUrl)){
            update_post_meta($post_id, 'original_product_url', $result->productUrl);
        }
        if(isset($result->discount)){
            update_post_meta($post_id, 'discount_perc', $result->discount);
        }
        if ($result->imageUrl) {
            $this->attachIMG($result->imageUrl, $post_id,true);
        }
        if( isset($result->allImageUrls) ){
        	$allImages = explode(',', $result->allImageUrls);
        $galeryAll = '';
        $cnt = 0;
        foreach ( $allImages as $img_gallery) {
            if ($result->imageUrl !== $img_gallery) {
                try {
                    $galeryAll .= $this->attachIMG($img_gallery, $post_id). ',';
                } catch (Exception $e) {
                    $result['state'] = 'warn';
                    $result['message'] = "\nimg_warn: $img_gallery";
                }                
            }
        }
        update_post_meta($post_id, '_product_image_gallery', $galeryAll);
        }
        return true;
    }

    private function attachIMG($url, $post_id, $status = false)
	{
    	//add product image:
		//require_once 'inc/add_pic.php';
		require_once(ABSPATH . 'wp-admin/includes/file.php');
		require_once(ABSPATH . 'wp-admin/includes/media.php');
		$thumb_url = $url;
		// Download file to temp location
		$tmp = download_url( $thumb_url );
		// Set variables for storage
		// fix file name for query strings
		preg_match('/[^\?]+\.(jpg|JPG|jpe|JPE|jpeg|JPEG|gif|GIF|png|PNG)/', $thumb_url, $matches);
		$file_array['name'] = basename($matches[0]);
		$file_array['tmp_name'] = $tmp;
		// If error storing temporarily, unlink
		$logtxt = '';
		if ( is_wp_error( $tmp ) ) {
			@unlink($file_array['tmp_name']);
			$file_array['tmp_name'] = '';
			$logtxt .= "Error: download_url error - $tmp\n";
		}else{
			$logtxt .= "download_url: $tmp\n";
		}
		//use media_handle_sideload to upload img:
		$thumbid = media_handle_sideload( $file_array, $post_id, 'gallery desc' );

		// If error storing permanently, unlink
		if ( is_wp_error($thumbid) ) {
			@unlink($file_array['tmp_name']);
			//return $thumbid;
			$logtxt .= "Error: media_handle_sideload error - $thumbid\n";
		}else{
			$logtxt .= "ThumbID: $thumbid\n";
		}
		if($status){
			set_post_thumbnail($post_id, $thumbid);
			$src = wp_get_attachment_url( $thumbid );
			add_post_meta($thumbid, '_wp_attachment_image_alt', $src);
		}
		return $thumbid;
	}

	public function deleteProduct( $id, $source ){
		if($source == null) return false;

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-dropshipping-xox-connection.php';
		$connect = new xDropShipConnect();
		$result = $connect->actionProduct( 'delete-product', $id, $source);
		if($result){
			$data['status'] = true;
			$wooid = wc_get_product_id_by_sku($id);
		}else{			
			$data['status'] = false;
			$wooid = wc_get_product_id_by_sku($id);
		}
		// before deleting the products delete the images attached.
		$attachments = get_attached_media( '', $wooid );
		foreach ($attachments as $attachment) {
			wp_delete_attachment( $attachment->ID, true );
		}

		wp_delete_post( $wooid);
		return json_encode($data);
	}

	public function archiveProduct( $id, $source ){
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-dropshipping-xox-connection.php';

		$connect = new xDropShipConnect();
		$result = $connect->actionProduct( 'archive-product', $id, $source);
		if($result){
			if($result->status != 'ERROR'){
				$data['status'] = true;
				$wooid = wc_get_product_id_by_sku($id);
				if($wooid != NULL ){
					wp_delete_post( $wooid);
				}
				return json_encode($data);
			}else{
				$data['status'] = false;
				return json_encode($data);	
			}
		}else{			
			$data['status'] = false;
			return json_encode($data);
		}
	}

	public function getProfitUrlSetup()
    {
    	$options = get_option( 'dropshix_opt' );
		// we'll save all the credentials here for future connect activity
		$public = isset($options['dropshix_API_public']) ? ($options['dropshix_API_public']) : '' ;
		$private = isset($options['dropshix_API_private']) ? ($options['dropshix_API_private']) : '' ;
		$domain = $_SERVER['SERVER_NAME'];
		if(strpos('www.', $domain) != false){
			$domain = str_replace('www.', '', $domain);
		}else{
			$domain = $domain;
		}
        
        $auth = base64_encode($public.'|'.$private.'|'.$domain);
		$url = '//dropshix.xolluteon.com/dropshix/api/v1/'.$auth.'/setting-new';

        return $url;
    }

	public function myAccount()
    {
    	require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-dropshipping-xox-connection.php';
		$connect = new xDropShipConnect();
		$result = $connect->getProfile();
        return $result;
    }

	public function getOrderDetails($order_id)
	{
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-dropshipping-xox-connection.php';
		$connect = new xDropShipConnect();
		$result = $connect->getOrderList($order_id);
	    return $result;
	}

	public function checkAttr($woo_id)
	{
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-dropshipping-xox-connection.php';
		$connect = new xDropShipConnect();
		$result = $connect->checkAttr($woo_id);
	    return $result;
	}

	public function importAttr($woo_id)
	{
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-dropshipping-xox-connection.php';
		$connect = new xDropShipConnect();
		$result = $connect->importAttr($woo_id);
	    return $result;
	}

	public function importAttrVar($woo_id)
	{
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-dropshipping-xox-connection.php';
		$connect = new xDropShipConnect();
		$result = $connect->importAttrVar($woo_id);
	    return $result;
	}

	public function distributeAttrVar( $post_id, $imports )
	{
		$return = array();
		$error = 0;

		// distribute attributes.
		$attributes = $imports->attributes;
		$this->insertProductAttributes( $post_id, $attributes );

		// distribute variations.
		$variations = $imports->variations;
		$insertVar = $this->insertProductVariations( $post_id, $variations );

		$error = $error+$insertVar;

		$the_product = array(
			'ID' => $post_id,
			'post_date' => date("Y-m-d H:i:s")
		);

		wp_update_post( $the_product );

		if($error > 0){
			$return['status'] = 'error';
			$return['message'] = 'variations import failed.';
		}else{
			$return['status'] = 'succes';
			$return['message'] = 'variations are imported.';
		}

		return $return;
		// wp_die();
	}

	private function insertProductAttributes( $post_id, $attributes )  
	{
	    foreach($attributes as $key => $i){
			$_product_attributes[$i->the_title] = array(
			    'name' => $i->the_label,
			    'value' => $i->the_value,
			    'position' => 0,
			    'is_visible' => 1,
			    'is_variation' => 1,
			    'is_taxonomy' => 0
			);
			update_post_meta( $post_id, '_product_attributes', $_product_attributes );

		}

		return 0;
	}

	private function insertProductVariations( $post_id, $variations)
	{
		$return = 0;
		foreach ($variations as $index => $variation){
		    $variation_post = array( // Setup the post data for the variation

		        'post_title'  => 'Variation #'.$index.' of '.count($variations).' for product#'. $post_id,
		        'post_name'   => 'product-'.$post_id.'-variation-'.$index,
		        'post_status' => 'publish',
		        'post_parent' => $post_id,
		        'post_type'   => 'product_variation',
		        'guid'        => home_url() . '/?product_variation=product-' . $post_id . '-variation-' . $index
		    );

		    $variation_post_id = wp_insert_post($variation_post); // Insert the variation
		    foreach ($variation->attributes as $attribute) // Loop through the variations attributes
		    {
		    	foreach($attribute as $key => $value){
					// We need to insert the slug not the name into the variation post meta
					$attribute_slug = apply_filters('sanitize_title', $key);

					update_post_meta($variation_post_id, 'attribute_'.$attribute_slug, $value);
		    	}
		    }

		    // if image is available import.
		    if(isset($variation->image)){
		    	$image_str = $variation->image;
		    	$image_arr = explode(',', $image_str);
		    	$thumb_id = $this->attachIMG($image_arr[0], $post_id, true);
		    	add_post_meta($variation_post_id, '_thumbnail_id', $thumb_id);
		    }

		    // import prices
		    update_post_meta($variation_post_id, '_price', $variation->price);
		    update_post_meta($variation_post_id, '_regular_price', $variation->price);
		    if(isset($variation->salePrice) && ($variation->salePrice != '' || $variation->salePrice != 0)) 
		    	update_post_meta($variation_post_id, '_sale_price', $variation->salePrice);

		    // import sku
		    update_post_meta($variation_post_id, '_sku', $variation->sku);

		    // update other information.
			update_post_meta($variation_post_id, '_virtual', 'no');
			update_post_meta($variation_post_id, '_downloadable', 'no');
			update_post_meta($variation_post_id, '_manage_stock', 'no');
			update_post_meta($variation_post_id, '_stock_status', 'instock');
		}
		return $return;
	}

	public function resetPriceMeta($disable, $post_id)
	{
		$output = 'ok';

		if (get_post_type($post_id) == 'product') {
			$post_id = intval($post_id);
			try {
				update_post_meta( $post_id, '_no_sale_price', $disable );
			} catch (Exception $e) {
				$output = 'Failed: ' . $e->getMessage();
			}
		}
		return $output;
	}

	public function getScanAttrURL($woo_id)
	{
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-dropshipping-xox-connection.php';
		$connect = new xDropShipConnect();
		$result = $connect->getScanAttrURL($woo_id);
	    return $result;
	}
	
	public function getReportUrl(){
    	$options = get_option( 'dropshix_opt' );
		// we'll save all the credentials here for future connect activity
		$public = isset($options['dropshix_API_public']) ? ($options['dropshix_API_public']) : '' ;
		$private = isset($options['dropshix_API_private']) ? ($options['dropshix_API_private']) : '' ;
		$domain = $_SERVER['SERVER_NAME'];
		if(strpos('www.', $domain) != false){
			$domain = str_replace('www.', '', $domain);
		}else{
			$domain = $domain;
		}
        
        $auth = base64_encode($public.'|'.$private.'|'.$domain);
		$url = '//dropshix.xolluteon.com/dropshix/api/v1/'.$auth.'/report-chart';

        return $url;
    }

	public function getKeys(){
		$options = get_option( 'dropshix_opt' );
		// we'll save all the credentials here for future connect activity
		$public = isset($options['dropshix_API_public']) ? ($options['dropshix_API_public']) : '' ;
		$private = isset($options['dropshix_API_private']) ? ($options['dropshix_API_private']) : '' ;
		$domain = $_SERVER['SERVER_NAME'];
		$domain = str_replace('www.', '', $domain);
		
	    $auth = base64_encode($public.'|'.$private.'|'.$domain);

	    return $auth;
	}

    function sendAnalytics($action, $item){
    	require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-dropshipping-xox-connection.php';
    	$connect = new xDropShipConnect();
		$connect->sendingAnalytics( $action, $item );
    }

    function orders($var){
    	require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-dropshipping-xox-connection.php';
    	$connect = new xDropShipConnect();
		$connect->sendingOrders( $var );
    }

}
