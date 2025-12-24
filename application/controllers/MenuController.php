<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MenuController extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Menu_model');
	}

	// List all menus
	public function index()
	{

		$data['title'] 	 = "Menu";

		$data['menu_tree'] = $this->Menu_model->get_menu_tree();
		$data['main_content'] = 'users/menu_list.php';
		$this->load->view('includes/template', $data);
	}

	// Add new menu/submenu
	public function add()
	{
		$data['title'] 	 = "Menu";
		$data['parents'] = $this->Menu_model->get_parent_menus();
		$data['main_content'] = 'users/menu_form.php';
		$this->load->view('includes/template', $data);
	}

	// Edit existing menu
	public function edit($id)
	{
		$data['title'] 	 = "Menu";
		$data['menu'] = $this->Menu_model->get_menu($id);
		$data['parents'] = $this->Menu_model->get_parent_menus();
		$data['main_content'] = 'users/menu_form.php';
		$this->load->view('includes/template', $data);
	}

	// Save new or updated menu
	public function save()
	{
		$menu_id = $this->input->post('menu_id');
		$menu = [
			'menu_name' => $this->input->post('menu_name'),
			'menu_url'  => $this->input->post('menu_url'),
			'parent_id' => $this->input->post('parent_id') ?: NULL,
			'is_active' => $this->input->post('is_active') ? 1 : 0
		];

		// auto-sort if empty
		if (empty($this->input->post('sort_order'))) {
			$parent_id = $menu['parent_id'];
			$max_order = $this->db->select_max('sort_order')
				->where('parent_id', $parent_id)
				->get('menus')->row()->sort_order ?? 0;
			$menu['sort_order'] = $max_order + 1;
		} else {
			$menu['sort_order'] = $this->input->post('sort_order');
		}

		$this->Menu_model->save_menu($menu, $menu_id);
		redirect('MenuController/index');
	}

	// Delete a menu
	public function delete($id)
	{
		$this->db->where('menu_id', $id)->delete('menus');
		redirect('MenuController/index');
	}

	public function deactivate($id)
	{
		$this->db->where('menu_id', $id)->update('menus', ['is_active' => 0]);
		redirect('MenuController/index');
	}

	public function reactivate($id)
	{
		$this->db->where('menu_id', $id)->update('menus', ['is_active' => 1]);
		redirect('MenuController/index');
	}

	public function access_control()
	{
		$data['title'] 	 = "Menu Access Control";
		$data['users'] = $this->db->get('users')->result();
		$data['menus'] = $this->db->order_by('sort_order')->get('menus')->result();

			$data['main_content'] = 'users/menu_access.php';
		$this->load->view('includes/template', $data);
	
	}

	public function get_user_access($user_id)
	{
		$menus = $this->db->order_by('sort_order')->get('menus')->result();
		$user_access = $this->db->where('user_id', $user_id)
			->get('user_menu_access')
			->result_array();
		$access_ids = array_column($user_access, 'menu_id');

		$html = '<ul class="space-y-2">';
		foreach ($menus as $m) {
			if (empty($m->parent_id)) {
				$checked = in_array($m->menu_id, $access_ids) ? 'checked' : '';
				$html .= '<li><label class="font-semibold">
                        <input type="checkbox" class="menu-checkbox parent-menu" data-id="' . $m->menu_id . '" value="' . $m->menu_id . '" ' . $checked . '> ' . $m->menu_name . '
                      </label>';

				// Submenus
				$subs = array_filter($menus, fn($sm) => $sm->parent_id == $m->menu_id);
				if ($subs) {
					$html .= '<ul class="pl-6 mt-2 space-y-1">';
					foreach ($subs as $sm) {
						$checked = in_array($sm->menu_id, $access_ids) ? 'checked' : '';
						$html .= '<li><label>
                                <input type="checkbox" class="menu-checkbox submenu" data-parent="' . $m->menu_id . '" value="' . $sm->menu_id . '" ' . $checked . '> ' . $sm->menu_name . '
                              </label></li>';
					}
					$html .= '</ul>';
				}

				$html .= '</li>';
			}
		}
		$html .= '</ul>';

		echo $html;
	}

	public function save_user_access()
	{
		$data = json_decode($this->input->raw_input_stream, true);
		$user_id = $data['user_id'];
		$menu_ids = $data['menu_ids'];

		$this->db->where('user_id', $user_id)->delete('user_menu_access');

		foreach ($menu_ids as $mid) {
			$this->db->insert('user_menu_access', [
				'user_id' => $user_id,
				'menu_id' => $mid,
				'can_view' => 1
			]);
		}

		echo json_encode(['status' => 'success', 'message' => 'Access rights saved successfully!']);
	}
}
