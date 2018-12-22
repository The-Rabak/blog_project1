<?php
require_once "consts.php";
if(!function_exists("db_connect")){
    function db_connect(){
        if($link = mysqli_connect(MYSQL_HOST,MYSQL_USER,MYSQL_PWD,MYSQL_DB)){
            return $link;
        }
        else{
            die("DB connection has failed");
        }
    }
}
if(!function_exists('get_posts')){
    function get_posts($link){
        $sql = "SELECT * FROM blog_posts ORDER BY id DESC;";
        if($query = mysqli_query($link,$sql)){
            $my_posts = [];
            while($row = mysqli_fetch_assoc($query)){
                $my_posts[] = $row;
            }
            return $my_posts;
        }

    }
}
if(!function_exists('get_image')){
    function get_image($link, $post_id){
        $sql = "SELECT * FROM post_images WHERE post_id = '$post_id';";
        if($query = mysqli_query($link,$sql)){
            $my_posts = [];
            while($row = mysqli_fetch_assoc($query)){
                $my_posts[] = $row;
            }
            return $my_posts;
        }

    }
}
if(!function_exists('insert_post')) {
    function insert_post($link,string $name,string $pitch, int $uid, int $viscosity)
    {

        $sql = "INSERT INTO blog_posts(uid, ben_name, content, Viscosity) VALUES ('$uid','$name','$pitch','$viscosity');";

        if($query = mysqli_query($link,$sql)){

            if (mysqli_connect_errno())
            {
                echo "Failed to connect to MySQL: " . mysqli_connect_error(); die;
            }
            if(mysqli_affected_rows($link) > 0){

                return mysqli_insert_id($link);
            }
        }
    }
}
if(!function_exists('insert_image')) {
    function insert_image($link,string $img_name, int $post_id, $image)
    {

        $sql = "INSERT INTO post_images(image,img_name, post_id) VALUES ('$image','$img_name','$post_id');";

        if($query = mysqli_query($link,$sql)){

            if (mysqli_connect_errno())
            {
                echo "Failed to connect to MySQL: " . mysqli_connect_error(); die;
            }
            if(mysqli_affected_rows($link) > 0){

                return mysqli_insert_id($link);
            }
        }
    }
}
//if(!function_exists('send_mail')) {
//    function send_mail(string $recipient, string $subject, string $body){
//        require_once 'C:\xampp\htdocs\lesson4\vendor\autoload.php';
//
//        $transport = (new Swift_SmtpTransport('smtp.gmail.com', 465, "ssl"))
//            ->setUsername('')
//            ->setPassword('')
//        ;
//
//// Create the Mailer using created Transport
//        $mailer = new Swift_Mailer($transport);
//
//// Create a message
//        $message = (new Swift_Message('Wonderful Subject'))
//            ->setFrom(['' => 'The Rabak'])
//            ->setTo(['' => 'banim'])
//            ->setBody('Here is the message itself you bastard')
//        ;
//
//// Send the message
//        try {
//            $mailer->send($message);
//            return true;
//        }
//        catch (\Swift_TransportException $e) {
//            echo $e->getMessage();die;
//        }
//
//    }
//
//}