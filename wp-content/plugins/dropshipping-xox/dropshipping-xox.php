<?php
/**
 *
 * @link              https://dropshix.xolluteon.com
 * @since             0.0.1
 * @package           Dropshipping_Xox
 *
 * @wordpress-plugin
 * Plugin Name:       Dropshipping Xox
 * Plugin URI:        https://dropshix.xolluteon.com
 * Description:       WooCommerce Dropshipping tool plugin, autopilotting your dropshipping to keep you gain profit (always).
 * Version:           3.1.10
 * Author:            xolluteon
 * Author URI:        https://profiles.wordpress.org/dedong/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       dropshix
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
require_once plugin_dir_path( __FILE__ ) . 'includes/class-dropshipping-xox-autoupdate.php';

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-dropshipping-xox-activator.php
 */

function activate_dropshipping_xox() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-dropshipping-xox-activator.php';
	Dropshipping_Xox_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-dropshipping-xox-deactivator.php
 */
function deactivate_dropshipping_xox() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-dropshipping-xox-deactivator.php';
	Dropshipping_Xox_Deactivator::deactivate();
}
register_activation_hook( __FILE__, 'activate_dropshipping_xox' );
register_deactivation_hook( __FILE__, 'deactivate_dropshipping_xox' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-dropshipping-xox.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_dropshipping_xox() {
	$plugin = new Dropshipping_Xox();
	$plugin->run();
	$plugin->optionSetting();
}
run_dropshipping_xox();

function menu_init_dropshix(){
    add_menu_page( 
        __( 'Basic Setting', 'dropshix' ),
        'Dropshix™', 
        'manage_options', 
        'dropshix-opt', 
        'pageAdmindropshix',
        'dashicons-cart',
        88 );
    add_submenu_page( 'dropshix-opt', 'Search Product', 'Search Product', 'manage_woocommerce', 'dropshix-search-product', 'searchProductdropshix');
    
    add_submenu_page( 'dropshix-opt', 'Queued Products', 'Queued Products', 'manage_woocommerce', 'dropshix-queued-page', 'queuedPagedropshix');
    add_submenu_page( 'dropshix-opt', 'Active Products', 'Active Products', 'manage_woocommerce', 'dropshix-active-page', 'activePagedropshix');
    add_submenu_page( 'dropshix-opt', 'Inactive Listings', 'Inactive Listings', 'manage_woocommerce', 'dropshix-inactive-page', 'inActivePagedropshix');
    // add_submenu_page( 'dropshix-opt', 'Report', 'Report Chart', 'manage_options', 'dropshix-report-page', 'reportPagedropshix');
}
add_action( 'admin_menu', 'menu_init_dropshix' );

add_action( 'woocommerce_product_options_general_product_data', 'woocommerceXoxCustomFieldProductMeta' ); 
add_action( 'woocommerce_process_product_meta', 'woocommerceXoxCustomFieldProductMeta_save' );

function woocommerceXoxCustomFieldProductMeta() {
    global $woocommerce, $post;
    echo '<div class="product_custom_field">';
    woocommerce_wp_text_input(
        array(
            'id' => '_product_url',
            'placeholder' => 'Http://',
            'label' => __('Product Url', 'woocommerce'),
            'desc_tip' => 'true'
        )
    );
    echo '</div>'; 
}

function woocommerceXoxCustomFieldProductMeta_save( $post_id ){
    $product_url = sanitize_text_field( strval( $_POST['_product_url'] ) );
    if (!empty($product_url))
        update_post_meta($post_id, '_custom_product_text_field', esc_attr($product_url)); 
}

function dropshix_settings_init() {
    register_setting( 'dropshix', 'dropshix_opt');
    add_settings_section(
        'dropshix_section_developers',
        __( 'General Option', 'dropshix' ),
        'dropshix_section_dev_cb',
        'dropshix'
    );
    add_settings_field(
        'dropshix_API_public',
        __( 'PUBLIC Key', 'dropshix' ),
        'dropshix_field_pill_cb',
        'dropshix',
        'dropshix_section_developers',
        [
            'label_for' => 'dropshix_API_public',
            'class' => 'dropshix_row',
            'dropshix_custom_data' => 'custom',
        ]
    );
    add_settings_field(
        'dropshix_API_private',
        __( 'PRIVATE Key', 'dropshix' ),
        'dropshix_field_pill_cb2',
        'dropshix',
        'dropshix_section_developers',
        [
            'label_for' => 'dropshix_API_private',
            'class' => 'dropshix_row',
            'dropshix_custom_data' => 'custom',
        ]
    );
    add_settings_field("dropshix_tool_source", __( 'Select Default Supplier', 'dropshix' ), "dropshix_tool_select", "dropshix", "dropshix_section_developers");

}

function dropshix_tool_select()
{
	$value = get_option('dropshix_opt');
   	?>
        <select name="dropshix_opt[x_tool_source]" id="dropshix_tool_source" class="dropshix_row">
          	<option value="" <?php isset($value['x_tool_source']) ? selected($value['x_tool_source'], "") : '' ; ?>>Select Source</option>
          	<option value="ae" <?php isset($value['x_tool_source']) ? selected($value['x_tool_source'], "ae") : '' ; ?>>AliExpress</option>
          	<option value="amus" <?php isset($value['x_tool_source']) ? selected($value['x_tool_source'], "amus") : '' ; ?>>Amazon US</option>
        </select>
   	<?php
}

add_action( 'admin_init', 'dropshix_settings_init' );

function pageAdmindropshix(){
	$plugin = new Dropshipping_Xox();
	$url = $plugin->getProfitUrlSetup();
	$myaccount = $plugin->myAccount();

    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }

    if ( isset( $_GET['settings-updated'] )) {
        add_settings_error( 'dropshix_messages', 'dropshix_message', __( 'Settings Saved', 'dropshix' ), 'updated' );
    }

    settings_errors( 'dropshix_messages' );
    ?>
    <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
        <div class="row xox-row">
			<div class="col-sm-12 col-md-6 xox-dropshix">
				<?php 
				$val = get_option('dropshix_opt');
				if( isset($val) && ($val['dropshix_API_public'] != '' || $val['dropshix_API_private'] != ''))
					$chr = $plugin->getKeys();
				if($val['dropshix_API_public'] == '' || $val['dropshix_API_private'] == '' || $val['x_tool_source'] == ''): ?>
					<?php if($isFree): ?>
			    		<div class="alert alert-warning text-left">
			    			<h3>You're not registered yet, or you have not yet input your API key.</h3>
			    			<h4>Register to get your API key by clicking the button below</h4>
			    			<a href="https://dropshix.xolluteon.com/register" class="btn btn-primary btn-larger" target="_blank">REGISTER NOW</a>
			    		</div>
			    	<?php else: ?>
			    		<div class="alert alert-warning text-left">
			    			<h3>You're not registered yet, or you have not yet input your API key.</h3>
			    			<h4>Please logged in to your dashboard and retrieve the API key</h4>
			    			<a href="https://dropshix.xolluteon.com/register" class="btn btn-primary btn-larger" target="_blank">REGISTER NOW</a>
			    		</div>
			    	<?php endif; ?>
				<?php else: ?>
			        <div class="text-left">
						<h3>Thank you for using the plugin.</h3>
						<div id="upgrade"></div>
					</div>
			    <?php endif; ?>
			    <form action="options.php" method="post">
			        <?php
			        settings_fields( 'dropshix' );
			        do_settings_sections( 'dropshix' );
			        submit_button( 'Save Settings' );
			        ?>
			    </form>
			</div>
	        
	        <div class="col-sm-12 col-md-6 xox-acc">
	        	<?php if($myaccount->isfree){ ?>
			    <center>
			        <h1>Upgrade your project package for more feature</h1>
			        <br>
			        <div class="form-group xox-conf">
			        	<a href="//dropshix.xolluteon.com/project/<?=$myaccount->project_id?>/detail" class=" btn btn-default" target="_BLANK"><i class="fa fa-unlock"></i> Upgrade</a>
			        </div>
			    </center>
			    <?php } ?>
			    <h3>Pre Requisite checking:</h3>
			    <ul style="margin-top: 25px;">
			    	<?php if(isset($chr)): ?>
			    		<?php if(!$myaccount->isfree) { ?>
						<li style="margin-bottom: 50px;">
							<p><strong>DROPSHIX Chrome Extension Key</strong><br><span style="font-size: 10px; font-style: italic;">Input this key to your Dropshix Chrome extension to connect betweeen system.</span></p>
							<p style="margin-top: 15px;"><span class="alert alert-success" style="font-size: 12px; width:100%;"><?php echo $chr; ?></span></p>
						</li>
						<?php }else{?>
						<li style="margin-bottom: 50px;">
							<p><strong>DROPSHIX Chrome Extension Key</strong><br><span style="font-size: 10px; font-style: italic;">Input this key to your Dropshix Chrome extension to connect betweeen system.</span></p>
							<p style="margin-top: 15px;"><span class="alert alert-warning" style="font-size: 12px; width:100%;"><?php echo $chr; ?></span></p>
							<p><span style="font-size: 10px; font-style: italic;">You are in free package, importing items directly from source store will not work.</span></p>
						</li>
						<?php } ?>
				    <?php endif; ?>
			    	<li>
			    		<p><strong>CURL module status.</strong><br><span style="font-size: 10px; font-style: italic;">CURL is a method to connect data between Dropshix server and your woocommerce store.</span></p>
			    		<p style="margin-top: 15px;">
							<?php
							if(_is_curl_installed()):
								?>
								<span class="alert alert-success" style="font-size: 12px; width:100%;">You have CURL installed, connection to DROPSHIX server is running and synced.</span>
								<?php
							else:
								?>
								<span class="alert alert-error" style="font-size: 12px; width:100%;">You don't have CURL installed, connection to DROPSHIX server cannot made.<br>
								Please contact your hosting service!</span>
								<?php
							endif;
							?>
						</p>
				    </li>
				    <li>
				    	<div class="col-xs-12" style="margin:30px 0;text-align:center;">
				    		<a data-fancybox data-type="iframe" data-src="<?= $url ?>" data-height="" href="javascript:;" class="fancybox-xox btn btn-warning btn-lg btn-block"><i class="glyphicon glyphicon-cog"></i> Dropshix Configuration</a>
				    	</div>
				    </li>
			    </ul>
	        </div>
		
        </div>
    </div>
    <?php
}

