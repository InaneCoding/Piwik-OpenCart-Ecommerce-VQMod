<?php

class ModelToolPiwik extends Model {
	// Used to store Piwik Tracker object (don't touch!)
	private $t;
	
	/* Variables defined to be used later in the code */
	/* ---------------------------------------------------------------------------------------- */
	private $piwik_https_url;	// Piwik installation URL (https).
	private $piwik_http_url;	// Piwik installation URL.
	private $piwik_site_id;		// The Site ID for the site in Piwik.
	private $piwik_token_auth;	// Piwik auth token (from Piwik 'API' tab).
	private $piwik_ec_enable;	// True - to enable Ecommerce tracking.
								// False for basic page tracking.
						
	private $piwik_use_sku;		// True - Report Piwik SKU from Opencart 'SKU'.
								// False - Report Piwik SKU from Opencart 'Model'.
						
	private $piwik_proxy_enable;		// True - to enable the use of the piwik proxy script to hide trhe piwik URL.
										// False - for regular Piwik tracking.
	
	private $piwik_tracker_location;	// The full path to the PiwikTracker.php file
	/* ---------------------------------------------------------------------------------------- */	
	

	// Function to set various things up
	// Not 100% certain where most efficient to run, so just blanket running before each big block of API code
	// Called internally by other functions
	private function init() {
		// Load config data
		$this->load->model('setting/setting');
				
		$this->model_setting_setting->getSetting('piwik');		
			
		$this->piwik_enable = $this->config->get('piwik_enable');
		
		if ($this->piwik_enable) {
			// If mod enabled then load everything else up.
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
	}
	
	

	// Returns the text needed for the JAVASCRIPT method of setEcommerceView
	// (to be inserted in javascript footer as it occurs on every page)
	// Other ecommerce actions not on every page use PHP API.
	// Private as this is called internally to this class by getFooterText()
	private function setEcommerceView() {
		/* Get the Category info */
		// First, check the GET variable 'path' is set
		// Set to false - category reporting not fully supported in this version
		if (isset($this->request->get['path']) and false) {
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
		return '_paq.push(["setEcommerceView",' .
					$piwik_model . ',' .
					$piwik_product . ',' .
					$piwik_category . ',' .
					$piwik_price . ']);' . "\n";
	}
	
	
	
	// Tracks a cart update with Piwik PHP API
	// Calls PiwikTracker 'addEcommerceItem' iteratively for each product in cart
	// Calls PiwikTracker 'doTrackEcommerceCartUpdate' at the end to track the cart update
	public function trackEcommerceCartUpdate() {	
		
		$this->init();
		
		if ($this->piwik_ec_enable and $this->piwik_enable) {	
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



	// Tracks a Site Search
	// OC version  < 1.5.5 - Uses the Piwik PHP API (version not tracked automatically by Piwik).
	// OC version >= 1.5.5 - Uses the Piwik auto detection of GET variables, and Javascript to set number of results.
	// Called from both the javascript code and from the search results PHP page...
	// ...then works out what to return/do based on OC version (some calls unused).
	public function trackSiteSearch($search_keyword = NULL, $search_category_id = NULL, $search_results_total = NULL) {
		
		$this->init();
		
		if ($this->piwik_enable) {
			if (version_compare(VERSION, '1.5.5.0', '>=')) {
				// >= 1.5.5 so use javascript method (when called from the PHP page this is then unusued)
				if (isset($this->request->get['route']) and isset($this->session->data['last_search_total']) and $this->request->get['route'] == "product/search") {
					// If on a search page, return a bit of javascript to set the number of results on piwik.
					return "_paq.push(['setCustomUrl', document.URL + '&search_count=" . $this->session->data['last_search_total'] . "']);";
				} else {
					return '';
				}
				
			} else {
				// < 1.5.5 so use PHP method (only if called with correct arguments, so won't run when called from javascript).
				if (isset($search_keyword) and isset($search_results_total)) {
								
					// If the visitors piwik ID has been stored in the session data,
					// Then use this info to force the visitor ID used for the piwik API call.
					if (isset($this->session->data['piwik_visitorid'])) {
						// Set visitor ID based on what has been previously stored
						$this->t->setVisitorId($this->session->data['piwik_visitorid']);
					}
					
					//Set the default category title
					$category_title = '';
					
					// Get the search category, if it was specified
					if (isset($search_category_id)) {
						// Get the category info from the ID
						$category_info = $this->model_catalog_category->getCategory($search_category_id);
						
						if (isset($category_info['name'])) {
							// If the name is specified then use this as for search tracking
							$category_title = urldecode($category_info['name']);
						}
					}
					
					// Track the site search
					$this->t->doTrackSiteSearch($search_keyword, $category_title, $search_results_total);
				}
				
				return '';
			}
		} else {
			return '';
		}
	}



	// Tracks an order with Piwik PHP API
	// Calls PiwikTracker 'addEcommerceItem' iteratively for each product in order
	// Calls PiwikTracker 'doTrackEcommerceOrder' at the end to track order
	public function trackEcommerceOrder($order_id) {
	
		$this->init();
				
		if ($this->piwik_ec_enable and $this->piwik_enable) {
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
		
		$piwik_footer = ' ';
		
		if ($this->piwik_enable) {
			$piwik_footer .= '<!-- Piwik -->' . 
					'<script type="text/javascript">' .
					'var _paq = _paq || [];' . "\n";
					
			if ($this->piwik_ec_enable) {
				$piwik_footer .= $this->setEcommerceView();
			}
			
			// Get the javascript for the number of search results
			$piwik_footer .= $this->trackSiteSearch();
  
			$piwik_footer .= '_paq.push(["trackPageView"]);' .
					'_paq.push(["enableLinkTracking"]);' . "\n";
			
			if ($this->piwik_proxy_enable) {
				// Use Piwik proxy script to hide actual piwik URL.
				$piwik_footer .= '(function() {' .
						'var u=(("https:" == document.location.protocol) ? "' .
						HTTPS_SERVER . '" : "' . HTTP_SERVER . '");' .
						'_paq.push(["setTrackerUrl", u+"piwik-proxy.php"]);' .
						'_paq.push(["setSiteId", "' . (int)$this->piwik_site_id . '"]);' .
						'var d=document, g=d.createElement("script"), s=d.getElementsByTagName("script")[0]; g.type="text/javascript";' .
						'g.defer=true; g.async=true; g.src=u+"piwik-proxy.php"; s.parentNode.insertBefore(g,s);' .
						'})();' .
						'</script>' .
						'<!-- End Piwik Code -->';
			} else {
				// Regular tracking
				$piwik_footer .= '(function() {' .
						'var u=(("https:" == document.location.protocol) ? "' .
						$this->piwik_https_url . '" : "' . $this->piwik_http_url . '");' .
						'_paq.push(["setTrackerUrl", u+"piwik.php"]);' .
						'_paq.push(["setSiteId", "' . (int)$this->piwik_site_id . '"]);' .
						'var d=document, g=d.createElement("script"), s=d.getElementsByTagName("script")[0]; g.type="text/javascript";' .
						' g.async=true; g.defer=true; g.src=u+"piwik.js"; s.parentNode.insertBefore(g,s);' .
						'})();' .
						'</script>' .
						'<!-- End Piwik Code -->';
			}
		} else {
			$piwik_footer .= '<!-- Piwik Mod not enabled! Enter admin settings :) End Piwik Code -->';
		}

		return $piwik_footer;
	}
	
	
}
?>
