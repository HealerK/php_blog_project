<?php
require_once "../Config/config.php";
$sql = $pdo->prepare("DELETE FROM posts WHERE id=".$_GET['id']);
$sql->execute();

header('Location: index.php');
?>