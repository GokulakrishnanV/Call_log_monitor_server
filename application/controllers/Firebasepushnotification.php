<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Firebasepushnotification extends CI_Controller
{
    //Loading the firebase_push_notification model
    public function __construct()
    {
        parent::__construct();
        $this->load->model('firebase_push_notification_model');
    }
    //Sending push notification to android clients
    function index()
    {
        //FCM HTTP V1 API
        // //Creating a google client
        // $client = new Google\Client();

        // //Client secret file
        // $client->setAuthConfig('/home/gokulkrish/Downloads/client_secret_965500047431-7v53i8k9ig9t7ho3mfmgfnbr9hfd33s3.apps.googleusercontent.com.json');

        // //Access requesting services
        // $client->addScope(Google\Service\FirebaseCloudMessaging::CLOUD_PLATFORM);

        // //Redirect url
        // $client->setRedirectUri('http://localhost:8080');

        // // offline access will give you both an access and refresh token so that
        // // your app can refresh the access token without user interaction.
        // $client->setAccessType('offline');

        // // Using "consent" ensures that your application always receives a refresh token.
        // // If you are not using offline access, you can omit this.
        // $client->setApprovalPrompt('consent');

        // $client->setIncludeGrantedScopes(true);   // incremental auth

        // //Google OAuth2.0 url
        // $auth_url = $client->createAuthUrl();

        // //Header to send credentials to receive token
        // header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));

        // //Receiving the token
        // $client->authenticate($_GET['code']);

        // //Token from the response
        // $access_token = $client->getAccessToken();

        // //Setting the access token in the session
        // $client->setAccessToken($access_token);

        //FCM HTTP LEGACY API
        //API URL of FCM
        $url = 'https://fcm.googleapis.com/fcm/send';

        //Firebase API key
        $api_key = 'AAAA4MxJkEc:APA91bGjQ_ekMeuMiPXUPGJRrMfLiE-ay6jP_0Ju87Uu1JlBkQzMBFDniQDRIXUC-xEqwdNyfkU4Hv2PL3ztTd8DUvDi2IKRTYQruNey8KwTfybkOV1K5QRqpZCfJP6bD_QpwMabIUVk';

        //Poco f1 device id
        $device_id = $this->firebase_push_notification_model->retreive_all_fcm_token();

        //Notification title
        $title = 'Test notification from PHP server';

        //Notification Message
        $message = array(
            'year' => 2022,
            'month' => 10,
            'date' => 02,
            'hours' => 15,
            'minutes' => 22,
        );

        $fields = array(
            'registration_ids' => $device_id,
            'notification' => array(
                "title" => "test",
                "body" => "test messaging using legacy FCM API",
            ),
            'data' => $message,
        );

        //header includes Content type and api key
        $headers = array(
            'Content-Type:application/json',
            'Authorization:key=' . $api_key
        );

        $ch = curl_init();
        curl_setopt(
            $ch,
            CURLOPT_URL,
            $url
        );
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('FCM Send Error: ' . curl_error($ch));
        }
        curl_close($ch);
        echo $result;
    }
}