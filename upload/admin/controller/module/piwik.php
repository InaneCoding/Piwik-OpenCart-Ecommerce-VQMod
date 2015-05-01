<?php
class ControllerModulePiwik extends Controller {
	private $error = array(); 
	
	public function index() {   
		$this->load->language('module/piwik');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('piwik', $this->request->post);		
			
			//Write the settings to the piwik-proxy file
			$path_to_file = implode("/",explode("/", DIR_APPLICATION, -2)) . "/piwik-proxy.php";
			if (file_exists($path_to_file)) {
				$file_contents = file_get_contents($path_to_file);
				$file_contents = preg_replace('/\$ANALYTICS_URL = \'.{1,512}?\';/', '$ANALYTICS_URL = \'http://' . $this->request->post['piwik_analytics_url'] . '\';', $file_contents, 1);
				$file_contents = preg_replace('/\$TOKEN_AUTH = \'[a-z0-9]{1,32}\';/', '$TOKEN_AUTH = \'' . $this->request->post['piwik_token_auth'] . '\';', $file_contents, 1);
				file_put_contents($path_to_file,$file_contents);
			}
					
			$this->session->data['success'] = $this->language->get('text_success');
						
			$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}
				
		$data['heading_title'] = $this->language->get('heading_title');

		$data['entry_analytics_url'] = $this->language->get('entry_analytics_url');
		$data['entry_tracker_location'] = $this->language->get('entry_tracker_location');
		$data['entry_token_auth'] = $this->language->get('entry_token_auth');
		$data['entry_site_id'] = $this->language->get('entry_site_id');
		$data['entry_ec_enable'] = $this->language->get('entry_ec_enable');
		$data['entry_proxy_enable'] = $this->language->get('entry_proxy_enable');		
		$data['entry_use_sku'] = $this->language->get('entry_use_sku');
		$data['entry_enable'] = $this->language->get('entry_enable');
		
		$data['help_analytics_url1'] = $this->language->get('help_analytics_url1');
		$data['help_analytics_url2'] = $this->language->get('help_analytics_url2');
		$data['help_tracker_location1'] = $this->language->get('help_tracker_location1');
		$data['help_tracker_location2'] = $this->language->get('help_tracker_location2');
		$data['help_token_auth1'] = $this->language->get('help_token_auth1');
		$data['help_token_auth2'] = $this->language->get('help_token_auth2');
		$data['help_site_id1'] = $this->language->get('help_site_id1');
		$data['help_site_id2'] = $this->language->get('help_site_id2');
		$data['help_ec_enable'] = $this->language->get('help_ec_enable');
		$data['help_proxy_enable'] = $this->language->get('help_proxy_enable');		
		$data['help_use_sku'] = $this->language->get('help_use_sku');
		$data['help_enable'] = $this->language->get('help_enable');
		
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		
		$data['text_sku_sku'] = $this->language->get('text_sku_sku');
		$data['text_sku_model'] = $this->language->get('text_sku_model');
		
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		
 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		
 		if (isset($this->error['analytics_url'])) {
			$data['error_analytics_url'] = $this->error['analytics_url'];
		} else {
			$data['error_analytics_url'] = '';
		}
		
 		if (isset($this->error['tracker_location'])) {
			$data['error_tracker_location'] = $this->error['tracker_location'];
		} else {
			$data['error_tracker_location'] = '';
		}
		
 		if (isset($this->error['token_auth'])) {
			$data['error_token_auth'] = $this->error['token_auth'];
		} else {
			$data['error_token_auth'] = '';
		}
		