function _is_curl_installed()
{
    if  (in_array  ('curl', get_loaded_extensions())) {
        return true;
    }
    else {
        return false;
    }
}

function _check_disk_size()
{
	$ds = disk_total_space("/home");
	$exp = $ds/(1024);
}

function searchProductdropshix(){
	$plugin = new Dropshipping_Xox();
	$plugin->searchPage();
}

// new Queued product page
function queuedPagedropshix()
{
	global $woocommerce;
	$currency_code = get_woocommerce_currency();
	$currency_symbol = get_woocommerce_currency_symbol();

	$plugin = new Dropshipping_Xox();
	$queues = $plugin->listQueued();

	$stat = $queues->result->product;
	$diff = $stat->limit - $stat->activelistings;
	if($diff <= 10 && $diff > 5){
		$alert = 'alert alert-warning';
	}elseif($diff <= 5){
		$alert = 'alert alert-danger';
	}else{
		$alert = 'alert alert-success';
	}
	?>
	<div class="container-fluid">
		<div class="row">
			<div class="col-xs-12" id="xoxStat">
				<h4>Queued Products <span class="pull-right"><?php echo $queues->status; ?> - <?php echo $queues->errorCode; ?></span></h4>
				<p class="<?php echo $alert; ?>">
					<span style="margin-right: 10px;">Package: <strong><?php echo $stat->type; ?></strong></span>
					<span style="margin-right: 10px;">Active items limit: <?php echo $stat->limit; ?></span>
					Current active items: <span id="itemActive"><?php echo $stat->activelistings; ?></span>
					<span class="hide"><?php echo $queues->url; ?></span>
					<input type="hidden" id="dshix_url" name="dshix_url" value="<?php echo plugins_url( 'admin',  __FILE__ ); ?>">
					<input type="hidden" name="dlevel" id="dlevel" value="<?php echo $stat->limit; ?>">
				</p>
			</div>
		</div>
	</div>
	<?php
	$pendings = $queues->result->listings;
	?>
	<div class="container-fluid">
		<div class="row">
			<div class="col-xs-12" id="tablePendingHolder">
				<table id="tblPending" class="table table-striped table-hovered table-bordered">
					<thead>
						<tr>
							<th>Product ID</th>
							<th>Title</th>
							<th>Image</th>
							<th>Source</th>
							<th>Original Price</th>
							<th>Sale Price</th>
							<th>Volume</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
						if(is_array($pendings) && count($pendings) > 0):
							foreach ($pendings as $key => $val) {
								if(isset($val->result)){
									$item = $val->result;
								}else{
									$item = $val;
								}
								if($item->source == 'ae'):
								?>
								<tr id="q<?php echo $item->productId; ?>">
									<td><a target="_blank" href="<?php echo $item->productUrl; ?>"><?php echo $item->productId; ?></a></td>
									<td style="width: 180px;"><?php echo $item->productTitle; ?></td>
									<td class="text-center"><img src="<?php echo $item->imageUrl; ?>_640x640.jpg" style="width: 100px; height: 100px;"></td>
									<td><a target="_blank" href="<?php echo isset($item->storeUrl) ? $item->storeUrl : '#'; ?>"><?php echo isset($item->storeName) ? $item->storeName : 'No Store name'; ?></a><br>[AliExpress]</td>
									<td><?php echo $currency_symbol . floatval(str_replace('US $', '', $item->originalPrice)) . ' ' . $currency_code; ?></td>
									<td><?php echo $currency_symbol . floatval(str_replace('US $', '', $item->salePrice)) . ' ' . $currency_code; ?></td>
									<td><?php echo $item->volume; ?></td>
									<td id="action-<?php echo $item->productId; ?>" class="text-center">
										<p><a href="javascript:;" id="xox-importthis-<?php echo $item->productId ?>" data-id="<?php echo $item->productId ?>" data-source="ae" data-title="<?php echo esc_html($item->productTitle) ?>" class=" xox-importthis btn btn-primary xox-import">Import This Item</a></p>
										<p><a href="javascript:;" data-id="<?php echo $item->productId ?>" data-source="ae" class="removequeue xox-deletethis-<?php echo $item->productId ?> btn btn-danger xox-remove">Remove This Item</a></p>
										<textarea id="desc-<?php echo $item->productId; ?>" class="hide" style="display: none;"><?php echo $item->mainDescription; ?></textarea>
									</td>
								</tr>
								<?php elseif($item->source == 'amus'): ?>
								<tr id="q<?php echo $item->ASIN; ?>">
									<td><a target="_blank" href="<?php echo $item->DetailPageURL; ?>"><?php echo $item->ASIN; ?></a></td>
									<td style="width: 180px;"><?php echo $item->ItemAttributes->Title; ?></td>
									<td class="text-center"><img src="<?php echo isset($item->MediumImage->URL) ? $item->MediumImage->URL : 'http://via.placeholder.com/160x160'; ?>" style="width: 100px; height: 100px;"></td>
									<td><a target="_blank" href="<?php echo isset($item->storeUrl) ? $item->storeUrl : '#'; ?>"><?php echo isset($item->storeName) ? $item->storeName : 'No Store name'; ?></a><br>[Amazon US]</td>
									<td><?php echo $currency_symbol . floatval(str_replace('$', '', $item->ItemAttributes->ListPrice->FormattedPrice)) . ' ' . $currency_code; ?></td>
									<td><?php echo $currency_symbol . floatval(str_replace('$', '', $item->ItemAttributes->ListPrice->FormattedPrice)) . ' ' . $currency_code; ?></td>
									<td><?php echo (isset($product->ItemAttributes->NumberOfItems) ? $product->ItemAttributes->NumberOfItems : 1); ?></td>
									<td id="action-<?php echo $item->ASIN; ?>" class="text-center">
										<p><a href="javascript:;" id="xox-importthis-<?php echo $item->ASIN ?>" data-id="<?php echo $item->ASIN ?>" data-source="amus" data-title="<?php echo esc_html($item->ItemAttributes->Title) ?>" class=" xox-importthis btn btn-primary xox-import">Import This Item</a></p>
										<p><a href="javascript:;" data-id="<?php echo $item->ASIN ?>" data-source="amus" class="removequeue xox-deletethis-<?php echo $item->ASIN ?> btn btn-danger xox-remove">Remove This Item</a></p>
										<?php
										// build description for Amazon items here.
										$am_desc = "";
										$am_desc .= "<h2>".$item->ItemAttributes->Title."</h2>";
										if(isset($item->EditorialReviews)){
											$am_desc .= "<h4>".$item->EditorialReviews->EditorialReview->Source."</h4>";
											$am_desc .= "<p>".$item->EditorialReviews->EditorialReview->Content."</p>";
										}
										$am_desc .= "<ul>";
										if(isset($item->ItemAttributes->Binding))
											$am_desc .= "<li>Binding: ".$item->ItemAttributes->Binding."</li>";
										if(isset($item->ItemAttributes->Brand))
											$am_desc .= "<li>Brand: ".$item->ItemAttributes->Brand."</li>";
										if(isset($item->ItemAttributes->Color))
											$am_desc .= "<li>Color: ".$item->ItemAttributes->Color."</li>";
										if(isset($item->ItemAttributes->ProductGroup))
											$am_desc .= "<li>ProductGroup: ".$item->ItemAttributes->ProductGroup."</li>";
										if(isset($item->ItemAttributes->ProductTypeName))
											$am_desc .= "<li>ProductTypeName: ".$item->ItemAttributes->ProductTypeName."</li>";
										if(isset($item->ItemAttributes->Size))
											$am_desc .= "<li>Size: ".$item->ItemAttributes->Size."</li>";
										if(isset($item->ItemAttributes->Department))
											$am_desc .= "<li>Department: ".$item->ItemAttributes->Department."</li>";
										$am_desc .= "</ul>";
										if(isset($item->ItemAttributes->Feature)){
											$am_desc .= "<h5>Features:</h5>";
											if(is_array($item->ItemAttributes->Feature)){
												foreach($item->ItemAttributes->Feature as $feature){
													$am_desc .= "<p>".$feature."</p>";
												}
											}else{
												$am_desc .= "<p>".$item->ItemAttributes->Feature."</p>";
											}
										}
										
										?>
										<textarea id="desc-<?php echo $item->ASIN; ?>" class="hide" style="display: none;"><?php echo $am_desc; ?></textarea>
									</td>
								</tr>
								<?php
								endif;
							}
						endif;
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<?php
}

