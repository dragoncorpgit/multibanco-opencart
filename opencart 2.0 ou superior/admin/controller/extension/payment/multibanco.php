<?php
class ControllerExtensionPaymentMultibanco extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/payment/multibanco');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('multibanco', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=payment', true));
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_all_zones'] = $this->language->get('text_all_zones');

		$data['entry_order_status'] = $this->language->get('entry_order_status');
		$data['entry_entidade'] = $this->language->get('entry_entidade');
		$data['entry_subentidade'] = $this->language->get('entry_subentidade');
		$data['entry_valorminimo'] = $this->language->get('entry_valorminimo');
		$data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		$data['tab_general'] = $this->language->get('tab_general');

 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

  		$data['breadcrumbs'] = array();

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_home'),
				'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
			);

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_extension'),
				'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=payment', true)
			);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/payment/multibanco', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['action'] = $this->url->link('extension/payment/multibanco', 'token=' . $this->session->data['token'], true);

		$data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=payment', true);

		if (isset($this->request->post['multibanco_entidade'])) {
			$data['multibanco_entidade'] = $this->request->post['multibanco_entidade'];
		} else {
			$data['multibanco_entidade'] = $this->config->get('multibanco_entidade');
		}

		if (isset($this->request->post['multibanco_subentidade'])) {
			$data['multibanco_subentidade'] = $this->request->post['multibanco_subentidade'];
		} else {
			$data['multibanco_subentidade'] = $this->config->get('multibanco_subentidade');
		}

		if (isset($this->request->post['multibanco_valorminimo'])) {
			$data['multibanco_valorminimo'] = $this->request->post['multibanco_valorminimo'];
		} else {
			$data['multibanco_valorminimo'] = $this->config->get('multibanco_valorminimo');
		}

		if (isset($this->request->post['multibanco_order_status_id'])) {
			$data['multibanco_order_status_id'] = $this->request->post['multibanco_order_status_id'];
		} else {
			$data['multibanco_order_status_id'] = $this->config->get('multibanco_order_status_id');
		}

		$this->load->model('localisation/order_status');

		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		if (isset($this->request->post['multibanco_geo_zone_id'])) {
			$data['multibanco_geo_zone_id'] = $this->request->post['multibanco_geo_zone_id'];
		} else {
			$data['multibanco_geo_zone_id'] = $this->config->get('multibanco_geo_zone_id');
		}

		$this->load->model('localisation/geo_zone');

		$data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		if (isset($this->request->post['multibanco_status'])) {
			$data['multibanco_status'] = $this->request->post['multibanco_status'];
		} else {
			$data['multibanco_status'] = $this->config->get('multibanco_status');
		}

		if (isset($this->request->post['multibanco_sort_order'])) {
			$data['multibanco_sort_order'] = $this->request->post['multibanco_sort_order'];
		} else {
			$data['multibanco_sort_order'] = $this->config->get('multibanco_sort_order');
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/payment/multibanco.tpl', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/payment/multibanco')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}
?>
