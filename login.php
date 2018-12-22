<?php
session_start();
require_once "func.php";
$link = db_connect();
$err = '';
$is_valid_form = true;
if (isset($_POST['login'])) {
    if ($_POST['token'] == $_SESSION['csrf_token']) {

        if (empty($_POST['log_pwd'])) {
            $err = "Well just leave the front door open why don't ya";
            $is_valid_form = false;
        } elseif (empty($_POST['log_email'])) {
            $err = "There's no way you'll miss out on our newsletter";
            $is_valid_form = false;
        } else {

            $log_email = strtolower(filter_input(INPUT_POST, 'log_email', FILTER_SANITIZE_EMAIL));
            $log_pwd = trim(filter_input(INPUT_POST, 'log_pwd', FILTER_SANITIZE_STRING));
            $log_query = "SELECT * FROM users WHERE email = '$log_email';";
            if ($log_request = mysqli_query($link, $log_query)) {
                if (mysqli_num_rows($log_request) > 0) {

                    $result = mysqli_fetch_assoc($log_request);

                    if (password_verify($log_pwd, $result['pwd'])) {

                        $_SESSION['id'] = $result['id'];
                        $_SESSION['uname'] = $result['uname'];
                        $_SESSION['email'] = $result['email'];
                        $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
                        $_SESSION['ip_addr'] = $_SERVER['REMOTE_ADDR'];

                         header("location: blog.php");
                    } else {
                        $err = 'password incorrect';
                    }
                } else {
                    $err = 'email not found';
                }
            }
        }
    }
    else{
        $err = "please play nice";
    }
}
$csrf_token = hash("sha256", rand(300,9999999));
$_SESSION['csrf_token'] = $csrf_token;

?>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel="stylesheet" href="form_style.css">

    <link href='https://fonts.googleapis.com/css?family=Lato:300,400,400italic,700,700italic' rel='stylesheet'>
    <script
            src="https://code.jquery.com/jquery-3.3.1.min.js"
            integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
            crossorigin="anonymous"></script>
</head>
<body>
<div class="login-page">
    <div class="form">

        <form class="" method="post" action="#">
            <input type="email" name="log_email" placeholder="email"/>
            <input type="password" name="log_pwd" placeholder="password"/>
            <input type="submit" class="button1" name="login" value="login"/>
            <span style="color: firebrick;"><?= $err; ?>  </span>
            <input type="hidden" name="token" value="<?= $csrf_token ?>">
        </form>
    </div>
</div>
<script src="https://static.codepen.io/assets/editor/full/full_page_renderer-4e37f22daf9386e72f5c917a6386642636bb519a8c4c7e2206824f9f27de95eb.js"></script>

</body>
</html>