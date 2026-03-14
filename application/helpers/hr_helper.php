<?php

		date_default_timezone_set('Asia/Dubai');

function get_extra_alowance($user_id, $start_date, $end_date)
{
    $CI =& get_instance();

    $query = $CI->db->query("SELECT ad.user_id, ad.approved_amount,ad.emp_req_id, am.allowance_name FROM employee_request_data ad join allowance_master am on ad.allowance_type=am.sno
     WHERE date('$start_date') between approved_form_date and approved_to_date and emp_reqtype='allowance'
      and approved_flag=1 and user_id=$user_id");
    return $query->result();
}

// function get_extra_deduction($user_id, $start_date, $end_date)
// {
//     $CI =& get_instance();

//     // Extracting month and year from the $start_date
//     $start_month = date('m', strtotime($start_date));
//     $start_year = date('Y', strtotime($start_date));

//     $query = $CI->db->query("SELECT user_id, approved_amount,emp_req_id,emp_reqtype,approve_emi FROM employee_request_data  
//      WHERE MONTH(approved_form_date) = $start_month AND YEAR(approved_form_date) = $start_year and emp_reqtype='loan' and approved_flag=1 and user_id=$user_id");
//     return $query->result();
// }

function get_extra_deduction($user_id, $start_date, $end_date)
{
    $CI =& get_instance();

    $query = $CI->db->query("SELECT user_id, approved_amount,emp_req_id,emp_reqtype,approve_emi FROM employee_request_data  
     WHERE date('$start_date') between approved_form_date and approved_to_date and emp_reqtype='loan' and approved_flag=1 and user_id=$user_id");
    return $query->result();
}
function get_extra_advance_salary($user_id, $start_date, $end_date)
{
    $CI =& get_instance();

    // Extracting month and year from the $start_date
     $start_month = date('Y-m-01', strtotime("$start_date +1 month"));
    
    $query = $CI->db->query("SELECT user_id, approved_amount,emp_req_id,emp_reqtype FROM employee_request_data  
     WHERE approved_form_date = '$start_month' and emp_reqtype='advance_salary' and approved_flag=1 and user_id=$user_id");
    return $query->result();
}

function get_extra_deduction_salary($user_id, $start_date, $end_date)
{
    $CI =& get_instance();

    // Extracting month and year from the $start_date
     $start_month = date('Y-m-01', strtotime("$start_date"));
    
    $query = $CI->db->query("SELECT user_id, approved_amount,emp_req_id,emp_reqtype FROM employee_request_data  
     WHERE approved_form_date = '$start_month' and emp_reqtype='advance_salary' and approved_flag=1 and user_id=$user_id");
    return $query->result();
}
?>