// new Active product page
function activePagedropshix()
{
	global $woocommerce;
	$currency_code = get_woocommerce_currency();
	$currency_symbol = get_woocommerce_currency_symbol();
	$plugin = new Dropshipping_Xox();
	$queues = $plugin->listQueued('xox-active');

	$stat = $queues->result->product;
	$diff = $stat->limit - $stat->activelistings;
	if($diff <= 10 && $diff > 5){
		$alert = 'alert alert-warning';
	}elseif($diff <= 5){
		$alert = 'alert alert-danger';
	}else{
		$alert = 'alert alert-success';
	}
	?>
	<div class="container-fluid">
		<div class="row">
			<div class="col-xs-12" id="xoxStat">
				<h4>Active Products <span class="pull-right"><?php echo $queues->status; ?> - <?php echo $queues->errorCode; ?></span></h4>
				<p class="<?php echo $alert; ?>">
					<span style="margin-right: 10px;">Package: <strong><?php echo $stat->type; ?></strong></span>
					<span style="margin-right: 10px;">Active items limit: <?php echo $stat->limit; ?></span>
					<span id="itemActive">Current active items: <?php echo $stat->activelistings; ?></span>
					<span class="hide"><?php echo $queues->url; ?></span>
				</p>
			</div>
		</div>
	</div>
	<?php $actives = $queues->result->listings; ?>
	<div class="container-fluid">
		<div class="row">
			<div class="col-xs-12" id="tablePendingHolder">
				<table id="tblActive" class="table table-striped table-hovered table-bordered">
					<thead>
						<tr>
							<th>Product ID</th>
							<th>Title</th>
							<th>Image</th>
							<th>Source</th>
							<th>Original Price</th>
							<th>Your Price</th>
							<th>Your Sale Price</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
						if(is_array($actives) && count($actives) > 0):
							foreach ($actives as $key => $val) {
								$reporturl = $plugin->getReportUrl();
								if(isset($val->result)){
									$item = $val->result;
								}else{
									$item = $val;
								}
								if($item->source == 'ae'):
								?>
								<tr id="a<?php echo $item->productId; ?>">
									<td><a target="_blank" href="<?php echo $item->productUrl; ?>"><?php echo $item->productId; ?></a></td>
									<td style="width: 180px;"><?php echo $item->productTitle; ?></td>
									<td class="text-center"><img src="<?php echo $item->imageUrl; ?>_640x640.jpg" style="width: 100px; height: 100px;"></td>
									<td><a target="_blank" href="<?php echo isset($item->storeUrl) ? $item->storeUrl : '#'; ?>"><?php echo isset($item->storeName) ? $item->storeName : 'No Store name'; ?></a><br>[AliExpress]</td>
									<td><?php echo $currency_symbol . floatval(str_replace('US $', '', $item->originalPrice)) . ' ' . $currency_code; ?></td>
									<td><?php echo $currency_symbol . floatval($item->wooPrice) . ' ' . $currency_code; ?></td>
									<td><?php echo $currency_symbol . floatval($item->wooSalePrice) . ' ' . $currency_code; ?></td>
									<td id="action-<?php echo $item->productId; ?>" class="text-center">
										<p><a data-fancybox data-type="iframe" data-src="<?php echo $reporturl; ?>/<?php echo $item->productId; ?>/<?php echo urlencode($item->productTitle); ?>" href="javascript:;" class="report-fancybox-xox btn btn-primary xox-report">Report</a></p>
										<p><a href="javascript:;" data-id="<?= $item->productId ?>" data-source="ae" class="xox-deletethisfa xox-deletethisfa-<?= $item->productId ?> btn btn-danger xox-remove2">Remove</a></p>
									</td>
								</tr>
								<?php elseif($item->source == 'amus'): ?>
								<tr id="a<?php echo $item->ASIN; ?>">
									<td><a target="_blank" href="<?php echo $item->DetailPageURL; ?>"><?php echo $item->ASIN; ?></a></td>
									<td style="width: 180px;"><?php echo $item->ItemAttributes->Title; ?></td>
									<td class="text-center"><img src="<?php echo isset($item->MediumImage->URL) ? $item->MediumImage->URL : 'http://via.placeholder.com/160x160'; ?>" style="width: 100px; height: 100px;"></td>
									<td><a target="_blank" href="<?php echo isset($item->storeUrl) ? $item->storeUrl : '#'; ?>"><?php echo isset($item->storeName) ? $item->storeName : 'No Store name'; ?></a><br>[Amazon US]</td>
									<td><?php echo $currency_symbol . floatval(str_replace('$', '', $item->ItemAttributes->ListPrice->FormattedPrice)) . ' ' . $currency_code; ?></td>
									<td><?php echo $currency_symbol . floatval($item->wooPrice) . ' ' . $currency_code; ?></td>
									<td><?php echo $currency_symbol . floatval($item->wooSalePrice) . ' ' . $currency_code; ?></td>
									<td id="action-<?php echo $item->ASIN; ?>" class="text-center">
										<p><a data-fancybox data-type="iframe" data-src="<?php echo $reporturl; ?>/<?php echo $item->ASIN; ?>/<?php echo urlencode($item->ItemAttributes->Title); ?>" href="javascript:;" class="report-fancybox-xox btn btn-primary xox-report">Report</a></p>
										<p><a href="javascript:;" data-id="<?= $item->ASIN ?>" data-source="amus" class="xox-deletethisfa xox-deletethisfa-<?= $item->productId ?> btn btn-danger xox-remove2">Remove</a></p>
									</td>
								</tr>
								<?php
								endif;
							}
						endif;
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<?php
}

