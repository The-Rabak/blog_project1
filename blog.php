<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("location: login.php");
}
require_once "func.php";
$link = db_connect();
$err = '';
$is_valid_form = true;




if (isset($_POST['submit'])) {
    if (empty($_POST['name'])) {
        $err = 'I hate calling people Jon Doe';
        echo $err;
        die;
        $is_valid_form = false;

    } elseif (empty($_POST['pitch'])) {
        $err = 'Sell yourself man, take a chance';
        echo $err;
        die;
        $is_valid_form = false;

    } elseif (empty($_POST['viscosity'])) {
        $err = 'Sperm goes on a scale of 1 to quicksand to volcanic, go nuts ;)';
        echo $err;
        die;
        $is_valid_form = false;

    } elseif (isset($_FILES['img'])) {
        $file = $_FILES['img'];
        $whitelist_type = array('image/jpeg', 'image/png', 'image/gif', 'image/jpg');
        if (function_exists('finfo_open')) {
            $file_info = finfo_open(FILEINFO_MIME_TYPE);

            if (!in_array(finfo_file($file_info, $file['tmp_name']), $whitelist_type)) {
                $err = "Uploaded file is not a valid image";
                echo $err;
                die;
                $is_valid_form = false;
            }
        }
        if (file_exists($file['name'])) {
            $err = "Uploaded file already exists";
            echo $err;
            die;
            $is_valid_form = false;
        } elseif ($file['size'] > 3000000) {
            $err = "Uploaded file too large";
            echo $err;
            die;
            $is_valid_form = false;
        }
        if ($is_valid_form) {

            $pname = mysqli_real_escape_string($link, $_POST['name']);
            $pitch = mysqli_real_escape_string($link, $_POST['pitch']);
            $viscosity = mysqli_real_escape_string($link, $_POST['viscosity']);
            $insert_action = insert_post($link, $pname, $pitch, $_SESSION['id'], $viscosity);

            if ($insert_action) {

                $target_dir = "uploads/";
                // $id_addon = $insert_action. "----";
                $target_file = $target_dir . basename($file['name']);
                $image = addslashes(file_get_contents($file['tmp_name']));
                if (move_uploaded_file($file["tmp_name"], $target_file)) {
                    if ($upload_img_sql = insert_image($link, basename($file['name']), $insert_action, $image)) {

                    }
                } else {
                    echo "Sorry, there was an error uploading your file.";
                    die;
                }
            }

        }

    }
}
$my_posts = get_posts($link);
?>
<?php require_once "header.php"; ?>

<!-- Page Content -->
<div class="container">

    <!-- Introduction Row -->
    <h1 class="my-4">So, you want to be a donor?
        <small>It's Nice to Meet You!</small>
    </h1>
    <p>Tell us something aboot you:</p>

    <form action="" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name">Your name:</label>
            <input type="text" name="name" class="form-control" placeholder="Enter name">
        </div>
        <div class="form-group">
            <label for="pitch">Why should our fine ass ladies pick you?</label>
            <textarea name="pitch" class="form-control" rows="5" placeholder="Explain yo'self boy!"></textarea>

        </div>
        <div class="form-group">
            <label for="viscosity">Rate your sperm viscosity on a numeric scale:</label>
            <input type="number" name="viscosity" class="form-control" placeholder="1">
        </div>
        <div class="form-group">
            <label for="img">And let's have a look at you. up to 5mb, no funny business</label>
            <input type="file" class="form-control" name="img">
        </div>

        <button type="submit" class="btn-primary" name="submit">Submit</button>

    </form>

    <!-- Team Members Row -->
    <div class="row">
        <div class="col-lg-12">
            <h2 class="my-4">Our Donors</h2>
        </div>

        <?php foreach ($my_posts as $post): ?>
            <?php $post_image = get_image($link, $post['id']); ?>

            <!--            class="rounded-circle img-fluid d-block mx-auto"-->
            <div class="col-lg-4 col-sm-6 text-center mb-4">
                <?php echo '<img src="data:image/jpeg;base64,' . base64_encode($post_image[0]['image']) . '"/>'; ?>
                <h3><?php echo $post['ben_name']; ?>
                    <small>Viscosity: <?php echo $post['Viscosity']; ?></small>
                </h3>
                <p><?php echo $post['content']; ?></p>
            </div>
        <?php endforeach; ?>


    </div>

</div>

<!-- /.container -->

<!-- Footer -->
<footer class="py-5 bg-dark">
    <div class="container">
        <p class="m-0 text-center text-white">Banim &copy; 2018</p>
    </div>
    <!-- /.container -->
</footer>

<!-- Bootstrap core JavaScript -->
<script
        src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
        integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
        crossorigin="anonymous"></script>

</body>

</html>
