<?php
  session_start();
  require_once "pdo.php";
 if(!isset($_SESSION['id']))
  header('location: logout.php');


if(!isset($_SESSION['cid']))header('location: allclass.php');
$cid=$_SESSION['cid'];


  

$stmt = $pdo->prepare('SELECT * FROM class where id = :prof ');
    $stmt->execute(array(":prof" => $cid));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if($row===false)header('location: allclass.php');

$stmt = $pdo->prepare('SELECT * FROM noti where cid = :prof ');
    $stmt->execute(array(":prof" => $cid));
$notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ( isset($_POST['message']) ){
 if(strlen($_POST['message']) < 1) {
        $_SESSION['error'] = "All fields are required";
        header("Location: class.php");
        return;
    }
    else {
      $stmt = $pdo->prepare('INSERT INTO noti (noti,cid,date) VALUES (  :fn,:gn,:mn)');
      $stmt->execute(array(
                ':fn' => $_POST['message'],
                ':gn' => $cid,
                ':mn' =>date("Y-m-d H:i:s"))
        );
    $_SESSION['success'] = "Successfully created.";
 header('location: class.php');
 return;
    }
}

if ( isset($_POST['addstu']) &&  isset($_POST['email'])){
 if(strlen($_POST['email']) < 1) {
        $_SESSION['error'] = "All fields are required";
        header("Location: class.php");
        return;
    }
    else if (strpos($_POST['email'], "@") === false) {
        $_SESSION['error'] = "Email must have an at-sign (@)";
        header("Location: class.php");
        return;
    }
    else {
      $stmt = $pdo->prepare('SELECT id,name FROM users where email = :prof ');
    $stmt->execute(array(":prof" => $_POST['email']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if($row===false){
  $_SESSION['error'] = "Student has not got registered at EduHub.";
  header('location: class.php');
}
      $stmt = $pdo->prepare('INSERT INTO class_student (uid,cid) VALUES (  :fn,:gn)');
      $stmt->execute(array(
                ':fn' => $row['id'],
                ':gn' => $cid)
        );
    $_SESSION['success'] = $row['name']." has been Successfully Added.";
 header('location: class.php');
 return;
    }
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
    <title>EduHub</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

    <style>
     
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
<a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="index.php">
    <img src="logo.svg" style="width: 200px;height: 50px;">
  </a>  <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
</header>

<div class="container-fluid">
  <div class="row">
    <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
      <div class="position-sticky pt-5">
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="class.php">
              <span data-feather="home"></span>
              Class home
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link " href="liveclass.php">
              <span data-feather="video"></span>
              Live Classes
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link " href="assignment.php">
              <span data-feather="edit"></span>
              Assignments
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link " href="content.php">
              <span data-feather="book-open"></span>
              Study Material
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link " href="discussion.php">
              <span data-feather="book-open"></span>
              Discussion
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link " href="test.php">
              <span data-feather="file"></span>
              Test
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="allclass.php">
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
      
      <?php
        if($_SESSION['role']==1){
          echo '
<p class="text-center">If you want people to send request to join your class share <a href="sendreq.php?class='.$cid.'">this</a> link. </p>
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h3 class="h5">Create Notification</h1>
      </div>
        <form method="post">      
          <div class="mb-3">
            <input type="text" name="message" class="form-control" placeholder="Message">
          </div>
          <button type="submit" class="btn btn-primary m-auto d-block">Create Notification</button>
        </form>';
        echo '<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h3 class="h5">Add Students</h1>
      </div>
        <a href="request.php"><button class="btn btn-primary m-auto d-block mb-5">Student Requests</button></a>
        <form method="post">      
          <div class="mb-3">
            <input type="text" name="email" class="form-control" placeholder="Student Email">
          </div>
          <button type="submit" name="addstu" class="btn btn-primary m-auto d-block">Add Student</button>
        </form>';
}

      ?>
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h3 class="h5">Notifications</h1>
      </div>
        <?php
        if(sizeof($notifications)==0)echo '<span class="text-center">No notification</span>';
        else{
          foreach ($notifications as $key) {
          echo '<div class="content mx-auto">
          <div class="news mx-auto rounded-full bg-indigo-darker w-full flex items-center">
            <span class=" tracking-wide text-xs w-auto m-2 inline-block rounded-full py-1 px-2">'.$key['date'].'</span>
            <span class="txt w-2/3 sm:w-full  text-sm text-indigo-lightest">'.$key['noti'].'</span>
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