// new Inactive product page
function inActivePagedropshix()
{
	global $woocommerce;
	$currency_code = get_woocommerce_currency();
	$currency_symbol = get_woocommerce_currency_symbol();
	$plugin = new Dropshipping_Xox();
	$queues = $plugin->listQueued('xox-inactive');

	$stat = $queues->result->product;
	$diff = $stat->limit - $stat->activelistings;
	if($diff <= 10 && $diff > 5){
		$alert = 'alert alert-warning';
	}elseif($diff <= 5){
		$alert = 'alert alert-danger';
	}else{
		$alert = 'alert alert-success';
	}
	?>
	<div class="container-fluid">
		<div class="row">
			<div class="col-xs-12" id="xoxStat">
				<h4>Inactive Products <span class="pull-right"><?php echo $queues->status; ?> - <?php echo $queues->errorCode; ?></span></h4>
				<p class="<?php echo $alert; ?>">
					<span style="margin-right: 10px;">Package: <strong><?php echo $stat->type; ?></strong></span>
					<span style="margin-right: 10px;">Active items limit: <?php echo $stat->limit; ?></span>
					<span id="itemActive">Current active items: <?php echo $stat->activelistings; ?></span>
					<span class="hide"><?php echo $queues->url; ?></span>
				</p>
			</div>
		</div>
	</div>
	<?php $listings = $queues->result->listings; ?>
	<div class="container-fluid">
		<div class="row">
			<div class="col-xs-12" id="tablePendingHolder">
				<table id="tblInActive" class="table table-striped table-hovered table-bordered">
					<thead>
						<tr>
							<th>Product ID</th>
							<th>Source</th>
							<th>Last Recorded Price</th>
							<th>Last Recorded Profit</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
						if(is_array($listings) && count($listings) > 0):
							foreach ($listings as $key => $val) {
								$reporturl = $plugin->getReportUrl();
								if(isset($val->result)){
									$item = $val->result;
								}else{
									$item = $val;
								}
								switch ($item->source) {
									case 'ae':
										$source = '[AliExpress]';
										break;

									case 'amus':
										$source = '[Amazon US]';
										break;
									
									default:
										$source = '[AliExpress]';
										break;
								}
								?>
								<tr id="ic-<?php echo $item->product_id; ?>">
									<td><a target="_blank" href="javascript:;"><?php echo $item->product_id; ?></a></td>
									<td><?php echo $source; ?></td>
									<td><?php echo $currency_symbol . floatval(str_replace('US $', '', $item->itemdetails->originalPrice)) . ' ' . $currency_code; ?></td>
									<td><?php echo $currency_symbol . floatval($item->itemdetails->profit) . ' ' . $currency_code; ?></td>
									<td id="action-<?php echo $item->productId; ?>" class="text-center">
										<p>
											<a href="javascript:;" data-id="<?php echo $item->product_id; ?>" data-source="<?php echo $item->source; ?>" class="xox-archivethisfa xox-archivethisfa-<?php echo $item->product_id; ?> btn btn-default xox-archive">Archive</a>
										</p>
									</td>
								</tr>
								<?php
							}
						endif;
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<?php
}

