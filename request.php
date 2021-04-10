<?php
  session_start();
  require_once "pdo.php";
 if(!isset($_SESSION['id']))
  header('location: logout.php');
if(!isset($_SESSION['cid']))header('location: allclass.php');
if($_SESSION['role']==0)header('location: allclass.php');
$cid=$_SESSION['cid'];
$stmt = $pdo->prepare('SELECT * FROM class where id = :prof ');
    $stmt->execute(array(":prof" => $cid));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if($row===false)header('location: allclass.php');

$stmt = $pdo->prepare('SELECT name,email,message,date,uid FROM request r join users u on u.id=r.uid where cid = :prof ');
$stmt->execute(array(":prof" => $cid));
$requests = $stmt->fetchAll(PDO::FETCH_ASSOC);


if ( isset($_POST['add']) &&  isset($_POST['uid'])){
 if(!is_numeric($_POST['uid'])) {
        $_SESSION['error'] = "Something went wrong";
        header("Location: request.php");
        return;
    }
    else {
      
      $stmt = $pdo->prepare('INSERT INTO class_student (uid,cid) VALUES (  :fn,:gn)');
      $stmt->execute(array(
                ':fn' => $_POST['uid'],
                ':gn' => $cid)
        );
      $stmt = $pdo->prepare('Delete from request  where uid=:fn and cid=:gn');
      $stmt->execute(array(
                ':fn' => $_POST['uid'],
                ':gn' => $cid)
        );
    $_SESSION['success'] = "Successfully Added.";
 header('location: request.php');
 return;
    }
}

if ( isset($_POST['delete']) &&  isset($_POST['uid'])){

      $stmt = $pdo->prepare('Delete from request  where uid=:fn and cid=:gn');
      $stmt->execute(array(
                ':fn' => $_POST['uid'],
                ':gn' => $cid)
        );
    $_SESSION['success'] = "Successfully Deleted.";
 header('location: request.php');
 return;
    
}
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.82.0">
    <title>Dashboard Template · Bootstrap v5.0</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

    <style>
     #confirm, #delete{
  background-color:#4267B2;
  color:white;
  padding:7px;
  border-radius:2px;
  margin-right:10px;
  font-family:sans-serif;
}

#delete{
  color:#222;
  background-color:#bbb;
  border:1px solid #999;
  padding:6px;
  margin-right:0;
}
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }


    </style>

    
    <!-- Custom styles for this template -->
    <link href="dashboard.css" rel="stylesheet">
  </head>
  <body>
    
<header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
  <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="#">Company name</a>
  <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
</header>

<div class="container-fluid">
  <div class="row">
    <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
      <div class="position-sticky pt-5">
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link" href="class.php">
              <span data-feather="layers"></span>
              Back
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="logout.php">
              <span data-feather="layers"></span>
              Logout
            </a>
          </li>
        </ul>
      </div>
    </nav>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2"><?php echo $row['classname']; ?></h1>
      </div>
      <?php
if(isset($_SESSION['success'])){
  echo '<div class="alert alert-success" role="alert">'.$_SESSION['success'].'</div>';
  unset($_SESSION['success']);
}
if(isset($_SESSION['error'])){
  echo '<div class="alert alert-danger" role="alert">'.$_SESSION['error'].'</div>';
  unset($_SESSION['error']);
}
?>
      
      
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h3 class="h5">Requests</h3>
      </div>
        <?php
        if(sizeof($requests)==0)echo '<span class="text-center">No Requests</span>';
        else{
          foreach ($requests as $key) {
          echo '<div class="row">
          <div class="col-12 col-md-8 col-lg-8">
            <h3>'.$key['name'].'</h3>
            <span class="">'.$key['date'].'</span><br>
            <span class="txt w-2/3 sm:w-full  text-sm text-indigo-lightest">'.$key['message'].'</span>
          </div>
          <div class="col-12 col-lg-4 col-md-4">
            <form method="post">
            <input type="hidden" name="uid" value="'.$key['uid'].'">
                  <button type="submit" name="add" id="confirm">Confirm</button>
                  <button  type="submit" name="delete" id="delete">Delete Request</button>
            </form>
          </div>
        </div>';
      }
        }
        
      ?>
      
      
     
    </main>
  </div>
</div>


    <script src="../assets/dist/js/bootstrap.bundle.min.js"></script>

      <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script><script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script><script src="dashboard.js"></script>
  </body>
</html>
