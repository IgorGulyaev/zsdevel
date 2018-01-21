<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://xolluteon.com
 * @since      1.0.0
 *
 * @package    Dropshipping_Xox
 * @subpackage Dropshipping_Xox/admin
 *
 *
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Dropshipping_Xox
 * @subpackage Dropshipping_Xox/admin
 * @author     xolluteon <developer@xolluteon.com>
 */
class xDropShipConnect {
	private $apiUrl;
	private $apiUrl2;
	private $public;
	private $private;
	private $domain;
	private $source;
	
	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct() 
	{
		// Our main api url for all the actions.
		$this->apiUrl = 'https://dropshix.xolluteon.com/dropshix/api/v1/';
		$this->apiUrl2 = 'https://dropshix.xolluteon.com/dropshix/api/v2/';
        $options = get_option( 'dropshix_opt' );
		// we'll save all the credentials here for future connect activity
		$this->public = isset($options['dropshix_API_public']) ? ($options['dropshix_API_public']) : '' ;
        $this->private = isset($options['dropshix_API_private']) ? ($options['dropshix_API_private']) : '' ;
		$domain = $_SERVER['SERVER_NAME'];
		if(strpos('www.', $domain) != false){
			$this->domain = str_replace('www.', '', $domain);
		}else{
			$this->domain = $domain;
		}
		$this->source = $options['x_tool_source'];
	}

	public function loadSearchUri()
	{
		switch($this->source){
			case 'ae' : 
				$auth = base64_encode($this->public.'|'.$this->private.'|'.$this->domain);
				$url = 'https://dropshix.xolluteon.com/dropshix/ali/search/'.$auth;
			break;
			case 'amus' : 
				$auth = base64_encode($this->public.'|'.$this->private.'|'.$this->domain);
				$url = 'https://dropshix.xolluteon.com/dropshix/amus/search/'.$auth;
			break;
			default : $url = ''; 
		}
		return $url;
	}

	public function getSupplierURL($source)
	{
		switch($source){
			case 'ae' :
				$auth = base64_encode($this->public.'|'.$this->private.'|'.$this->domain); 
				$url = 'https://dropshix.xolluteon.com/dropshix/ali/search/'.$auth;
			break;
			case 'amus' : 
				$auth = base64_encode($this->public.'|'.$this->private.'|'.$this->domain);
				$url = 'https://dropshix.xolluteon.com/dropshix/amus/search/'.$auth;
			break;
			default : $url = ''; 
		}
		return $url;
	}
    
    public function getQueuedListings($type)
    {
        $params = array(
            'command' => 'list',
            'type' => $type
        );
		$return = $this->postRequest($params);
		return $return;
	}
	
	private function postRequest($params)
	{
        $urlparams = http_build_query($params);
        $auth = base64_encode($this->public.'|'.$this->private.'|'.$this->domain);
        $url = $this->apiUrl2 . $auth . '/?' . $urlparams;

		// $post = $action == 'post' ? 1 : 0; // need to check whether GET is available using 0.
		$ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //curl_setopt($ch, CURLOPT_HTTPHEADER, ['host' => $this->domain]);
        $responce = curl_exec($ch);
        $content = json_decode($responce, false);
        $content->url = $url;
        
        if($content == null){
            $errorMsg = 'Server return null, this could be because of the server is down or in maintenance. Please contact developer@xolluteon.com.';
            $error = new \stdClass();
            $error->status = 'ERROR';
            $error->errorCode = 401001;
            $error->errorMsg = $errorMsg;
            $content = $error;
        }
        curl_close($ch);
        return $content;
	}
	
	function createOrUpdateSetting( $params )
	{
        $urlparams = http_build_query($params);
        $auth = base64_encode($this->public.'|'.$this->private.'|'.$this->domain);
        $url = $this->apiUrl . $auth . '/update-setting/?' . $urlparams;
            
		// $post = $action == 'post' ? 1 : 0; // need to check whether GET is available using 0.
		$ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //curl_setopt($ch, CURLOPT_HTTPHEADER, ['host' => $this->domain]);
        $responce = curl_exec($ch);
        $content = json_decode($responce, false);
        $content->url = $url;
        if($content == null){
            $errorMsg = 'Server return null, this could be because of the server is down or in maintenance. Please contact developer@xolluteon.com.';
            $error = new \stdClass();
            $error->status = 'ERROR';
            $error->errorCode = 401001;
            $error->errorMsg = $errorMsg;
            $content = $error;
        }
        curl_close($ch);
        return $content;
	}
	
