<?php
session_start();
require_once "../Config/config.php";
if (empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
    header('Location: login.php');
}
$statement = $pdo->prepare("SELECT * FROM posts WHERE id=" . $_GET['id']);
$statement->execute();
$posts = $statement->fetchAll();

if (isset($_POST['submit'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $id = $_POST['id'];
    if($_FILES['image']['name']!=null){
    $imageName = $_FILES['image']['name'];
    $file = "../images/" . $imageName;
    $Imagetype = pathinfo($file, PATHINFO_EXTENSION);

    if ($Imagetype != "png" && $Imagetype != "jpg" && $Imagetype != "jpeg") {
        echo "<script>alert('Your image must be png,jpg or jpeg.');</script>";
    } else {
        move_uploaded_file($_FILES['image']['tmp_name'], $file);
        $sql = $pdo->prepare("UPDATE posts SET title='$title',content='$content',image='$imageName' WHERE id='$id'");
        $result = $sql->execute();
        if ($result) {
            echo "<script>alert('Successfully Post Updated!');window.location.href='index.php';</script>";
        }
    }
    }else {
        $sql = $pdo->prepare("UPDATE posts SET title='$title',content='$content' WHERE id='$id'");
        $update = $sql->execute();
        if ($update) {
            echo "<script>alert('Successfully Post Updated!');window.location.href='index.php';</script>";
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
                    <h1 class="m-0">Edit Post</h1>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <?php

                    foreach ($posts as $value) {
                    ?>
                        <form action="" method="post" enctype="multipart/form-data">

                            <div class="form-group">
                                <input type="hidden" name="id" value="<?php echo $value['id'] ?>">
                                <label for="" class="label-control">Title</label>
                                <input type="text" class="form-control" name="title" value="<?php echo $value['title'] ?>">
                            </div>
                            <div class="form-group">
                                <label for="" class="label-control">Content</label>
                                <textarea name="content" id="" class="form-control" required><?php echo $value['content'] ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="" class="label-control">Image</label><br>
                                <img src="../images/<?php echo $value['image'] ?>" class="mb-2" alt="" width="150px">
                                <input type="file" class="form-control" name="image">
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-success" value="SUBMIT" name="submit">
                                <a href="index.php" class="btn btn-info" type="button">Back</a>
                            </div>
                        </form>
                    <?php }

                    ?>

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