add_action( 'wp_ajax_AutoScanAttr', 'AutoScanAttr' );
add_action( 'wp_ajax_nopriv_AutoScanAttr', 'AutoScanAttr' );

function AutoScanAttr()
{
	if (null !== filter_input_array(INPUT_POST)) {
		$inputs = filter_input_array(INPUT_POST);
		$wooid = sanitize_text_field( strval( $inputs['wooid'] ));
		$plugin = new Dropshipping_Xox();
		$curl = $plugin->getScanAttrURL( $wooid );
		$return = json_encode($curl['result']);
	}
	echo $return;
	wp_die();
}

function xoxImportItem() {
	//global $wpdb; // this is how you get access to the database
	if( isset( $_POST['title'] ) && isset( $_POST['description'] ) && isset( $_POST['id'] ) ) {
		$data['title'] = sanitize_text_field( strval( $_POST['title'] ));
		$data['description'] = wp_kses_post( $_POST['description'] );
		$data['source'] = sanitize_text_field( strval( $_POST['source'] ));
		$id = sanitize_text_field( strval( $_POST['id'] ));
		$plugin = new Dropshipping_Xox();
		$return = $plugin->importProduct( $id, $data );
		echo $return;
	}else{
		$data['status'] = false;
		$data['msg'] = 'Error: Missing important data!';
		return json_encode( $data );
	}
	wp_die();
}

function xoxDeleteItem() {
	//global $wpdb; // this is how you get access to the database
	$plugin = new Dropshipping_Xox();
	$id = strval( $_POST['id'] );
	$source = strval( $_POST['source'] );
	$return = $plugin->deleteProduct( $id, $source );
	echo $return;
	wp_die(); 
}

function xoxArchiveItem() {
	//global $wpdb; // this is how you get access to the database
	$plugin = new Dropshipping_Xox();
	$id = intval( $_POST['id'] );
	$source = strval( $_POST['source'] );
	$return = $plugin->archiveProduct( $id, $source );
	echo $return;
	wp_die(); 
}

add_action( 'wp_ajax_Xox_Import_Item', 'xoxImportItem' );
add_action( 'wp_ajax_nopriv_Xox_Import_Item', 'xoxImportItem' );
add_action( 'wp_ajax_Xox_Load_Ajax_Item', 'xoxLoadItem' );
add_action( 'wp_ajax_nopriv_Xox_Load_Ajax_Item', 'xoxLoadItem' );
add_action( 'wp_ajax_Xox_Delete_Item', 'xoxDeleteItem' );
add_action( 'wp_ajax_nopriv_Xox_Delete_Item', 'xoxDeleteItem' );
add_action( 'wp_ajax_Xox_Archive_Item', 'xoxArchiveItem' );
add_action( 'wp_ajax_nopriv_Xox_Archive_Item', 'xoxArchiveItem' );

add_action( 'wp_ajax_Xox_SendAnalytics', 'xoxSendAnalytics' );
add_action( 'wp_ajax_nopriv_Xox_SendAnalytics', 'xoxSendAnalytics' );

add_action( 'woocommerce_after_single_product_summary', 'xoxAnalytics');

function xoxAnalytics($argument){
	global $product;
	?>
		<script type="text/javascript" >
		jQuery(document).ready(function($) {
			//load ajax
			xoxSendAnalytics('<?= $product->id ?>');
			function xoxSendAnalytics( id ){
				ajaxurl = "<?= admin_url('admin-ajax.php')?>";
				$.ajax({
					url : ajaxurl,
					type : 'post',
					data : {
						action: "Xox_SendAnalytics",
						typedata: 'watch',
						item: id,
					}
				})
				.fail(function(r,status,jqXHR) {
					console.log('error send data');
				})
				.done(function(r,status,jqXHR) {
					console.log('200, send Analytics');
				});
			}
		});

	</script>
	<?php
}

function xoxSendAnalytics(){
	$plugin = new Dropshipping_Xox();
	$typedata = sanitize_text_field( strval( $_POST['typedata'] ));
	$item = sanitize_text_field( strval( $_POST['item'] ));
    $plugin->sendAnalytics( $typedata, $item );
	wp_die();
}

function headerImportPagedropshix(){
	$allowed = ['xox-pending','xox-active','xox-inactive'];
	$active = 'xox-inactive';
	if(isset($_GET['list-xox'])){
		if( in_array( $_GET['list-xox'], $allowed) ){
			$active = sanitize_text_field( strval( $_GET['list-xox'] ));
		}
	}
	if(isset($_POST['bulkaction'])){
		$bulkaction = sanitize_text_field( strval( $_POST['bulkaction'] ));
		if( in_array( 'xox-'.$bulkaction, $allowed) ){
			$active = 'xox-'.$bulkaction;
		}
	}
	?>
	<div class="custom-wrap col-md-12 xox-wrap-list">
		<h2 class="nav-tab-wrapper">
			<a class="xox-tab <?= ($active == 'xox-inactive' ) ? 'active' : '' ?>" href="<?= admin_url( 'admin.php?page=dropshix-import-page&list-xox=xox-inactive') ?> " data-id="xox-inactive">Inactive Listings</a>
		</h2>
	</div>
	<?php
}

