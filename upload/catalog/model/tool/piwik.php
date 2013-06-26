<?php

class ModelToolPiwik extends Model {
	// Used to store Piwik Tracker object (don't touch!)
	private $t;
	
	/* Variables temporarily defined at the top (to develop into admin backend at a later date) */
	/* ---------------------------------------------------------------------------------------- */
	private $piwik_https_url;	// Your Piwik installation URL (https).
	private $piwik_http_url;	// Your Piwik installation URL.
	private $piwik_site_id;	// The Site ID for your site in Piwik.
	private $piwik_token_auth;		// Your Piwik auth token (from Piwik 'API' tab).
	private $piwik_ec_enable;	// True - to enable Ecommerce tracking.
						// False for basic page tracking.
						
	private $piwik_use_sku;		// True - Report Piwik SKU from Opencart 'SKU'.
						// False - Report Piwik SKU from Opencart 'Model'.
						
	private $piwik_proxy_enable;		// True - to enable the use of the piwik proxy script to hide trhe piwik URL.
					// False - for regular Piwik tracking.
	
	// The full path to the PiwikTracker.php file (MUST use for Ecommerce tracking to work - get from Piwik website).
	private $piwik_tracker_location;
	/* ---------------------------------------------------------------------------------------- */	
	

	// Function to set various things up
	// Not 100% certain how / where to run this, so just blanket running before each big block of API code
	// Called internally by trackEcommerceCartUpdate and trackEcommerceOrder
	private function init() {
		// Load config data
		$this->load->model('setting/setting');
				
		$this->model_setting_setting->getSetting('piwik');		
			
		$this->piwik_http_url = $this->config->get('piwik_http_url');
		$this->piwik_https_url = $this->config->get('piwik_https_url');
		$this->piwik_tracker_location = $this->config->get('piwik_tracker_location');
		$this->piwik_site_id = $this->config->get('piwik_site_id');
		$this->piwik_token_auth = $this->config->get('piwik_token_auth');
		$this->piwik_ec_enable = $this->config->get('piwik_ec_enable');
		$this->piwik_proxy_enable = $this->config->get('piwik_proxy_enable');
		$this->piwik_use_sku = $this->config->get('piwik_use_sku');
		
		// -- Piwik Tracking API initialisation -- 
		require_once $this->piwik_tracker_location;		// Require Piwik PHP tracking API
		
		$this->t = new PiwikTracker( $this->piwik_site_id, $this->piwik_http_url);
		$this->t->setTokenAuth( $this->piwik_token_auth);
		
		// Get the visitor ID and store it in the session data for use later
		$this->session->data['piwik_visitorid'] = $this->t->getVisitorId();
		
		$this->load->model('catalog/category');
		$this->load->model('catalog/product');
		$this->load->model('account/order');
	}
	
	

