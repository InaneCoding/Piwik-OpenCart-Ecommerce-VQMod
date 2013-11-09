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
				$file_contents = preg_replace('/\$PIWIK_URL = \'.{1,512}?\';/', '$PIWIK_URL = \'http://' . $this->request->post['piwik_url'] . '\';', $file_contents, 1);
				$file_contents = preg_replace('/\$TOKEN_AUTH = \'[a-z0-9]{1,32}\';/', '$TOKEN_AUTH = \'' . $this->request->post['piwik_token_auth'] . '\';', $file_contents, 1);
				file_put_contents($path_to_file,$file_contents);
			}
					
			$this->session->data['success'] = $this->language->get('text_success');
						
			$this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}
				
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['entry_piwik_url'] = $this->language->get('entry_piwik_url');
		$this->data['entry_tracker_location'] = $this->language->get('entry_tracker_location');
		$this->data['entry_token_auth'] = $this->language->get('entry_token_auth');
		$this->data['entry_site_id'] = $this->language->get('entry_site_id');
		$this->data['entry_ec_enable'] = $this->language->get('entry_ec_enable');
		$this->data['entry_proxy_enable'] = $this->language->get('entry_proxy_enable');		
		$this->data['entry_use_sku'] = $this->language->get('entry_use_sku');
		$this->data['entry_enable'] = $this->language->get('entry_enable');
		
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		
		$this->data['text_sku_sku'] = $this->language->get('text_sku_sku');
		$this->data['text_sku_model'] = $this->language->get('text_sku_model');
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
 		if (isset($this->error['piwik_url'])) {
			$this->data['error_piwik_url'] = $this->error['piwik_url'];
		} else {
			$this->data['error_piwik_url'] = '';
		}
		
 		if (isset($this->error['tracker_location'])) {
			$this->data['error_tracker_location'] = $this->error['tracker_location'];
		} else {
			$this->data['error_tracker_location'] = '';
		}
		
 		if (isset($this->error['token'])) {
			$this->data['error_token'] = $this->error['token'];
		} else {
			$this->data['error_token'] = '';
		}
		
 		if (isset($this->error['site_id'])) {
			$this->data['error_site_id'] = $this->error['site_id'];
		} else {
			$this->data['error_site_id'] = '';
		}
		

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/piwik', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$this->data['action'] = $this->url->link('module/piwik', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['piwik_url'])) {
			$this->data['piwik_url'] = $this->request->post['piwik_url'];
		} elseif (!is_null($this->config->get('piwik_url'))) {
			// Use 'piwik_url' config setting if it exists...
			$this->data['piwik_url'] = $this->config->get('piwik_url');
		} else {
			// ... or derive from 'piwik_http_url' setting if it doesn't.
			if (substr($this->config->get('piwik_http_url'), 0, 7) == 'http://') {
				$this->data['piwik_url'] = substr($this->config->get('piwik_http_url'), 7);
			} else {
				// http URL doesn't have 'http' at the front. Probably entered incorrectly. Use blank.
				$this->data['piwik_url'] = '';
			}
		}	
		
		if (isset($this->request->post['piwik_tracker_location'])) {
			$this->data['piwik_tracker_location'] = $this->request->post['piwik_tracker_location'];
		} else {
			$this->data['piwik_tracker_location'] = $this->config->get('piwik_tracker_location');
		}	
		
		if (isset($this->request->post['piwik_token_auth'])) {
			$this->data['piwik_token_auth'] = $this->request->post['piwik_token_auth'];
		} else {
			$this->data['piwik_token_auth'] = $this->config->get('piwik_token_auth');
		}	
		
		if (isset($this->request->post['piwik_site_id'])) {
			$this->data['piwik_site_id'] = $this->request->post['piwik_site_id'];
		} else {
			$this->data['piwik_site_id'] = $this->config->get('piwik_site_id');
		}	
		
		if (isset($this->request->post['piwik_ec_enable'])) {
			$this->data['piwik_ec_enable'] = $this->request->post['piwik_ec_enable'];
		} else {
			$this->data['piwik_ec_enable'] = $this->config->get('piwik_ec_enable');
		}
		
		if (isset($this->request->post['piwik_proxy_enable'])) {
			$this->data['piwik_proxy_enable'] = $this->request->post['piwik_proxy_enable'];
		} else {
			$this->data['piwik_proxy_enable'] = $this->config->get('piwik_proxy_enable');
		}	
		
		if (isset($this->request->post['piwik_use_sku'])) {
			$this->data['piwik_use_sku'] = $this->request->post['piwik_use_sku'];
		} else {
			$this->data['piwik_use_sku'] = $this->config->get('piwik_use_sku');
		}	
		
		if (isset($this->request->post['piwik_enable'])) {
			$this->data['piwik_enable'] = $this->request->post['piwik_enable'];
		} else {
			$this->data['piwik_enable'] = $this->config->get('piwik_enable');
		}	
		
		$this->load->model('design/layout');
		
		$this->data['layouts'] = $this->model_design_layout->getLayouts();

		$this->template = 'module/piwik.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}
	
	// Validate the user inputs in the POST data.
	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/piwik')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		// Check URL isn't empty, doesn't contain whitespace, and doesn't start with HTTP(S)://.
		if (empty($this->request->post['piwik_url']) || preg_match("/^https?:\/\/|\s/i", $this->request->post['piwik_url'])) {
			$this->error['piwik_url'] = $this->language->get('error_piwik_url');
		} else {
			// Check if URL ends with trailing slash '/' and if not, add it.
			$this->request->post['piwik_url'] .= (substr($this->request->post['piwik_url'], -1) == '/' ? '' : '/');
			
			// Form HTTP and HTTPS URLs. Stored in database as two separate URLs for backwards compatibility.
			$this->request->post['piwik_http_url'] = 'http://' . $this->request->post['piwik_url'];
			$this->request->post['piwik_https_url'] = 'https://' . $this->request->post['piwik_url'];
		}
		
		//Make sure PiwikTracker.php has uppercase 'P' and 'T'.
		$this->request->post['piwik_tracker_location'] = str_ireplace("piwiktracker.php", "PiwikTracker.php", $this->request->post['piwik_tracker_location']);

		// Check URL isn't empty, doesn't contain whitespace, and does end in '/PiwikTracker.php'.
		if (empty($this->request->post['piwik_tracker_location']) || !preg_match("/^\S{0,}\/PiwikTracker.php$/", $this->request->post['piwik_tracker_location'])) {
			$this->error['tracker_location'] = $this->language->get('error_location');
		}

		// abcde0123456789a0b1c2d3e41234567 - example token
		if (empty($this->request->post['piwik_token_auth']) || !preg_match("/^[a-f0-9]{32,}$/is", $this->request->post['piwik_token_auth']))
		{
			$this->error['token'] = $this->language->get('error_token');
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