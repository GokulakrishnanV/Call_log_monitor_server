<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Upload_fcm_token_model extends CI_Model
{
    //Uploading the FCM token
    function upload_fcm_token($user_name,$data){
        $this->db->where('user_name',$user_name);
        $query = $this->db->get('users');
        if ($query->num_rows() > 0) {
            $this->db->where('user_name', $user_name);
            $this->db->update('users', $data);
            return true;
        } else {
            return false;
        }
    }
}
?>