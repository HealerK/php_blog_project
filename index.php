<?php
session_start();
require_once "Config/config.php";
if (empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
    header('Location: ./userInclude/user_login.php');
}

if (!empty($_GET['pageno'])) {
    $pageno = $_GET['pageno'];
} else {
    $pageno = 1;
}
$pageRecord = 3;
$offSet = ($pageno - 1) * $pageRecord;

$stmt = $pdo->prepare("SELECT * FROM posts ORDER BY id DESC");
$stmt->execute();
$rawResult = $stmt->fetchAll();
$total_pages = ceil(count($rawResult) / $pageRecord);

$stmt = $pdo->prepare("SELECT * FROM posts ORDER BY id DESC LIMIT $offSet,$pageRecord");
$stmt->execute();
$result = $stmt->fetchAll();

?>

<?php include_once "./userInclude/user_header.php" ?>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Content Wrapper. Contains page content -->
        <div class="">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid mb-4">
                    <h1 class="text-center">Blog Page</h1>
                </div><!-- /.container-fluid -->
                <?php
                // $stmt = $pdo->prepare("SELECT * FROM posts ORDER BY id DESC");
                // $stmt->execute();
                // $posts = $stmt->fetchAll();
                // echo "<pre>" . print_r($posts) . "</pre>";
                ?>
                <div class="row">
                    <?php
                    if ($result) {
                        $i = 1;
                        foreach ($result as $value) { ?>
                            <div class="col-md-4">
                                <!-- Box Comment -->
                                <div class="card card-widget" style="cursor: pointer !important;">
                                    <div class="card-header">
                                        <div class="card-title" style="float:none;">
                                            <h5 style="text-align:center !important;"><?php echo $value['title'] ?></h5>
                                        </div>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <!-- <img class="img-fluid pad" src="dist/img/photo2.png" alt="Photo"> -->
                                        <a href="blogDetail.php?id=<?php echo $value['id'] ?>"><img class="img-fluid pad" src="images/<?php echo $value['image'] ?>"></a>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                <!-- /.card -->
                            </div>
                    <?php
                            $i++;
                        }
                    }
                    ?>
                    <nav aria-label="Page navigation example" class="mt-3" >
                        <ul class="pagination">
                            <li class="page-item">
                                <a class="page-link" href="?pageno=1">First</a>
                            </li>
                            <li class="page-item <?php if ($pageno <= 1) echo "disabled"; ?>">
                                <a class="page-link" href="<?php if ($pageno <= 1) {
                                                                echo '#';
                                                            } else {
                                                                echo '?pageno=' . ($pageno - 1);
                                                            } ?>">Previous</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href=""><?php echo $pageno; ?></a>
                            </li>
                            <li class="page-item <?php if ($pageno >= $total_pages) echo "disabled"; ?>">
                                <a class="page-link" href="<?php if ($pageno >= $total_pages) {
                                                                echo '#';
                                                            } else {
                                                                echo '?pageno=' . ($pageno + 1);
                                                            } ?>">Next</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="?pageno=<?php echo $total_pages ?>">Last</a>
                            </li>
                        </ul>
                    </nav>
            </section>

            <!-- Main content -->

            <!-- /.content -->

            <?php include_once "./userInclude/user_footer.php" ?>