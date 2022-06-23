<?php
session_start();
require_once "Config/config.php";
if (empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
    header('Location: ./userInclude/user_login.php');
}
$statement = $pdo->prepare("SELECT * FROM posts WHERE id=" . $_GET['id']);
$statement->execute();
$posts = $statement->fetchAll();
$postId = $_GET['id'];
$commentstatement = $pdo->prepare("SELECT * FROM comments WHERE post_id=$postId");
$commentstatement->execute();
$cmResult = $commentstatement->fetchAll();
$auResult = [];
if ($cmResult) {
    foreach ($cmResult as $key => $value) {
        $auId = $cmResult[$key]['author_id'];
        $statementau = $pdo->prepare("SELECT * FROM users WHERE id=$auId");
        $statementau->execute();
        $auResult = $statementau->fetchAll();
    }
}

if ($_POST) {
    $comment = $_POST['comment'];
    $sql = $pdo->prepare("INSERT INTO comments(content,author_id,post_id) VALUES (:content,:author_id,:post_id)");
    $result = $sql->execute(
        array(
            ':content' => $comment, ':author_id' => $_SESSION['user_id'], ':post_id' => $postId
        )
    );
    if ($result) {
        header('Location: blogDetail.php?id=' . $postId);
    }
}
?>
<?php require_once "./userInclude/user_header.php" ?>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Content Wrapper. Contains page content -->
        <div class="">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="row">
                    <div class="col-md-12">
                        <!-- Box Comment -->
                        <div class="card card-widget">
                            <div class="card-header">
                                <a href="index.php" style="float:right !important;"><button class="btn btn-secondary">Back</button></a>
                                <div class="card-title" style="float:none !important;">
                                    <h1 style="text-align: center !important;"><?php echo $posts[0]['title'] ?></h1>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <img class="img-fluid pad" src="images/<?php echo $posts[0]['image'] ?>">
                                <p><?php echo $posts[0]['content'] ?></p>
                                <h3>Comments</h3>
                                <hr>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer card-comments">
                                <?php if ($cmResult) { ?>
                                    <div class="card-comment">
                                        <div class="comment-text" style="margin-left: 0px !important;">
                                            <span class="username">
                                                <?php echo $auResult[0]['name'] ?>
                                                <span class="text-muted float-right"><?php echo $cmResult[0]['created_at'] ?></span>
                                            </span><!-- /.username -->
                                            <?php echo $cmResult[0]['content'] ?>
                                        </div>
                                        <!-- /.comment-text -->
                                    </div>
                                <?php } ?>
                            </div>
                            <!-- /.card-footer -->
                            <div class="card-footer">
                                <form action="" method="post">
                                    <div class="img-push">
                                        <input name="comment" type="text" class="form-control form-control-sm" placeholder="Press enter to post comment">
                                    </div>
                                </form>
                            </div>
                            <!-- /.card-footer -->
                        </div>
                        <!-- /.card -->
                    </div>

                    <!-- /.col -->
                </div>
            </section>

            <!-- Main content -->

            <!-- /.content -->
            <?php require_once "./userInclude/user_footer.php" ?>