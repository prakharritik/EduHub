<?php
  session_start();
  require_once "pdo.php";
  if(!isset($_SESSION['id']))
  header('location: index.php?register=1');

if ( isset($_POST['message']) && isset($_GET['class']) ) {
    if ( strlen($_POST['message']) < 1 ) {
        $_SESSION['error'] = "All fields are required";
        header("Location: sendreq.php");
        return;
    }else { 
      if(!is_numeric($_GET['class'])){
        $_SESSION['error'] = "Invalid";
        header("Location: sendreq.php");
        return;
      }

  $stmt = $pdo->prepare('SELECT * FROM class where id = :prof ');
    $stmt->execute(array(":prof" => $_GET['class']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
  if($row===false){
    $_SESSION['success'] = "Wrong Credentials";
        header("Location: sendreq.php");
        return;
  }

  $stmt = $pdo->prepare('INSERT INTO request (message ,cid ,  uid,date) VALUES (  :fn, :ln, :em, :mn)');

        $stmt->execute(array(
                ':fn' => $_POST['message'],
                ':ln' => $_GET['class'],
                ':em' => $_SESSION['id'],
                ':mn' =>date("Y-m-d"))
        );        
      
        $_SESSION['success'] = "Successfully sent.";
        header("Location: sendreq.php");
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
      .member-card {
  padding: 30px;
  background-color: #393e46;
  color: white;
  transition: all 0.2s ease-in-out;
  -webkit-box-shadow: 0 15px 30px -15px rgba(0, 0, 0, 0.7);
  -moz-box-shadow: 0 15px 30px -15px rgba(0, 0, 0, 0.7);
  -ms-box-shadow: 0 15px 30px -15px rgba(0, 0, 0, 0.7);
  box-shadow: 0 15px 30px -15px rgba(0, 0, 0, 0.7);
  display: flex;
  align-items: center;
  letter-spacing: 2px;
  margin: 10px;
}
.member-card img {
  width: 64px;
  height: 64px;
}
.member-card .member-card-details {
  flex-grow: 1;
  margin-left: 20px;
}
.member-card .member-card-details .member-position {
  opacity: 0.7;
  font-size: 14px;
  text-transform: uppercase;
}
.member-card .member-card-details .member-name {
  color: white;
  font-size: 18px;
  margin-bottom: 10px;
}

.member-card .btn-fired:hover {
  color: red;
  cursor: pointer;
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
      <div class="position-sticky pt-3">
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="dash.php">
              <span data-feather="home"></span>
              Dashboard
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="#">
              <span data-feather="file"></span>
              Your Classes
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
      <form method="post">
        <textarea rows="4" name="message" class="form-control mt-5" placeholder="Write a few words."></textarea>
        <input type="submit" class="btn btn-primary mt-2 d-block m-auto">
      </form>
    </main>
  </div>
</div>


    <script src="../assets/dist/js/bootstrap.bundle.min.js"></script>

      <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script><script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script><script src="dashboard.js"></script>
  </body>
</html>