	// Returns the text needed for the JAVASCRIPT method of setEcommerceView
	// (to be inserted in javascript footer as it occurs on every page)
	// Other ecommerce actions not on every page use PHP API.
	// Private as this is called internally to this class by getFooterText()
	private function setEcommerceView() {				
		if ($this->piwik_ec_enable) {	
			/* Get the Category info */
			// First, check the GET variable 'path' is set
			// Set to false - category reporting not fully supported in this version
			if (false) {
				//Initialise variables etc
				$piwik_category = '';
			
				// Split the path variable into its ID parts
				// Path variable is format of 'x' for a top category,
				// format 'x_x' for a second-level category,
				// format 'x_x_x' for a third level, etc.
				// Each 'x' is the ID of the category at that level
				$parts = explode('_', (string)$this->request->get['path']);
			
				// For each ID in the path...
				foreach ($parts as $path_id) {
					// Get the info for this category ID
					// Uses function from the catalog/category model
					$category_info = $this->model_catalog_category->getCategory($path_id);
					
					if ($category_info) {
						if (!$piwik_category) {
							// First item in category list
							// Set start of string up for Javascript array
							// Then add name of category
							$piwik_category = '"' . $category_info['name'];
						} else {
							// Somewhere in middle of category list
							// Add name of category
							$piwik_category .= ' > ' . $category_info['name'];
						}
					}
				}
				// Finish off the end text for the Javascript string
				$piwik_category .= '"';	
			} else {
				// If there is no 'path' GET variable, then we are not in a category
				// So set the appropriate 'false' text to use (see piwik JavaScript function)
				$piwik_category = "categoryName = false";
			}
	
	
			/* Get the Product info */
			if (isset($this->request->get['product_id'])) {
				// Read the product ID from the GET variable
				$product_id = $this->request->get['product_id'];
				
				// Look up the product info using the product ID					
				// Uses function from the catalog/product model
				$product_info = $this->model_catalog_product->getProduct($product_id);
				
				// Get the individual pieces of info
				if ($this->piwik_use_sku) {
					$piwik_model = '"' . $product_info['sku'] . '"';
				} else {
					$piwik_model = '"' . $product_info['model'] . '"';
				}
				$piwik_product = '"' . $product_info['name'] . '"';
				$piwik_price = (string)$product_info['price'];
			} else {
				// If there is no 'product_id' GET variable, then we are not in a product
				// So set the appropriate 'false' text to use (see piwik JavaScript function)
				$piwik_model = "productSKU = false";
				$piwik_product = "productName = false";
				$piwik_price = "price = false";
			}
			
			// Return the javascript text to insert into footer	
			return 'piwikTracker.setEcommerceView(' .
						$piwik_model . ',' .
						$piwik_product . ',' .
						$piwik_category . ',' .
						$piwik_price . ');' . "\n";
		} else {
			// Ecommerce tracking turned off - return blank string
			return '';
		}
	}
	
	
	
	// Tracks a cart update with Piwik PHP API
	// Calls PiwikTracker 'addEcommerceItem' iteratively for each product in cart
	// Calls PiwikTracker 'doTrackEcommerceCartUpdate' at the end to track the cart update
	public function trackEcommerceCartUpdate() {	
		
		$this->init();
		
		if ($this->piwik_ec_enable) {	
			// If the visitors piwik ID has been stored in the session data,
			// Then use this info to force the visitor ID used for the piwik API call.
			if (isset($this->session->data['piwik_visitorid'])) {
				// Set visitor ID based on what has been previously stored
				$this->t->setVisitorId($this->session->data['piwik_visitorid']);
			}
			
			/* Get the Cart info */
			// First, check if the cart has items in
			if ($this->cart->hasProducts()) {
				$cart_total = 0;
				
				// Read all the info about items in the cart
				$cart_info = $this->cart->getProducts();
				
				// For product in the cart...
				foreach ($cart_info as $cart_item) {
					// Get the info for this product ID					
					// Uses function from the catalog/product model
					$product_info = $this->model_catalog_product->getProduct($cart_item['product_id']);
					
					// Decide whether to use 'Model' or 'SKU' from product info
					if ($this->piwik_use_sku) {
						$product_info_sku = $product_info['sku'];
					} else {
						$product_info_sku = $product_info['model'];
					}
					
					// Add this cart item to the piwik ecommerce cart
					$this->t->addEcommerceItem(
						$product_info_sku,
						$cart_item['name'],
						$category = false,
						$cart_item['price'],
						$cart_item['quantity']
					);
					
					$cart_total += ($cart_item['price'] * $cart_item['quantity']);
				}
				
				// Now track the cart update for the above items
				$this->t->doTrackEcommerceCartUpdate($cart_total);
			} else {
				// Nothing in the cart, so track an empty cart (value of zero)
				$this->t->doTrackEcommerceCartUpdate(0);
			}
		}	
	}
	
	
	
