<?php
session_start();
require_once "func.php";
$link = db_connect();
$err = '';
$is_valid_form = true;
if(isset($_POST['register'])){
    if(empty($_POST['reg_name'])){
        $err = "We can't just call you Dude, now can we?";
        $is_valid_form = false;
    }
    elseif(empty($_POST['reg_pwd'])){
        $err = "Well just leave the front door open why don't ya";
        $is_valid_form = false;
    }
    elseif(empty($_POST['reg_email'])){
        $err = "There's no way you'll miss out on our newsletter";
        $is_valid_form = false;
    }
    else{

        $reg_name = trim(filter_input(INPUT_POST,'reg_name',FILTER_SANITIZE_STRING));
        $reg_email = strtolower(filter_input(INPUT_POST,'reg_email',FILTER_SANITIZE_EMAIL));
        $reg_pwd = trim(filter_input(INPUT_POST,'reg_pwd',FILTER_SANITIZE_STRING));

        $check_mail = "SELECT * FROM users WHERE email = '$reg_email';";
        $check_mail_query = mysqli_query($link,$check_mail);
        if(mysqli_num_rows($check_mail_query) > 0){
            $err = "email already exists";
            $is_valid_form = false;
        }

        $reg_query = "INSERT INTO users (uname, email, pwd) VALUES ('$reg_name', '$reg_email', '$reg_pwd')";

        if($is_valid_form){
        if($reg_request = mysqli_query($link,$reg_query)){
            header("location: thanks.php");
        }
        }
    }
}

?>
<!--
Copyright (c) 2018 by Aigars Silkalns (https://codepen.io/colorlib/pen/rxddKy)

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
-->
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
        <form class="register-form" method="post" action="#">
            <input type="text" name="reg_name" placeholder="name">
            <input type="password" name="reg_pwd" placeholder="password"/>
            <input type="text" name="reg_email" placeholder="email address"/>
            <input type="submit" class="button1" name="register" value="create"/>
            <span style="color: firebrick;"><?= $err; ?>  </span>
            <p class="message">Already registered? <a href="#">Sign In</a></p>
        </form>
        <form class="login-form" method="post" action="#">
            <input type="text" name="log_uname" placeholder="username"/>
            <input type="password" name="log_pwd" placeholder="password"/>
            <input type="submit" class="button1" name="login" value="login"/>
            <p class="message">Not registered? <a href="#">Create an account</a></p>
        </form>
    </div>
</div>
<script src="https://static.codepen.io/assets/editor/full/full_page_renderer-4e37f22daf9386e72f5c917a6386642636bb519a8c4c7e2206824f9f27de95eb.js"></script>

<script>
    $('.message a').click(function(){
        $('form').animate({height: "toggle", opacity: "toggle"}, "slow");
    });

</script>
</body>
</html>