function importPagedropshix(){
	$allowed = ['xox-pending','xox-active','xox-inactive'];
	$active = 'xox-inactive';
	if(isset($_GET['list-xox'])){
		if( in_array( $_GET['list-xox'], $allowed) ){
			$active = sanitize_text_field( strval( $_GET['list-xox'] ));
		}
	}

	if(isset($_POST['bulkaction'])){
		$bulkaction = sanitize_text_field( strval( $_POST['bulkaction'] ));
		if( in_array( 'xox-'.$bulkaction, $allowed) ){
			$active = 'xox-'.$bulkaction;
	    	$action = sanitize_text_field( strval( $_POST['action'] ));
	    	if( !empty($action) && $action != NULL){
	    		$items = (isset($_POST['productId']) && !empty($_POST['productId']) && is_array($_POST['productId'])) ? $_POST['productId'] : [];
	    		if($action == 'delete'){
	    			foreach ($items as $key => $item) {
						$plugin = new Dropshipping_Xox();
						$plugin->deleteProduct($item);
	    			}
	    		}else if($action == 'import'){
	    			foreach ($items as $key => $item) {
						$data['title'] = sanitize_text_field( strval( $_POST['productTitle'][$item] ));
						$data['description'] = wp_kses_post( $_POST['productDesc'][$item] );

						$plugin = new Dropshipping_Xox();
						$plugin->importProduct($item, $data);
	    			}
	    		}else if($action == 'archive'){
	    			foreach ($items as $key => $item) {
						$plugin = new Dropshipping_Xox();
						$plugin->archiveProduct($item);
	    			}
	    		}
	    	}
		
		}
	}

	$plugin = new Dropshipping_Xox();
    $listings = $plugin->listQueued($active);
    ?>
    <div class="container">
    	<div class="row">
    
    	<div class="col-xs-12">
	    	<h2>Recorded Listings</h2>
    	</div>
    	<?php
    	$pendings = $listings->result->pending;
    	$actives = $listings->result->active;
    	$inactives = $listings->result->inactive;

    	//distribute pending listings
    	?>
    	<?php headerImportPagedropshix(); ?>
    		<div class="xox-content-wrapper <?= ($active == 'xox-inactive' ) ? 'active' : '' ?>" id="xox-inactive">
				<div class="col-xs-12 ds-column dropshix-pending">
		    		<h4>Inactive Listings</h4>
		    		<div class="xox-inactive-wrap"></div>
	    		</div>
			</div>
    		<div class="col-xs-12 footer">
    			<p>Powered by <strong><a href="//dropshix.com">DROPSHIX</a></strong> - WoOCommerce + Dropshipping Made Simple.</p>
    		</div>
    	</div>
    </div>
	<?php 
		if($active == NULL ){
			$active = 'xox-inactive';
			if(isset($_GET['list-xox'])){
				$active = sanitize_text_field( strval( $_GET['list-xox'] ));
			}

		}
		$load100 = plugins_url( 'admin/css/100.gif',  __FILE__ );
	 ?>
	<script type="text/javascript" >
		jQuery(document).ready(function($) {
			//load ajax
			loadajax('<?= $active ?>');
			function loadajax( type ){
				var loader = '<?php echo $load100; ?>';
				loading = '<div class="xox-loading-ajax"><img src="'+loader+'"></div>';
				$('.'+type+'-wrap').html(loading);
				$.ajax({
					url : ajaxurl,
					type : 'post',
					data : {
						action: "Xox_Load_Ajax_Item",
						typedata: type,
					}
				})
				.fail(function(r,status,jqXHR) {
					console.log(status);
					msgerror = 'Failed Load Data. ';
					if (typeof r.msg !== 'undefined') {
						msgerror = r.msg;
					}
					$('.'+type+'-wrap').html(msgerror);
				})
				.done(function(r,status,jqXHR) {
					console.log(status);
					$('.'+type+'-wrap').html(r);
				});
			}

	        $('.xox-tab').click(function(event){
	            event.preventDefault();
	            var dataId = $(this).attr('data-id');
	            $('.xox-tab').removeClass('active');
	            $(this).addClass('active');
	            $('.xox-content-wrapper').removeClass('active');
	            $('#'+dataId).addClass('active');
	            loadajax(dataId);
	        });
		});
	</script>

    <?php
}

add_action( 'wp_ajax_dropshixSync', 'dropshixSync' );
add_action( 'wp_ajax_nopriv_dropshixSync', 'dropshixSync' );

function dropshixSync()
{
	if (null !== filter_input_array(INPUT_POST)) {
		$inputs = filter_input_array(INPUT_POST);
		if($inputs['process'] == 'update'){
			$post_id = sanitize_text_field( intval( $inputs['id'] ));
			$price = sanitize_text_field( floatval( str_replace( 'US $', '', $inputs['price'] )));
			update_post_meta($post_id, '_regular_price', $price);
			update_post_meta($post_id, '_price', $price);

			if(isset($inputs['salePrice'])){
				$salePrice = sanitize_text_field( floatval( str_replace( 'US $', '', $inputs['salePrice'] )));
				update_post_meta($post_id, '_sale_price', $salePrice);
			}
			
			if(isset($inputs['stock'])){
				$stock = sanitize_text_field( intval( $inputs['stock'] ));
				update_post_meta($post_id, '_stock', $stock );
			} 
		}elseif($inputs['process'] == 'remove'){
			$id = intval( $inputs['id'] );
			wp_delete_post( $id);
		}elseif($inputs['process'] == 'draft'){
			$id = intval( $inputs['id'] );
			$myproduct = array(
				'ID' => $id,
				'post_status' => 'draft'
			);
			wp_update_post( $myproduct);
		}
		
	}

	echo 1;
	wp_die();
}

add_action( 'woocommerce_payment_complete', 'xoxAnalyticsOrder' );
add_action( 'woocommerce_order_status_processing', 'xoxAnalyticsOrder', 10, 1 );

function xoxAnalyticsOrder( $order_id ){

    $order = wc_get_order( $order_id );
    $items = $order->get_items();
    $data = [];
    $product = [];
    foreach ($items as $item) {
    	$product['orderId'] = $order_id;
    	$product['productId'] = $item['product_id'];
    	$product['qty'] = $item['qty'];
    	$product['subtotal'] = $item['line_subtotal'];
    	$product['total'] = $item['line_total'];
		
		$details = new WC_Product($item['product_id']);

		// Get SKU
		$sku = $details->get_sku();
    	$product['sku'] = $sku;

    	$data[] = $product;
    }
    $plugin = new Dropshipping_Xox();
    //$plugin->debug($data);
    $plugin->orders($data);
}

// Order AliExpress buttons
add_action( 'add_meta_boxes', 'dx_add_meta_boxes' );
if ( ! function_exists( 'dx_add_meta_boxes' ) )
{
    function dx_add_meta_boxes()
    {
        add_meta_box( 'dx_order_fields', __('Dropshix Order Products','woocommerce'), 'dx_add_other_fields_for_packaging', 'shop_order', 'side', 'low', 'core' );
    }
}

