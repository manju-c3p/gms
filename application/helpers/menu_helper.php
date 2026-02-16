<?php
    function get_menu($uid) 
    {
        $CI =& get_instance();
        $CI->db->distinct();
        $CI->db->select('m.menu_sid');
        $CI->db->from('user_access u');
        $CI->db->join('menu_access m', 'u.access_id = m.menu_id', 'left');
        $CI->db->where('u.user_id', $uid);
        $CI->db->where('m.active', 1);
        $CI->db->order_by('m.indexid');
        $main_menu_ids = array_column($CI->db->get()->result_array(), 'menu_sid');
        $main_menu_details = [];
    
        if (!empty($main_menu_ids)) {
            $CI->db->select('*');
            $CI->db->from('menu_access');
            $CI->db->where_in('menu_id', $main_menu_ids);
            $CI->db->order_by('indexid');
        
            $main_menu_details = $CI->db->get()->result();
        }
        return $main_menu_details;
    
    }

    function get_menu_sid_count($temppid)
    {
        $CI =& get_instance();
        $query=$CI->db->query("select count(*) as mcount from menu_access where menu_sid='$temppid' and active=1 order by indexid ");
        return $query->row('mcount');
    }

    function get_menu_sid($temppid,$uid)
    {
        $CI =& get_instance();
        
        $query = $CI->db->query("
        SELECT menu_url, menu_name,indexid 
        FROM user_access u
        JOIN menu_access m ON m.menu_id = u.access_id
        WHERE menu_sid = '$temppid' AND user_id = '$uid' AND active = 1
        UNION
        SELECT menu_url, menu_name,indexid  
        FROM page_access p
        JOIN menu_access m ON p.menu_id = m.menu_id
        WHERE menu_sid = '$temppid' AND user_id = '$uid' AND active = 1
        ORDER BY indexid
        ");

        return $query->result();
    }

    function accesscontrol($id)
    {
        $CI =& get_instance();
        $query=$CI->db->query("select * from menu_access where menu_sid='$id'");
        return $query->result();
    }

    function check_pageaccess_status($user_id,$menu_id,$type)
    {
		$CI =& get_instance();
	    $query=$CI->db->query("select count(*) as count from page_access where user_id='$user_id' and menu_id=$menu_id and attribute='$type'");
	    return $query->row('count');
    }

    function get_add_menu_pageaccess($page_name,$type) {
		
		$CI =& get_instance();
		$CI->db->select('*');
		$CI->db->from('breadcrumb');
		
		$CI->db->where('page_name',$page_name);		
		$CI->db->where('page_type',$type);
		
		
		$query = $CI->db->get();
        return $query->result();
    }

    function has_access($user,$page,$access){
		$menu_id = get_menu_id_for_page($page);

		$CI=&get_instance();
		$CI->db->select('*');
		$CI->db->from('page_access p');
		$CI->db->where('menu_id',$menu_id);
		$CI->db->where('user_id',$user);
		$CI->db->where('attribute',$access);

		if($CI->db->get()->num_rows())
			return true;
		else
			return false;

	}

    function has_view_access($user,$page){
        $menu_id = get_menu_id_for_page($page);

        $CI=&get_instance();
		$CI->db->select('*');
		$CI->db->from('user_access u');
		$CI->db->where('access_id',$menu_id);
		$CI->db->where('user_id',$user);

		if($CI->db->get()->num_rows())
			return true;
		else
			return false;
    }

    function get_menu_id_for_page($page){
		$CI=&get_instance();
		$CI->db->select('*');
		$CI->db->from('menu_access m');
		$CI->db->where('menu_url',$page);
		$menu_id = $CI->db->get()->row('menu_id');

		if($menu_id == ''){
			$CI->db->select('*');
			$CI->db->from('edit_menu e');
			$CI->db->join('menu_access m','e.parent_menu=m.menu_name','left');
			$CI->db->where('e.page_name',$page);
			$menu_id = $CI->db->get()->row('menu_id');
		}
		return $menu_id;
	}

    function get_check_item_status_checked($user_id,$menu_id)
    {
        $CI =& get_instance();
        $query=$CI->db->query("select count(*) as count from user_access where resource_type='M' and user_id='$user_id' and access_id=$menu_id");
        return $query->row('count');
    }
    function get_check_extra_access($user_id) {
    $CI =& get_instance();
    $CI->db->select('access_id');
    $CI->db->where('user_id', $user_id);
    $query = $CI->db->get('user_privileges');
    $access_ids = array_column($query->result_array(), 'access_id'); // Get only access_id values
    return $access_ids;
}
function has_access_id($access_id) {
    $CI =& get_instance();
    $privileges = $CI->session->userdata('user_privileges');

    if (!empty($privileges)) {
        foreach ($privileges as $priv) {
            if (isset($priv->access_id) && $priv->access_id == $access_id) {
                return true;
            }
        }
    }
    return false;
}

function has_user_privilege($privilige,$user_id){
		// $menu_id = get_menu_id_for_page($page);

		$CI=&get_instance();
		$CI->db->select();
		$CI->db->from('user_privileges up');
        $CI->db->join('user_extra_access uea','up.access_id = uea.id');
		$CI->db->where('uea.access_name',$privilige);
		$CI->db->where('up.user_id',$user_id);
		$res = $CI->db->get()->num_rows();

		return $res;
	}

function numberToWords($number) {
   $words = array(
        0 => 'Zero', 1 => 'One', 2 => 'Two', 3 => 'Three', 4 => 'Four',
        5 => 'Five', 6 => 'Six', 7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
        10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve', 13 => 'Thirteen',
        14 => 'Fourteen', 15 => 'Fifteen', 16 => 'Sixteen',
        17 => 'Seventeen', 18 => 'Eighteen', 19 => 'Nineteen', 20 => 'Twenty',
        30 => 'Thirty', 40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
        70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety'
    );

    if ($number < 21) return $words[$number];
    elseif ($number < 100) {
        return $words[10 * floor($number / 10)] . ($number % 10 ? '-' . $words[$number % 10] : '');
    } elseif ($number < 1000) {
        return $words[floor($number / 100)] . ' Hundred' . ($number % 100 ? ' and ' . numberToWords($number % 100) : '');
    } elseif ($number < 1000000) {
        return numberToWords(floor($number / 1000)) . ' Thousand' . ($number % 1000 ? ' ' . numberToWords($number % 1000) : '');
    } else {
        return "number too large";
    }
}

///notiications/////////////////////////

function get_notification()
{
	$CI=&get_instance();
	$user_se_id=$CI->session->userdata('user_id');
	$query=$CI->db->query("select n.*,u.user_name from notification n left join users u on n.created_by = u.user_id  where read_flag=0 and n.user_id=$user_se_id order by msg_date desc LIMIT 5 ");
	return $query->result();
}

function add_notification($insert_id,$user_id,$msg,$redirect_url,$created_by)
{
	$CI=& get_instance();
		
	$data = array(
		'ref_id' => $insert_id,
		'user_id' => $user_id,
		'message'  => $msg,
		'msg_date'  => date('Y-m-d H:i:s'),
		'redirect_url'  => $redirect_url,
        'created_by'  => $created_by,
	      );
	$CI->db->insert('notification', $data);	
	return true;
}

?>
