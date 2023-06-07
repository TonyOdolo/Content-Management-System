<!-- < ?php

//init configuration
$clientID = '466262686595-45cjjaf5u6cp539jb4aa90kvk6o8vugq.apps.googleusercontent.com';
$clientSecret = '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';
$redirectUrl = 'http://localhost/blogsystem/googleOath.php';



// //create a client request to acces Google Api
// $client = new Google_Client();
// $client->setClientId($clientID);
// $client->setClientSecret($clientSecret);
// $client->setRedirectUri($redirectUrl);
// $client->addScope("email");
// $client->addScope("profile");

?> -->

<?php

class GoogleCredentials {
    private $clientId;
    private $clientSecret;
    private $redirectUri;

    public function __construct($clientId, $clientSecret, $redirectUri) {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->redirectUri = $redirectUri;
    }

    public function getClientId() {
        return $this->clientId;
    }

    public function getClientSecret() {
        return $this->clientSecret;
    }

    public function getRedirectUri() {
        return $this->redirectUri;
    }
}

// Create an instance of the GoogleCredentials class
$googleCredentials = new GoogleCredentials(
    '466262686595-45cjjaf5u6cp539jb4aa90kvk6o8vugq.apps.googleusercontent.com',
    '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',
    'http://localhost/blogsystem/googleOath.php',
);





?>