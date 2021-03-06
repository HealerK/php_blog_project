<?php
session_start();
require_once "../Config/config.php";
if (empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
  header('Location: login.php');
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
          <h1 class="m-0">Dashboard</h1>
        </div>
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->
  <?php

  if (!empty($_GET['pageno'])) {
     $pageno = $_GET['pageno'];
  } else {
     $pageno = 1;
  }
  $pageRecord = 1;
  $offSet = ($pageno - 1) * $pageRecord;


  if (empty($_POST['search'])) {
    $stmt = $pdo->prepare("SELECT * FROM posts ORDER BY id DESC");
    $stmt->execute();
    $rawResult = $stmt->fetchAll();
    $total_pages = ceil(count($rawResult) / $pageRecord);

    $stmt = $pdo->prepare("SELECT * FROM posts ORDER BY id DESC LIMIT $offSet,$pageRecord");
    $stmt->execute();
    $result = $stmt->fetchAll();
  } else {
    $searchKey = $_POST['search'];
    $stmt = $pdo->prepare("SELECT * FROM posts WHERE title LIKE '%$searchKey%' ORDER BY id DESC");
    $stmt->execute();
    $rawResult = $stmt->fetchAll();
    $total_pages = ceil(count($rawResult) / $pageRecord);

    $stmt = $pdo->prepare("SELECT * FROM posts WHERE title LIKE '%$searchKey%' ORDER BY id DESC LIMIT $offSet,$pageRecord");
    $stmt->execute();
    $result = $stmt->fetchAll();
  }

  ?>
  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Admin Control Table</h3>
            </div>

            <div class="card-body">
              <div class="mb-3">
                <a href="add.php" class="btn btn-success" type="button">Create New</a>
              </div>
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th style="width: 10px">ID</th>
                    <th>Title</th>
                    <th>Content</th>
                    <th style="width: 40px">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php

                  if ($result) {
                    $i = 1;
                    foreach ($result as $value) { ?>
                      <tr>
                        <td><?php echo $i ?></td>
                        <td><?php echo $value['title'] ?></td>
                        <td><?php echo substr($value['content'], 0, 50) ?></td>
                        <td>
                          <div class="btn-group">
                            <div class="container">
                              <a href="edit.php?id=<?php echo $value['id'] ?>" class="btn btn-warning" type="button">Edit</a>
                            </div>
                            <div class="container">
                              <a href="delete.php?id=<?php echo $value['id'] ?>" onclick="return confirm('Are you sure delete this item?')" class="btn btn-danger" type="button">Delete</a>
                            </div>
                          </div>
                        </td>
                      </tr>
                  <?php
                      $i++;
                    }
                  }
                  ?>
                </tbody>
              </table>
              <nav aria-label="Page navigation example" class="mt-3" style="float:right">
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
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php include_once "footer.php" ?>