<?php
class Notification_model extends CI_Model
{
    // Get latest 10 notifications for a user
    public function get_user_notifications($user_id)
    {
        $this->db->select('msg_id, message, msg_date, redirect_url, read_flag');
        $this->db->from('notification');
        $this->db->where('user_id', $user_id);
        $this->db->order_by('msg_date', 'DESC');
        $this->db->limit(10);
        return $this->db->get()->result_array();
    }

    // Count unread notifications
    public function count_unread($user_id)
    {
        $this->db->where('user_id', $user_id);
        $this->db->where('read_flag', 0);
        return $this->db->count_all_results('notification');
    }

    // Mark specific notification as read
    public function mark_as_read($msg_id)
    {
        $this->db->where('msg_id', $msg_id);
        $this->db->update('notification', [
            'read_flag' => 1,
            'read_date' => date('Y-m-d H:i:s')
        ]);
    }
}

?>
