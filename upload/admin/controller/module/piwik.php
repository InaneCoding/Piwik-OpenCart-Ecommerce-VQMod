<?php
class ControllerModulePiwik extends Controller {
	private $error = array(); 
	
	public function index() {   
		$this->load->language('module/piwik');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('piwik', $this->request->post);		
					
			$this->session->data['success'] = $this->language->get('text_success');
						
			$this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}
				
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['entry_http_url'] = $this->language->get('entry_http_url');
		$this->data['entry_https_url'] = $this->language->get('entry_https_url');
		$this->data['entry_tracker_location'] = $this->language->get('entry_tracker_location');
		$this->data['entry_token_auth'] = $this->language->get('entry_token_auth');
		$this->data['entry_site_id'] = $this->language->get('entry_site_id');
		$this->data['entry_ec_enable'] = $this->language->get('entry_ec_enable');
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
		
 		if (isset($this->error['http_url'])) {
			$this->data['error_http_url'] = $this->error['http_url'];
		} else {
			$this->data['error_http_url'] = '';
		}
		
 		if (isset($this->error['https_url'])) {
			$this->data['error_https_url'] = $this->error['https_url'];
		} else {
			$this->data['error_https_url'] = '';
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

		if (isset($this->request->post['piwik_http_url'])) {
			$this->data['piwik_http_url'] = $this->request->post['piwik_http_url'];
		} else {
			$this->data['piwik_http_url'] = $this->config->get('piwik_http_url');
		}	
		
		if (isset($this->request->post['piwik_https_url'])) {
			$this->data['piwik_https_url'] = $this->request->post['piwik_https_url'];
		} else {
			$this->data['piwik_https_url'] = $this->config->get('piwik_https_url');
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
	
	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/piwik')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (empty($this->request->post['piwik_http_url'])) {
			$this->error['http_url'] = $this->language->get('error_url');
		}

		if (empty($this->request->post['piwik_https_url'])) {
			$this->error['https_url'] = $this->language->get('error_url');
		}

		if (empty($this->request->post['piwik_tracker_location'])) {
			$this->error['tracker_location'] = $this->language->get('error_location');
		}

		// abcde0123456789a0b1c2d3e41234567 - example token
		if (empty($this->request->post['piwik_token_auth']) 
			|| !preg_match("/^[a-f0-9]{32,}$/is", $this->request->post['piwik_token_auth']))
		{
			$this->error['token'] = $this->language->get('error_token');
		}
		
		if (empty($this->request->post['piwik_site_id']) 
			|| !is_numeric($this->request->post['piwik_site_id']))
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