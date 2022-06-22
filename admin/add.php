<?php
session_start();
require_once "../Config/config.php";
if (empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
    header('Location: login.php');
}

if (isset($_POST['submit'])) {
    $imageName = $_FILES['image']['name'];
    $file = "../images/" . $imageName;
    $Imagetype = pathinfo($file, PATHINFO_EXTENSION);

    if ($Imagetype != "png" && $Imagetype != "jpg" && $Imagetype != "jpeg") {
        echo "<script>alert('Your image must be png,jpg or jpeg.');</script>";
    } else {
        $title = $_POST['title'];
        $content = $_POST['content'];
        move_uploaded_file($_FILES['image']['tmp_name'], $file);
        $sql = $pdo->prepare("INSERT INTO posts(title,content,image,author_id) VALUES (:title,:content,:image,:author_id)");
        $result = $sql->execute(
            array(
                ':title' => $title, ':content' => $content, ':image' => $imageName, ':author_id' => $_SESSION['user_id']
            )
        );
        if ($result) {
            echo "<script>alert('Successfully New Post Added!');window.location.href='index.php';</script>";
        }
    }
}

?>

<?php include_once "header.php" ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Create New Post</h1>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="" class="label-control">Title</label>
                            <input type="text" class="form-control" name="title" required>
                        </div>
                        <div class="form-group">
                            <label for="" class="label-control">Content</label>
                            <textarea name="content" id="" class="form-control" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="" class="label-control">Image</label>
                            <input type="file" class="form-control" name="image">
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-success" value="SUBMIT" name="submit">
                            <a href="index.php" class="btn btn-info" type="button">Back</a>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
</div>
<!-- /.content-wrapper -->
<?php include_once "footer.php" ?>