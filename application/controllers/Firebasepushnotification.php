<?php

defined('BASEPATH') or exit('No direct script access allowed');

class PushNotification extends CI_Controller
{
    //Sending push notification to android clients
    function send_push_notification()
    {
        //API URL of FCM
        $url = 'https://fcm.googleapis.com/fcm/send';

        //Firebase API key
        $api_key = 'BLQ7RTEpa6_6ia5MaSK2uohGQTJlMADt9iko9FallA1mQVoj2Q0K6o9PhKMPfqRteZZ5do0WSCKv_r3DC4JmJ3Y';
    }
}