//
//adding Meta field in the meta container admin shop_order pages
//
if ( ! function_exists( 'dx_add_other_fields_for_packaging' ) )
{
    function dx_add_other_fields_for_packaging()
    {
	    global $post;       

        $order = new WC_Order($post->ID);

        $data = $order->get_data();
        
        if($data['status'] == 'completed' || $data['status'] == 'processing'){
        	$items = $order->get_items();
        	$worders = array();
        	foreach($items as $order_item_id => $item){
        		$worders[$item['product_id']]['order_item_id'] = $order_item_id;
        		$worders[$item['product_id']]['variation_id'] = $item['variation_id'];
        	}

        	$plugin = new Dropshipping_Xox();
        	$curl = $plugin->getOrderDetails($post->ID);
        	$dorders = $curl['result'];
        	if(!empty($dorders) && is_array($dorders)){
        		foreach($dorders as $do){
        			$worders[$do->importlists->wid]['sku'] = $do->sku;
        			$worders[$do->importlists->wid]['quantity'] = $do->q;
        		}
        		?>
        		<div class="orders-list" style="text-align: left;">
        		<?php
        		foreach ($worders as $k => $w) {
        			?>
        			<p><input type="hidden" id="<?php echo $k; ?>" name="<?php echo $k; ?>" data-variation="<?php echo $w['variation_id']; ?>" data-sku="<?php echo $w['sku']; ?>" data-item-id="<?php echo $w['order_item_id']; ?>" value="<?php echo $w['quantity']; ?>" class="dxorderitems"></p>
        			<?php
        		}
        		?>
	        	</div>
        		<?php
        	}

        	$shipping = $order->get_shipping_first_name() != '' ? $data['shipping'] : $data['billing'];
        	?>
        	<div style="text-align: center;">
        		<div class="shipping-details" style="display: none; text-align: left;" data-show="hide">
        			<p><label>Customer Name: </label><br><input type="text" name="ds-customerName" id="ds-customerName" value="<?php echo $shipping['first_name'].' '.$shipping['last_name']; ?>"></p>
        			<p><label>Country: </label><br><input type="text" name="ds-country" id="ds-country" value="<?php echo $shipping['country']; ?>"></p>
        			<p><label>Address 1: </label><br><input type="text" name="ds-address_1" id="ds-address_1" value="<?php echo $shipping['address_1']; ?>"></p>
        			<p><label>Address 2: </label><br><input type="text" name="ds-address_2" id="ds-address_2" value="<?php echo $shipping['address_2']; ?>"></p>
        			<p><label>State: </label><br><input type="text" name="ds-state" id="ds-state" value="<?php echo $shipping['state']; ?>"></p>
        			<p><label>City: </label><br><input type="text" name="ds-city" id="ds-city" value="<?php echo $shipping['city']; ?>"></p>
        			<p><label>Postal Code: </label><br><input type="text" name="ds-postcode" id="ds-postcode" value="<?php echo $shipping['postcode']; ?>"></p>
        			<p><label>Phone: </label><br><input type="text" name="ds-phone" id="ds-phone" value="<?php echo $shipping['phone']; ?>"></p>
        		</div>
	        	<p style="display: none;"><a href="javascript:;" id="checkAddress">check shipping details</a></p>
	        	<p><a href="https://shoppingcart.aliexpress.com/shopcart/shopcartDetail.htm" id="finish_order" class="button button-primary" target="_blank">Finish Order!</a></p>
        	</div>
        <?php
        }else{
        	echo '<h4>Please make sure this order payment is completed and the order status is "Processing" before proceeding.</h4>';
    	}
    }
}

// Populate price if product is variable product
add_action( 'added_post_meta', 'dshix_populate_variations_price', 10, 4 );
add_action( 'updated_post_meta', 'dshix_populate_variations_price', 10, 4 );

function dshix_populate_variations_price( $meta_id, $post_id, $meta_key, $meta_value )
{
	$save_btn = true;

	if (null !== filter_input_array(INPUT_POST)) {
		$inputs = filter_input_array(INPUT_POST);
		// var_dump($inputs); exit;
		if((isset($inputs['action']) && $inputs['action'] == 'dshixDisableSale')){
			$save_btn = false;
		}
	}

	if (get_post_type($post_id) == 'product') {
		$_no_sale_price = get_post_meta($post_id, '_no_sale_price');
		// var_dump($_no_sale_price); exit;

		if(!isset($_no_sale_price[0]) || $_no_sale_price[0] == ''){ 
			// listing has just been created.
			$product = wc_get_product( $post_id );
			$_price = get_post_meta($post_id, '_price');
			$_regular_price = get_post_meta($post_id, '_regular_price');
			$_sale_price = get_post_meta($post_id, '_sale_price');

			if( $product->is_type('variable') ){
				$variations = $product->get_available_variations();
				foreach($variations as $var){
					$var_id = $var['variation_id'];
					$var_price = get_post_meta($var_id, '_price');
					$var_regular_price = get_post_meta($var_id, '_regular_price');
					$var_sale_price = get_post_meta($var_id, '_sale_price');
					if( $var_price[0] == '')
						update_post_meta($var_id, '_price', $_price[0]);
					if( $var_regular_price[0] == '')
						update_post_meta($var_id, '_regular_price', $_regular_price[0]);
					if( $var_sale_price[0] == '' && ($_sale_price[0] != '' || $_sale_price[0] != 0))
						update_post_meta($var_id, '_sale_price', $_sale_price[0]);
				}
			}
		}else{ 
			// the disable sale price is initiated.
			// the world is new now.
			$is_sale = $_no_sale_price[0] == 'no' ? false : true;

			if(!$is_sale && $save_btn){
				// we need to preserve the current pricing structure.
				$_price = get_post_meta($post_id, '_price');
				$_regular_price = get_post_meta($post_id, '_regular_price');
				$_sale_price = get_post_meta($post_id, '_sale_price');

				if(isset($_price[0]) && $_price[0] !== '')
					update_post_meta($post_id, '_init_price', $_price[0]);
				if(isset($_regular_price[0]) && $_regular_price[0] !== '')
					update_post_meta($post_id, '_init_regular_price', $_regular_price[0]);
				if(isset($_sale_price[0]) && $_sale_price[0] !== '')
					update_post_meta($post_id, '_init_sale_price', $_sale_price[0]);

				// now that we save everything let's start destroying the pricing.
				try {
					delete_post_meta($post_id, '_price');
					delete_post_meta($post_id, '_sale_price');
					$product = wc_get_product( $post_id );
					if( $product->is_type('variable') ){
						$variations = $product->get_available_variations();
						foreach($variations as $var){
							$var_id = $var['variation_id'];
							$var_sale_price =  get_post_meta($var_id, '_sale_price');
							if(isset($var_sale_price[0]) && $var_sale_price[0] !== '')
								update_post_meta($var_id, '_init_var_sale_price', $var_sale_price[0]);

							delete_post_meta($var_id, '_price');
							delete_post_meta($var_id, '_sale_price');
						}
					}

				} catch (Exception $e) {
					echo 'Deleting failed: '.$e->getMessage();
				}

			}elseif($is_sale && $save_btn){
				// check if we have init sale price.
				$_init_price = get_post_meta($post_id, '_init_price');
				if(isset($_init_price[0]) && $_init_price != '')
					$_init_price = floatval($_init_price[0]);
				update_post_meta($post_id, '_price', $_init_price[0]);

				$_init_sale_price = get_post_meta($post_id, '_init_sale_price');
				if(isset($_init_sale_price[0]) && $_init_sale_price != '')
					$sale_price = floatval($_init_sale_price[0]);
				// var_dump($sale_price); exit;
				update_post_meta($post_id, '_sale_price', $sale_price);
				$product = wc_get_product( $post_id );
				if( $product->is_type('variable') ){
					$variations = $product->get_available_variations();
					foreach($variations as $var){
						$var_id = $var['variation_id'];
						$_init_var_sale_price =  get_post_meta($var_id, '_init_var_sale_price');
						if(isset($_init_var_sale_price[0]) && $_init_var_sale_price[0] !== ''){
							update_post_meta($var_id, '_price', $_init_price[0]);
							update_post_meta($var_id, '_sale_price', $_init_var_sale_price[0]);
						}else{
							update_post_meta($var_id, '_price', $_init_price[0]);
							update_post_meta($var_id, '_sale_price', $sale_price);
						}
					}
				}
			}
		}
	    
	    
	}
}