	function actionProduct( $action, $id, $source, $wooid = null)
	{
        $wooid = ($wooid == null ) ? '': $wooid;

        $auth = base64_encode($this->public.'|'.$this->private.'|'.$this->domain);
        $url = $this->apiUrl2 . $auth . '/'.$action . '/' . $source.'/' . $id . '/' . $wooid;

		if($wooid == NULL)
			$url = $this->apiUrl2 . $auth . '/'.$action . '/' . $source.'/' . $id;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //curl_setopt($ch, CURLOPT_HTTPHEADER, ['host' => $this->domain]);
        $responce = curl_exec($ch);
        $content = json_decode($responce);
        $error = json_last_error_msg ();
        $content->url = $url;

        if(empty($content)){
            $errorMsg = 'Server return null, this could be because of the server is down or in maintenance. Please contact developer@xolluteon.com.';
            $error = new \stdClass();
            $error->status = 'ERROR';
            $error->errorCode = 401001;
            $error->errorMsg = $errorMsg;
            $content = $error;
        }
        curl_close($ch);
        return $content;
	}

	private function remove_utf8_bom($text)
	{
		// This will remove unwanted characters.
		// Check http://www.php.net/chr for details
		for ($i = 0; $i <= 31; ++$i) { 
		    $text = str_replace(chr($i), "", $text); 
		}
		$text = str_replace(chr(127), "", $text);

		// This is the most common part
		// Some file begins with 'efbbbf' to mark the beginning of the file. (binary level)
		// here we detect it and we remove it, basically it's the first 3 characters 
		if (0 === strpos(bin2hex($text), 'efbbbf')) {
			$text = substr($text, 3);
		}
		/*$bom = pack('H*','EFBBBF');
		$text = preg_replace("/^$bom/", '', $text);*/
		$text = stripslashes($text);
		$text = html_entity_decode((string) $text);

		return $text;
	}
	
	function getListingProduct( $id )
	{

        $auth = base64_encode($this->public.'|'.$this->private.'|'.$this->domain);
        $url = $this->apiUrl . $auth . '/detail/' . $id;
        
		$ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //curl_setopt($ch, CURLOPT_HTTPHEADER, ['host' => $this->domain]);
        $responce = curl_exec($ch);
        $content = json_decode($responce, false);
        $content->url = $url;
        if($content == null){
            $errorMsg = 'Server return null, this could be because of the server is down or in maintenance. Please contact developer@xolluteon.com.';
            $error = new \stdClass();
            $error->status = 'ERROR';
            $error->errorCode = 401001;
            $error->errorMsg = $errorMsg;
            $content = $error;
        }
        curl_close($ch);
        return $content;
	}

    function xoxBulkAction( $action, $item )
    {


        $auth = base64_encode($this->public.'|'.$this->private.'|'.$this->domain);
        $url = $this->apiUrl . $auth . '/bulkaction/'.$action.'/' . $item;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //curl_setopt($ch, CURLOPT_HTTPHEADER, ['host' => $this->domain]);

        $responce = curl_exec($ch);

        $content = json_decode($responce, false);
        $content->url = $url;
        
        if($content == null){
            $errorMsg = 'Server return null, this could be because of the server is down or in maintenance. Please contact developer@xolluteon.com.';
            $error = new \stdClass();
            $error->status = 'ERROR';
            $error->errorCode = 401001;
            $error->errorMsg = $errorMsg;
            $content = $error;
        }

        curl_close($ch);
        return $content;
    }

    function sendingAnalytics( $action, $item )
    {


        $auth = base64_encode($this->public.'|'.$this->private.'|'.$this->domain);
        $url = $this->apiUrl . $auth . '/record/'.$action.'/' . $item;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //curl_setopt($ch, CURLOPT_HTTPHEADER, ['host' => $this->domain]);

        $responce = curl_exec($ch);

        $content = json_decode($responce, false);
        $content->url = $url;
        
        if($content == null){
            $errorMsg = 'Server return null, this could be because of the server is down or in maintenance. Please contact developer@xolluteon.com.';
            $error = new \stdClass();
            $error->status = 'ERROR';
            $error->errorCode = 401001;
            $error->errorMsg = $errorMsg;
            $content = $error;
        }

        curl_close($ch);
        return $content;
    }

    function sendingdebug( $var )
    {


        $auth = base64_encode($this->public.'|'.$this->private.'|'.$this->domain);
        $url = 'https://dropshix.xolluteon.com/dropshix/debug';
        $var = json_encode($var,true);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "debug=".$var);
        //curl_setopt($ch, CURLOPT_HTTPHEADER, ['host' => $this->domain]);

        $responce = curl_exec($ch);

        $content = json_decode($responce, false);
        $content->url = $url;
        