 		if (isset($this->error['site_id'])) {
			$data['error_site_id'] = $this->error['site_id'];
		} else {
			$data['error_site_id'] = '';
		}
		

  		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/piwik', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$data['action'] = $this->url->link('module/piwik', 'token=' . $this->session->data['token'], 'SSL');
		
		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['piwik_analytics_url'])) {
			$data['piwik_analytics_url'] = $this->request->post['piwik_analytics_url'];
		} elseif (!is_null($this->config->get('piwik_analytics_url'))) {
			// Use 'piwik_analytics_url' config setting if it exists...
			$data['piwik_analytics_url'] = $this->config->get('piwik_analytics_url');
		} else {
			// ... or derive from legacy 'piwik_http_url' setting if it doesn't.
			if (substr($this->config->get('piwik_http_url'), 0, 7) == 'http://') {
				$data['piwik_analytics_url'] = substr($this->config->get('piwik_http_url'), 7);
			} else {
				// http URL doesn't have 'http' at the front. Probably entered incorrectly. Use blank.
				$data['piwik_analytics_url'] = '';
			}
		}	
		
		if (isset($this->request->post['piwik_tracker_location'])) {
			$data['piwik_tracker_location'] = $this->request->post['piwik_tracker_location'];
		} else {
			$data['piwik_tracker_location'] = $this->config->get('piwik_tracker_location');
		}	
		
		if (isset($this->request->post['piwik_token_auth'])) {
			$data['piwik_token_auth'] = $this->request->post['piwik_token_auth'];
		} else {
			$data['piwik_token_auth'] = $this->config->get('piwik_token_auth');
		}	
		
		if (isset($this->request->post['piwik_site_id'])) {
			$data['piwik_site_id'] = $this->request->post['piwik_site_id'];
		} else {
			$data['piwik_site_id'] = $this->config->get('piwik_site_id');
		}	
		
		if (isset($this->request->post['piwik_ec_enable'])) {
			$data['piwik_ec_enable'] = $this->request->post['piwik_ec_enable'];
		} else {
			$data['piwik_ec_enable'] = $this->config->get('piwik_ec_enable');
		}
		
		if (isset($this->request->post['piwik_proxy_enable'])) {
			$data['piwik_proxy_enable'] = $this->request->post['piwik_proxy_enable'];
		} else {
			$data['piwik_proxy_enable'] = $this->config->get('piwik_proxy_enable');
		}	
		
		if (isset($this->request->post['piwik_use_sku'])) {
			$data['piwik_use_sku'] = $this->request->post['piwik_use_sku'];
		} else {
			$data['piwik_use_sku'] = $this->config->get('piwik_use_sku');
		}	
		
		if (isset($this->request->post['piwik_enable'])) {
			$data['piwik_enable'] = $this->request->post['piwik_enable'];
		} else {
			$data['piwik_enable'] = $this->config->get('piwik_enable');
		}	
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('module/piwik.tpl', $data));	
	}
	
	// Validate the user inputs in the POST data.
	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/piwik')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		// Check URL isn't empty, doesn't contain whitespace, and doesn't start with HTTP(S)://.
		if (empty($this->request->post['piwik_analytics_url']) || preg_match("/^https?:\/\/|\s/i", $this->request->post['piwik_analytics_url'])) {
			$this->error['analytics_url'] = $this->language->get('error_analytics_url');
		} else {
			// Check if URL ends with trailing slash '/' and if not, add it.
			$this->request->post['piwik_analytics_url'] .= (substr($this->request->post['piwik_analytics_url'], -1) == '/' ? '' : '/');
			
			// Form HTTP and HTTPS URLs.
			// Stored in database (and used in model/tool/piwik.php) as two separate URLs for backwards compatibility & ease.
			$this->request->post['piwik_http_url'] = 'http://' . $this->request->post['piwik_analytics_url'];
			$this->request->post['piwik_https_url'] = 'https://' . $this->request->post['piwik_analytics_url'];
		}
		
		//Make sure PiwikTracker.php has uppercase 'P' and 'T'.
		$this->request->post['piwik_tracker_location'] = str_ireplace("piwiktracker.php", "PiwikTracker.php", $this->request->post['piwik_tracker_location']);

		// Check tracker URL
		if (!empty($this->request->post['piwik_tracker_location']) && preg_match("/^\S{0,}\/PiwikTracker.php$/", $this->request->post['piwik_tracker_location']) ) {
			// Passes basic validity checks, check is readable
			if (!is_readable($this->request->post['piwik_tracker_location'])) {
				$this->error['tracker_location'] = $this->language->get('error_location_unreadable');
			}
		} else {
			// Invalid - empty, contains whitespace, or doesn't end in '/PiwikTracker.php'.
			$this->error['tracker_location'] = $this->language->get('error_location_invalid');
		}

		// abcde0123456789a0b1c2d3e41234567 - example token
		if (empty($this->request->post['piwik_token_auth']) || !preg_match("/^[a-f0-9]{32,}$/is", $this->request->post['piwik_token_auth']))
		{
			$this->error['token_auth'] = $this->language->get('error_token_auth');
		}
		
		if (empty($this->request->post['piwik_site_id']) || !is_numeric($this->request->post['piwik_site_id']))
		{
			$this->error['site_id'] = $this->language->get('error_site_id');
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
}
?>