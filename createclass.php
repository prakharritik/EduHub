<?php // Do not put any HTML above this line
session_start();
require_once "pdo.php";
if(!isset($_SESSION['id']) || $_SESSION['role']!=1)
	header("location: logout.php");
if ( isset($_POST['class']) ) {
    if ( strlen($_POST['class']) < 1) {
        $_SESSION['error'] = "All fields are required";
        header("Location: dash.php");
        return;
    }
$stmt = $pdo->prepare('INSERT INTO class (classname, tid) VALUES (  :fn, :ln)');

        $stmt->execute(array(
                ':fn' => $_POST['class'],
                ':ln' => $_SESSION['id'])
        );
    $_SESSION['success'] = "Successfully created.";
 header('location: allclass.php');
 return;
}