	// Tracks an order with Piwik PHP API
	// Calls PiwikTracker 'addEcommerceItem' iteratively for each product in order
	// Calls PiwikTracker 'doTrackEcommerceOrder' at the end to track order
	public function trackEcommerceOrder($order_id) {
	
		$this->init();
				
		if ($this->piwik_ec_enable) {
			// If the visitors piwik ID has been stored in the session data,
			// Then use this info to force the visitor ID used for the piwik API call.
			if (isset($this->session->data['piwik_visitorid'])) {
				// Set visitor ID based on what has been previously stored
				$this->t->setVisitorId($this->session->data['piwik_visitorid']);
			}
			
			$order_info = $this->model_account_order->getOrder($order_id);
			$order_info_products = $this->model_account_order->getOrderProducts($order_id);
			$order_info_totals = $this->model_account_order->getOrderTotals($order_id);

			// Add ecommerce items for each product in the order before tracking
			foreach ($order_info_products as $order_product) {
				// Get the info for this product ID					
				$product_info = $this->model_catalog_product->getProduct($order_product['product_id']);
				
				// Decide whether to use 'Model' or 'SKU' from product info
				if ($this->piwik_use_sku) {
					$product_info_sku = (string)$product_info['sku'];
				} else {
					$product_info_sku = (string)$product_info['model'];
				}
					
				// Add this cart item to the piwik ecommerce cart (Piwik PHP API function)
				$this->t->addEcommerceItem(
					$product_info_sku,
					$order_product['name'],
					$category = false,
					$order_product['price'],
					$order_product['quantity']
				);
			}
			
			// Set everything to zero to start with
			$order_shipping = 0;
			$order_subtotal = 0;
			$order_taxes = 0;
			$order_grandtotal = 0;
			$order_discount = 0;
			
			// Find out shipping / taxes / total values
			foreach ($order_info_totals as $order_totals) {
				switch ($order_totals['code']) {
					case "shipping":
						$order_shipping += $order_totals['value'];
						break;
					case "sub_total":
						$order_subtotal += $order_totals['value'];
						break;
					case "tax":
						$order_taxes += $order_totals['value'];
						break;
					case "total":
						$order_grandtotal += $order_totals['value'];
						break;
					case "coupon":
						$order_discount += $order_totals['value'];
						break;
					case "voucher":
						$order_discount += $order_totals['value'];
						break;
					default:
						$this->log->write("Piwik OpenCart mod: unknown order total code '" .
						$order_totals['code'] . "'.");
						break;
				}
			}
					
			// Now track the Ecommerce order for the above items (Piwik PHP API function)
			$this->t->doTrackEcommerceOrder(
				$order_id,			// Order ID
				$order_grandtotal,		// Grand Total
				$order_subtotal,		// Sub Total
				$order_taxes,			// Tax
				$order_shipping,		// Shipping
				$order_discount			// Discount from coupon/vouchers
			);
		}
	}
	
		
	
	// Returns the Piwik Javascript text to place at the page footer
	// Generates based on Piwik URLs and settings
	// Includes code for setEcommerceView, depending on whether this option is set
	public function getFooterText() {
		
		$this->init();
		
		if ($this->piwik_proxy_enable) {
			// Use Piwik proxy script to hide actual piwik URL.
			
			/* TO DO - put piwik footer text for proxy here
			https://github.com/piwik/piwik/tree/master/misc/proxy-hide-piwik-url#piwik-proxy-hide-url	
			*/
							
		} else {
			// Regular tracking
			$piwik_footer = '<!-- Piwik -->' . 
					'<script type="text/javascript">' .
					'var pkBaseURL = (("https:" == document.location.protocol) ? "' .
					$this->piwik_https_url . '" : "' . $this->piwik_http_url . '");' .
					'document.write(unescape("%3Cscript src=\'" + pkBaseURL + "piwik.js\'' .
					'type=\'text/javascript\'%3E%3C/script%3E"));' .
					'</script><script type="text/javascript">' .
					'try {' .
					'var piwikTracker = Piwik.getTracker(pkBaseURL + "piwik.php", ' .
					(int)$this->piwik_site_id . ');' . "\n";
	
			$piwik_footer .= $this->setEcommerceView();
	
			$piwik_footer .= 'piwikTracker.trackPageView();' .
					'piwikTracker.enableLinkTracking();' .
					'} catch( err ) {}' .
					'</script><noscript><p><img src="' . $this->piwik_http_url .
					'piwik.php?idsite=' . (int)$this->piwik_site_id .
					'" style="border:0" alt="" /></p></noscript>' . "\n" .
					'<!-- End Piwik Tracking Code -->';
		}

		return $piwik_footer;
	}
	
	
}
?>