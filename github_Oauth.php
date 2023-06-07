<?php
session_start();

if (isset($_GET['code'])) {
    
    // $_SESSION['code'] =  $_GET['code'];
  


    $client_id = "eaebb1f00991bd4ca8ba";
    $client_secret = "95015656befe302741952426753097678bef701a";
    $url = "https://github.com/login/oauth/access_token";



        $postParams = [
        'client_id' => $client_id,
        'client_secret' => $client_secret,
        'code' => $_GET['code'],
        ];
   
        // A very simple PHP example that sends a HTTP POST to a remote site
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$postParams);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Accept: application/json']);
        $response = curl_exec($ch);
        curl_close($ch);
        //var_dump($response);
        $data = json_decode($response);

        if($data->access_token != ""){
            $username = "TonyOdolo";
            $url = "https://api.github.com/users/{$username}";

        // $url = "https://api.github.com/TonyOdolo";
        // https://github.com/TonyOdolo
        //https://api.github.com/TonyOdolo

        // var_dump($data->access_token);

        // A very simple PHP example that sends a HTTP POST to a remote site
        $ch1 = curl_init();
        //Set your auth headers
    curl_setopt($ch1, CURLOPT_HTTPHEADER, array(
   'Content-Type: application/json',
   'Authorization: Bearer ' . $data->access_token
   ));

        



        curl_setopt($ch1, CURLOPT_URL,$url);
        // curl_setopt($ch, CURLOPT_POST, 1);
        // curl_setopt($ch, CURLOPT_POSTFIELDS,$postParams);
        curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch, CURLOPT_HTTPHEADER, ['Accept: application/json']);
        curl_setopt($ch1, CURLOPT_FAILONERROR, true);
        $response = curl_exec($ch1);
       
        //var_dump($response);
        $dataResponse = json_decode($response);
        print_r($dataResponse);
        
        if (curl_errno($ch1)) {
            $error_msg = curl_error($ch1);
        }


        

        
        curl_close($ch1);
        
        if (isset($error_msg)) {
        
           
           
        }

    




    //     $_SESSION['my_access_token_accessTo'] = $data->access_token;
       
    //    header('Location:http://localhost/blogsystem/index.php');
        } 
        

        // echo $data->error_description;




}

?>