        if($content == null){
            $errorMsg = 'Server return null, this could be because of the server is down or in maintenance. Please contact developer@xolluteon.com.';
            $error = new \stdClass();
            $error->status = 'ERROR';
            $error->errorCode = 401001;
            $error->errorMsg = $errorMsg;
            $content = $error;
        }

        curl_close($ch);
        //return $content;
    }

    function sendingOrders( $var )
    {

        $auth = base64_encode($this->public.'|'.$this->private.'|'.$this->domain);
        $url = $this->apiUrl .'pass/'. $auth . '/orders';

        $var = json_encode($var,true);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "orders=".$var);
        //curl_setopt($ch, CURLOPT_HTTPHEADER, ['host' => $this->domain]);

        $responce = curl_exec($ch);

        $content = json_decode($responce, false);
        
        curl_close($ch);
        return $content;
    }

    function getOrderList( $order_id )
    {

        $auth = base64_encode($this->public.'|'.$this->private.'|'.$this->domain);
        $url = $this->apiUrl .'pass/'. $auth . '/order/'.$order_id;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $responce = curl_exec($ch);

        $content['result'] = json_decode($responce, false);
        $content['url'] = $url;

        if($content == null){
            $errorMsg = 'Server return null, this could be because of the server is down or in maintenance. Please contact developer@xolluteon.com.';
            $error = new \stdClass();
            $error->status = 'ERROR';
            $error->errorCode = 401001;
            $error->errorMsg = $errorMsg;
            $content = $error;
        }

        curl_close($ch);
        return $content;
    }

    function checkAttr($woo_id)
    {

        $auth = base64_encode($this->public.'|'.$this->private.'|'.$this->domain);
        $url = $this->apiUrl .'attr/'. $auth . '/check/'.$woo_id;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $responce = curl_exec($ch);

        $content['result'] = json_decode($responce, false);
        $content['url'] = $url;

        if($content == null){
            $errorMsg = 'Server return null, this could be because of the server is down or in maintenance. Please contact developer@xolluteon.com.';
            $error = new \stdClass();
            $error->status = 'ERROR';
            $error->errorCode = 401001;
            $error->errorMsg = $errorMsg;
            $content = $error;
        }

        curl_close($ch);
        return $content;
    }

    function importAttr($woo_id)
    {

        $auth = base64_encode($this->public.'|'.$this->private.'|'.$this->domain);
        $url = $this->apiUrl .'attr/'. $auth . '/import/'.$woo_id;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $responce = curl_exec($ch);

        $content['result'] = json_decode($responce, false);
        $content['url'] = $url;

        if($content == null){
            $errorMsg = 'Server return null, this could be because of the server is down or in maintenance. Please contact developer@xolluteon.com.';
            $error = new \stdClass();
            $error->status = 'ERROR';
            $error->errorCode = 401001;
            $error->errorMsg = $errorMsg;
            $content = $error;
        }

        curl_close($ch);
        return $content;
    }

    function importAttrVar($woo_id)
    {

        $auth = base64_encode($this->public.'|'.$this->private.'|'.$this->domain);
        $url = $this->apiUrl2 .'attr/'. $auth . '/import/'.$woo_id;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $responce = curl_exec($ch);

        $content['result'] = json_decode($responce, false);
        $content['url'] = $url;

        if($content == null){
            $errorMsg = 'Server return null, this could be because of the server is down or in maintenance. Please contact developer@xolluteon.com.';
            $error = new \stdClass();
            $error->status = 'ERROR';
            $error->errorCode = 401001;
            $error->errorMsg = $errorMsg;
            $content = $error;
        }

        curl_close($ch);
        return $content;
    }

    function getScanAttrURL($woo_id)
    {

        $auth = base64_encode($this->public.'|'.$this->private.'|'.$this->domain);
        $url = $this->apiUrl2 .'attr/'. $auth . '/browse/'.$woo_id;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $responce = curl_exec($ch);

        $content['result'] = json_decode($responce, false);
        $content['url'] = $url;

        if($content == null){
            $errorMsg = 'Server return null, this could be because of the server is down or in maintenance. Please contact developer@xolluteon.com.';
            $error = new \stdClass();
            $error->status = 'ERROR';
            $error->errorCode = 401001;
            $error->errorMsg = $errorMsg;
            $content = $error;
        }

        curl_close($ch);
        return $content;
    }

    function getProfile()
    {

        $auth = base64_encode($this->public.'|'.$this->private.'|'.$this->domain);
        $url = $this->apiUrl . $auth . '/getProfile';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //curl_setopt($ch, CURLOPT_HTTPHEADER, ['host' => $this->domain]);

        $responce = curl_exec($ch);

        $content = json_decode($responce, false);
        $content->url = $url;
        
        curl_close($ch);
        return $content;
    }
}