add_action( 'add_meta_boxes', 'dx_attr_meta_boxes' );
if ( ! function_exists( 'dx_attr_meta_boxes' ) )
{
    function dx_attr_meta_boxes()
    {
        add_meta_box( 'dx_attributes_import', __('Dropshix Import Attribute','woocommerce'), 'dx_import_attr', 'product', 'side', 'high', 'core' );
    }
}
if ( ! function_exists( 'dx_import_attr' ) ) {
    function dx_import_attr()
    {
    	global $post;

    	$prepared = 'no';

    	if (null !== filter_input_array(INPUT_GET)) {
    		$inputs = filter_input_array(INPUT_GET);

    		if(null !== $inputs['dsprepared'] && $inputs['dsprepared'] == 'yes')
    			$prepared = 'yes';
    	}

    	$product = new WC_Product_Variable($post->ID);
    	$plugin = new Dropshipping_Xox();
    	$key = $plugin->getKeys();
    	$curl = $plugin->checkAttr($post->ID);
    	$check = $curl['result'];
    	$attributes = $product->get_attributes();
    	
    	if($check < 1 && count($attributes) < 1):
			?>
			<div id="DXAttrWrapper">
				<div id="dxScanner">
					<h4>This item doesn't have attributes imported yet. Scan for attributes now?</h4>
					<p><a id="scanAttr" href="javascript:;" data-id="<?php echo $post->ID; ?>" data-key="<?php echo $key; ?>" class="fancybox-xox button button-alert">Scan Attributes</a></p>
				</div>
				<div id="dxImporter" style="display: none;">
					<p><a id="importAttr" href="javascript:;" data-id="<?php echo $post->ID; ?>" data-key="<?php echo $key; ?>" class="button button-primary">Import Attributes</a></p>
				</div>
			</div>
			<?php
		elseif($check > 0 && count($attributes) < 1):
			?>
			<div id="DXAttrWrapper">
				<div id="dxImporter">
					<p><a id="importAttr" href="javascript:;" data-id="<?php echo $post->ID; ?>" data-key="<?php echo $key; ?>" class="button button-primary">Import Attributes</a></p>
				</div>
			</div>
			<?php
		elseif( $product->is_type('variable') ):
			?>
			<div id="DXAttrWrapper">
				<div id="dxImporter">
					<?php
					$variables = $product->get_available_variations(); 
					$not_sale_product = get_post_meta($post->ID, '_no_sale_price');
					$is_not_sale = count($not_sale_product) > 0 && $not_sale_product[0] == 'no' ? ' checked="checked"' : '';
					if(count($variables) > 0){
						?>
						<p>Product variables are set and ready. Please press the "Update" button.</p>
						<?php
					}else{
						?>
						<p>Product variables are set but not distributed yet. Please press the "Update" button.</p>
						<?php
					} 
					?>
				</div>
			</div>
			<?php
		else:
			?>
			<div id="DXAttrWrapper">
				<div id="dxImporter">
					<p>All product's attributes are imported.</p>
				</div>
			</div>
			<?php
		endif;
		?>
		<div id="DXAttrWrapper">
			<div id="dxImporter">
				<p>
					<input type="hidden" name="dshix_woo_id" id="dshix_woo_id" value="<?php echo $post->ID; ?>">
					<input type="hidden" name="prepared" id="prepared" value="<?php echo $prepared; ?>">
					<label for="not_sale_product"><input type="checkbox" name="not_sale_product" id="not_sale_product" value="yes"<?php echo $is_not_sale; ?>> <strong>Disable "Sale" price.</strong></label>
				</p>
				<p id="saleResult" class="alert alert-warning" style="display: none;"></p>
			</div>
		</div>
		<?php
    }
}

// enable/disable Sale price.
add_action( 'wp_ajax_dshixDisableSale', 'dshixDisableSale' );
add_action( 'wp_ajax_nopriv_dshixDisableSale', 'dshixDisableSale' );

function dshixDisableSale()
{
	$resp = '';
	if (null !== filter_input_array(INPUT_POST)) {
		$inputs = filter_input_array(INPUT_POST);

		$disable = sanitize_text_field( strval( $inputs['sale'] ));
		$post_id = sanitize_text_field( intval( $inputs['post'] ));
		$plugin = new Dropshipping_Xox();
		$resp = $plugin->resetPriceMeta($disable, $post_id);
	}
	echo $resp;
	wp_die();
}

// changing source supplier.
add_action( 'wp_ajax_Xox_Switch_URL', 'Xox_Switch_URL' );
add_action( 'wp_ajax_nopriv_Xox_Switch_URL', 'Xox_Switch_URL' );

function Xox_Switch_URL()
{
	$url = '';
	if (null !== filter_input_array(INPUT_POST)) {
		$inputs = filter_input_array(INPUT_POST);
		$source = sanitize_text_field( strval( $inputs['source'] ));
		$plugin = new Dropshipping_Xox();
		$url = $plugin->getSourceStore($source);
	}
	echo $url;
	wp_die();
}

add_action( 'wp_ajax_importAtrrVar', 'importAtrrVar' );
add_action( 'wp_ajax_nopriv_importAtrrVar', 'importAtrrVar' );

function importAtrrVar()
{
	$output = array();
	if (null !== filter_input_array(INPUT_POST)) {
		$inputs = filter_input_array(INPUT_POST);
		$plugin = new Dropshipping_Xox();
		$curl = $plugin->importAttrVar($inputs['wooid']);

		$imports = $curl['result'];
		if(count($imports->variations) > 0){
			wp_set_object_terms($inputs['wooid'], 'variable', 'product_type');
			$output = $plugin->distributeAttrVar( $inputs['wooid'], $imports );
		}else{
			$output['status'] = 'error';
			$output['message'] = 'does not have variations';
		}
	}

	echo json_encode($output);
	wp_die();
}

add_action( 'wp_ajax_dropshixImportAtrr', 'dropshixImportAtrr' );
add_action( 'wp_ajax_nopriv_dropshixImportAtrr', 'dropshixImportAtrr' );

function dropshixImportAtrr()
{
	if (null !== filter_input_array(INPUT_POST)) {
		$inputs = filter_input_array(INPUT_POST);
		$plugin = new Dropshipping_Xox();
		$curl = $plugin->importAttr($inputs['wooid']);

		$imports = $curl['result'];
		$error = 0;
		foreach($imports as $key => $i){
			$_product_attributes[$i->the_title] = array(
			    'name' => $i->the_label,
			    'value' => $i->the_value,
			    'position' => 0,
			    'is_visible' => 1,
			    'is_variation' => 1,
			    'is_taxonomy' => 0
			);
			$insertAttr = update_post_meta($inputs['wooid'], '_product_attributes', $_product_attributes);
			if($insertAttr){
				$error = 0;
			}else{
				$error= $error+1;
			}
		}
	}
	if($error > 0){
		echo 0;
	}else{
		echo 1;
	}
	wp_die();
}