<?php
class Menu_model extends CI_Model
{
    public function get_all_menus()
    {
        return $this->db->order_by('parent_id, sort_order')->get('menus')->result();
    }

    public function get_menu($id)
    {
        return $this->db->where('menu_id', $id)->get('menus')->row();
    }

    public function save_menu($data, $id = null)
    {
        if ($id) {
            $this->db->where('menu_id', $id)->update('menus', $data);
        } else {
            $this->db->insert('menus', $data);
        }
    }

    public function get_parent_menus()
    {
        return $this->db->where('parent_id IS NULL', null, false)
                        ->order_by('sort_order')
                        ->get('menus')
                        ->result();
    }

    public function get_menu_tree()
    {
        $menus = $this->get_all_menus();
        $tree = [];
        foreach ($menus as $menu) {
            $tree[$menu->parent_id][] = $menu;
        }
        return $tree;
    }
}
