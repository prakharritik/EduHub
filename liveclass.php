<?php
  session_start();
  require_once "pdo.php";
 if(!isset($_SESSION['id']))
  header('location: logout.php');
date_default_timezone_set('Asia/Kolkata');
if(!isset($_SESSION['cid']))header('location: allclass.php');
$cid=$_SESSION['cid'];
$stmt = $pdo->prepare('SELECT * FROM class where id = :prof ');
    $stmt->execute(array(":prof" => $cid));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if($row===false)header('location: allclass.php');

$stmt = $pdo->prepare('SELECT * FROM live where cid = :prof ');
    $stmt->execute(array(":prof" => $cid));
$classes = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ( isset($_POST['topic']) && isset($_POST['date']) && isset($_POST['time']) ) {
    if ( strlen($_POST['topic']) < 1 ) {
        $_SESSION['error'] = "All fields are required";
        header("Location: liveclass.php");
        return;
    }
    else if($_POST['date']<date("Y-m-d")){
        $_SESSION['error'] = "Invalid Date";
        header("Location: liveclass.php");
        return;
    }
    else if($_POST['date']===date("Y-m-d") && $_POST['stime']<date("H:i:s")){
        $_SESSION['error'] = "Invalid Time";
        header("Location: liveclass.php");
        return;
    }
    else if($_POST['stime']>$_POST['etime']){
        $_SESSION['error'] = "Invalid Time";
        header("Location: liveclass.php");
        return;
    }
    else {
      $link='https://meet.jit.si/'.base64_encode('eduhub_'.$cid.'_'.$_POST['topic']);
      $stmt = $pdo->prepare('INSERT INTO live (topic,date,time,link, cid) VALUES (  :fn, :ln,:gn,:mn,:an)');
      $stmt->execute(array(
                ':fn' => $_POST['topic'],
                ':ln' => $_POST['date'],
                ':gn' => $_POST['time'],
                ':mn' => $link,
                ':an' => $cid)
        );
    $_SESSION['success'] = "Successfully created.";
 header('location: liveclass.php');
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
     th,td{
      width: 100px;
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
  <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="index.php">
    <img src="logo.svg" style="width: 200px;height: 50px;">
  </a>
  <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
</header>

<div class="container-fluid">
  <div class="row">
    <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
      <div class="position-sticky pt-5 ">
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link " aria-current="page" href="class.php">
              <span data-feather="home"></span>
              Class home
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="liveclass.php">
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
        if($_SESSION['role']==1)
          echo '
        <form method="post">      
          <div class="mb-3">
            <input type="text" name="topic" class="form-control" placeholder="Topic">
          </div>
          <div class="mb-3">
            <label for="recipient-name" class="col-form-label">Date:</label>
            <input type="date" name="date" class="form-control" min="'.date("Y-m-d").'">
          </div>
          <div class="mb-3">
            <label for="recipient-name" class="col-form-label">Start Time:</label>
            <input type="time" name="stime" class="form-control">
          </div>
          <div class="mb-3">
            <label for="recipient-name" class="col-form-label">End time:</label>
            <input type="time" name="etime" class="form-control">
          </div>
          <button type="submit" class="btn btn-primary m-auto d-block">Create Live Class</button>
        </form>';
      ?>

  
  

      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Current</h1>
      </div>
<table><thead>
    <tr>
      <th scope="col">Date</th>
      <th scope="col">Topic</th>
      <th scope="col">Start Time</th>
      <th scope="col">End Time</th>
      <th scope="col">Join</th>
    </tr>
  </thead><tbody>
      <?php
          foreach ($classes as $key) {
            if($key['date']==date('Y-m-d') && $key['start_time']<=date('H:i:s') && $key['end_time']>=date('H:i:s'))echo '
    <tr>
      <th scope="row">1</th>
      <td>'.$key['topic'].'</td>
      <td>'.$key['start_time'].'</td>
      <td>'.$key['end_time'].'</td><td><a href="'.$key['link'].'">join</a></td>
    </tr>
    
  ';
          }
      ?></tbody></table>
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Upcoming</h1>
      </div><table><thead>
    <tr>
      <th scope="col">Date</th>
      <th scope="col">Topic</th>
      <th scope="col">Start Time</th>
      <th scope="col">End Time</th>
      <th scope="col">Join</th>
    </tr>
  </thead><tbody>
      <?php
          foreach ($classes as $key) {
            if($key['date']>=date('Y-m-d') && $key['start_time']>=date('H:i:s'))echo '
    <tr>
      <th scope="row">1</th>
      <td>'.$key['topic'].'</td>
      <td>'.$key['start_time'].'</td>
      <td>'.$key['end_time'].'</td><td><a href="'.$key['link'].'">join</a></td>
    </tr>
    
  ';
          }
      ?></tbody></table>
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Past</h1>
      </div><table><thead>
    <tr>
      <th scope="col">Date</th>
      <th scope="col">Topic</th>
      <th scope="col">Start Time</th>
      <th scope="col">End Time</th>
      <th scope="col">Join</th>
    </tr>
  </thead><tbody>
      <?php

          foreach ($classes as $key) {
            if(($key['date']<date('Y-m-d') )|| ($key['date']==date('Y-m-d') && $key['end_time']<=date('H:i:s')))echo '
    <tr>
      <th scope="row">1</th>
      <td>'.$key['topic'].'</td>
      <td>'.$key['start_time'].'</td>
      <td>'.$key['end_time'].'</td><td><a href="'.$key['link'].'">join</a></td>
    </tr>
    
  ';
          }
      ?></tbody></table>
    </main>
  </div>
</div>


    <script src="../assets/dist/js/bootstrap.bundle.min.js"></script>

      <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script><script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script><script src="dashboard.js"></script>
  </body>
</html>
