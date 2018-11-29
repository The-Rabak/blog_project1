<?php
session_start();
require_once "func.php";
$link = db_connect();
$err = '';
$is_valid_form = true;
if(isset($_POST['register'])){
    if(empty($_POST['log_name'])){
        $err = "We can't just call you Dude, now can we?";
        $is_valid_form = false;
    }
    elseif(empty($_POST['log_pwd'])){
        $err = "Well just leave the front door open why don't ya";
        $is_valid_form = false;
    }
    elseif(empty($_POST['log_email'])){
        $err = "There's no way you'll miss out on our newsletter";
        $is_valid_form = false;
    }
    else{
        $reg_name = trim(filter_input(INPUT_POST,$_POST['reg_name'],FILTER_SANITIZE_STRING));
        $reg_email = strtolower(filter_input(INPUT_POST,$_POST['reg_email'],FILTER_SANITIZE_EMAIL));
        $reg_pwd = trim(filter_input(INPUT_POST,$_POST['reg_pwd'],FILTER_SANITIZE_STRING));
        $reg_query = "INSERT INTO users (uname, email, pwd) VALUES ('$reg_name', '$reg_email', '$reg_pwd')";

        if($reg_request = mysqli_query($link,$reg_query)){
            header("location: thanks.php");
        }
    }
}

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
            <input type="text" name="log_uname" placeholder="username"/>
            <input type="password" name="log_pwd" placeholder="password"/>
            <input type="submit" class="button1" name="login" value="login"/>
            <span style="color: firebrick;"><?= $err; ?>  </span>
        </form>
    </div>
</div>
<script src="https://static.codepen.io/assets/editor/full/full_page_renderer-4e37f22daf9386e72f5c917a6386642636bb519a8c4c7e2206824f9f27de95eb.js"></script>

</body>
</html>