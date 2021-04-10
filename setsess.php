<?php
session_start();
require_once "pdo.php";
  if(!isset($_SESSION['id']))
  header('location: logout.php');
if(!isset($_GET['cid']))header('location: allclass.php');
$cid=$_GET['cid'];
if(!is_numeric($cid))header('location: allclass.php');
$stmt = $pdo->prepare('SELECT * FROM class where id = :prof ');
    $stmt->execute(array(":prof" => $cid));
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
if(sizeof($rows)==0)header('location: allclass.php');
else {
	$_SESSION['cid']=$cid;
	header('location: class.php');
}
?>