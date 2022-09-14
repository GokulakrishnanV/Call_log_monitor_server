<?php

class Login_model extends CI_Model
{
    function can_login($email, $password)
    {
        $this->db->where('user_email',$email);
        $query = $this->db->get('users');
        if($query->num_rows()>0)
        {
            foreach ($query->result() as $row)
            {
                if($row->is_email_verified == 'yes')
                {
                    $password_hash = $row->user_password;
                    
                        if(password_verify($password,$password_hash))
                        {
                            $this->session->set_userdata('id',$row->id);
                        }
                        else
                        {
                            return 'Wrong Password';
                        }
                } 
                else 
                {
                    return 'Kindly verify your email address before logging in';
                }
            }
        }
        else
        {
            return 'Email address not found';
        }
    }
}

?>