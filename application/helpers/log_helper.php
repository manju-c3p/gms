<?php date_default_timezone_set('Asia/Kolkata');
	
	function add_log_entry($user_id,$log_type,$page_name,$table_name,$key_name,$autoid) {
		$log_desc='';
		$CI=& get_instance();
		if($log_type!=3) {   // for add or update(except delete)
           	$temp ='';
        	$query=$CI->db->query("select *  from $table_name where $key_name = '$autoid' ");
        	$data['record'] = $query->result();
			
			if ($log_type==4) {
				$log_desc="Image(s) uploaded";
			}				
			else {
				foreach ($data['record'] as $key => $value) {
					foreach ($value as $k => $val) {	
	        			$temp = $temp ."|".$k.':'.$val;  // get key value for log desc
	        			 $log_desc = $temp;
					}
				}
        		//$log_desc = $fieldlist;        		
			}
                }	
		else {
			$log_desc=$table_name.$key_name.$autoid;
		}	
		$data=array(
			'user_id' => $user_id,
			'log_type'=>$log_type,
			'page_name'=>$page_name,
			'table_name'=>$table_name,
			'log_desc'=>$log_desc,
			'log_date'=>date('Y-m-d h:i:sa')
		);
		$CI->db->insert('log_activity', $data);		
		return true;
	}
	
	function add_notification($insert_id,$user_id,$msg,$redirect_url)
	{
		$CI=& get_instance();
		
		$data = array(
		'ref_id' => $insert_id,
		'user_id' => $user_id,
		'message'  => $msg,
		'msg_date'  => date('Y-m-d H:i:s'),
		'redirect_url'  => $redirect_url,
	      );
	      $CI->db->insert('notification', $data);	
		return true;
	}

	?>
