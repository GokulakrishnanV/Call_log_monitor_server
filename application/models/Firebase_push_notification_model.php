<?php

defined('BASEPATH') or exit('No direct script access allowed');

class firebase_push_notification_model extends CI_Model
{
    function retreive_all_fcm_token()
    {
        // $this->db->where('fcm_token');
        $this->db->select('fcm_token');
        $query = $this->db->get('users');
        if ($query->num_rows() > 0) {
            $result_array = array();
            foreach ($query->result() as $row) {
                $result_array[] = $row->fcm_token;
                //echo $fcm_token;
            }
        }
        print_r($result_array);
        return $result_array;
    }
}

?>