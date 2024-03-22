<?php

include 'config.php';

$login_button = '';

if(isset($_GET['code'])){
    $token = $google_client->fetchAccessTokenWithAuthCode($_GET['code']);

    if(!isset($token['error'])){

        $google_client->setAccessToken($token['access_token']);

        $_SESSION['access_token'] = $token['access_token'];

        $google_service = new Google_Service_Oauth2($google_client);

        $data = $google_service->userinfo->get();

        if(!empty($data['given_name'])){
            $_SESSION['user_first_name'] = $data['given_name'];
        }

        if(!empty($data['family_name'])){
            $_SESSION['user_last_name'] = $data['family_name'];
        }

        if(!empty($data['email'])){
            $_SESSION['user_email_address'] = $data['email'];
        }

        if(!empty($data['picture'])){
            $_SESSION['user_image'] = $data['picture'];
        }
    }
}

if(!isset($_SESSION['access_token'])){
    $login_button = '<a href="'.$google_client->createAuthUrl().'">Login With Google</a>';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjd.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container">
        <h2>php login usando google auth</h2>
        <div class="panel panel-default">
            <?php
            if($login_button == ""){

                echo '<div class="panel-heading">Bienvenido Usuario</div>';
                echo '<div class="panel-body">';
                echo '<img src="'.$_SESSION["user_image"].'" class="img-responsive img-circle img-thumbnail" />';
                echo '<h3><b>Nombre :</b> '.$_SESSION['user_first_name'].' '.$_SESSION['user_last_name'].'</h3>';
                echo '<h3><b>Email :</b> '.$_SESSION['user_email_address'].'</h3>';
                echo '<h3><a href="logout.php">Logout</h3></div>';

            }else{
                echo '<div align="center">'.$login_button.'</div>';
            }
            ?>
        </div>
    </div>
</body>
</html>