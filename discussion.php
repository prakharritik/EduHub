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

$stmt = $pdo->prepare('SELECT message,name,uid,time FROM discuss d join users u on d.uid=u.id where cid = :prof ');
    $stmt->execute(array(":prof" => $cid));
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ( isset($_POST['message'])  ) {
    if ( strlen($_POST['message']) < 1 ) {

    }
    
    else {
      
      $stmt = $pdo->prepare('INSERT INTO discuss (message,uid, cid,time) VALUES (  :fn, :gn,:an,:mn)');
      $stmt->execute(array(
                ':fn' => $_POST['message'],
                ':gn' => $_SESSION['id'],
                ':an' => $cid,
                ':mn' =>date("Y-m-d H:i:s"))
        );
      header('location: discussion.php');
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
     .a{
  border-radius:30px;color:black;padding-left:2%; background-color: #8ae9b3;
background-image: linear-gradient(315deg, #8ae9b3 0%, #c8d6e5 74%);width:50%;margin-left:40%;
border-top-right-radius:0px;
}
.b{
  border-radius:30px;color:black;padding-left:2%;background-color: moccasin;width:50%;
border-top-left-radius:0px;margin-left: 5%;
}
  @media (max-width: 767px) {
    .a,.b{
      margin-left: 0px;
      width: 100%;
    }
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
  <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="#">
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
            <a class="nav-link active" href="discussion.php">
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
          foreach ($messages as $key) {
            if($key['uid']==$_SESSION['id']){
                     echo "<div class='a' class='mr-5'><h6 style='color:black;font-weight:bold;display:inline;'>You</h6>&nbsp;&nbsp;&nbsp;&nbsp; ".$key['time']."<p style='margin-left:10%;font-size:20px;'>".$key['message']."</p></div>";}
                    else{
                      echo "<div class='b' style='' class='ml-5 mr-5'><h6 style='color:black;display:inline;'>".$key['name']."</h6>&nbsp;&nbsp;&nbsp;&nbsp;".$key['time']."<p style='margin-left:10%;font-size:20px;'>".$key['message']."</p></div>";
                    }
          }
      ?>  
      <div style="bottom: 20px;right: 0px;">
                       <form method="POST" id="fo">
                        
                                 <textarea id="subject" name="message" class="form-control mt-4" style="width:100%;background-color: #8ae9b3;
background-image: linear-gradient(315deg, #8ae9b3 0%, #c8d6e5 74%);" rows="3" placeholder="Write a message"></textarea>
<input type="submit"  class="btn btn-primary mb-5" style="display: block;margin: auto;" >
            </form>
                  </div>
    </main>
  </div>
</div>


    <script src="../assets/dist/js/bootstrap.bundle.min.js"></script>

      <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script><script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script><script src="dashboard.js"></script>
  </body>
</html>