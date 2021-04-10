<?php
session_start();
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>EduHub</title>

    

    
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <!-- Bootstrap core CSS -->
<link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">

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
    <link href="carousel.css" rel="stylesheet">
  </head>
  <body>
    
<header>
  <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <div class="container-fluid">
<a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="index.php">
    <img src="logo.svg" style="width: 200px;height: 50px;">
  </a>      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav me-auto mb-2 mb-md-0 d-flex">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Home</a>
          </li>
          <?php
          if(isset($_SESSION['id'])){
            echo '<li class="nav-item">
            <a class="nav-link active" href="dash.php">Dashboard</a>
          </li><li class="nav-item">
            <a class="nav-link active" href="logout.php">Logout</a>
          </li>';
          }
          else echo '<li class="nav-item">
            <a class="nav-link active" data-bs-toggle="modal" data-bs-target="#loginModal">Login</a>
          </li>';
          ?>       
        </ul>
      </div>
    </div>
  </nav>
</header>
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
<main>

  <div id="myCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
      <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
      <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
      <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="https://images.unsplash.com/photo-1495446815901-a7297e633e8d?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=1050&q=80">

        <div class="container">
          <div class="carousel-caption text-start">
            <h1>Free Education for all</h1>
            <p>We try our best to provide free and quality education to learners</p>
                      </div>
        </div>
      </div>
      <div class="carousel-item">
        <img src="https://images.unsplash.com/photo-1584697964358-3e14ca57658b?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80">

        <div class="container">
          <div class="carousel-caption">
            <h1>New Way to learn</h1>
            <p>Now learn with experiencing things in the virtual world</p>
                   </div>
        </div>
      </div>
      <div class="carousel-item">
        <img src="https://images.unsplash.com/photo-1434030216411-0b793f4b4173?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80">

        <div class="container">
          <div class="carousel-caption text-end text-dark">
            <h1>Learn from anywhere anytime from live digital classes</h1>
            <p></p>
            
          </div>
        </div>
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>

  <!-- Marketing messaging and featurettes
  ================================================== -->
  <!-- Wrap the rest of the page in another container to center all the content. -->

<div class="container marketing">

    <!-- Three columns of text below the carousel -->
    <div class="row">
      <div class="col-lg-4">
        <img class="bd-placeholder-img rounded-circle" width="200" height="200" src="https://images.unsplash.com/photo-1486312338219-ce68d2c6f44d?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=1052&q=80">

        <h2>Digital Classrooms</h2>
        <p>Online classes, Discussion Forum and Monitor Students Activities</p>
        <p><a class="btn btn-secondary" href="dash.php">View details &raquo;</a></p>
      </div><!-- /.col-lg-4 -->
      <div class="col-lg-4">
        <img class="bd-placeholder-img rounded-circle" width="200" height="200" src="https://images.unsplash.com/photo-1576633587382-13ddf37b1fc1?ixlib=rb-1.2.1&ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&auto=format&fit=crop&w=1052&q=80">

        <h2>AR/VR Tools</h2>
        <p>Find yourself in the Virtual World of History and Astronomy</p>
        <p><a class="btn btn-secondary" href="vr.html">View details &raquo;</a></p>
      </div><!-- /.col-lg-4 -->
      <div class="col-lg-4">
        <img class="bd-placeholder-img rounded-circle" width="200" height="200" src="https://images.unsplash.com/photo-1457369804613-52c61a468e7d?ixlib=rb-1.2.1&ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&auto=format&fit=crop&w=1050&q=80">

        <h2>Free Content</h2>
        <p>Contents to read to grow up your Knowledge</p>
        <p><a class="btn btn-secondary" href="facts.html">View details &raquo;</a></p>
      </div><!-- /.col-lg-4 -->
    </div><!-- /.row -->


    <!-- START THE FEATURETTES -->

    <hr class="featurette-divider">

    <div class="row featurette">
      <div class="col-md-7">
        <h2 class="featurette-heading">Digital <span class="text-muted">Classroom </span></h2>
        <p class="lead">Exciting features to enhance interest in E-Learning with quizes. Also Exams can be conducted online with least difficulty and problems can be discussed in Discussion Forum.</p>
      </div>
      <div class="col-md-5">
        <img src="./images/class.jpg" style="height: 90%; width: 90%;   border: 5px solid rgb(0, 0, 0);">

      </div>
    </div>

    <hr class="featurette-divider">

    <div class="row featurette">
      <div class="col-md-7 order-md-2">
        <h2 class="featurette-heading">VR/AR <span class="text-muted">Tools</span></h2>
        <p class="lead">When Learning is through AR/VR, it becomes exciting, isn't it?   </p>
      </div>
      <div class="col-md-5 order-md-1">
        <img src="./images/vr.jpg" style="height: 120%; width: 100%;   border: 5px solid rgb(0, 0, 0);">

      </div>
    </div>

    <hr class="featurette-divider">

    <div class="row featurette">
      <div class="col-md-7">
        <h2 class="featurette-heading">Free <span class="text-muted">Content</span></h2>
        <p class="lead">Loads of Contents to solve doubts that too without a penny. </p>
      </div>
      <div class="col-md-5">
        <img src="./images/learn.jpg" style="height: 110%; width: 100%;  border: 5px solid rgb(0, 0, 0);"> 

      </div>
    </div>

    <hr class="featurette-divider">

    <!-- /END THE FEATURETTES -->

  </div><!-- /.container -->


  <!-- FOOTER -->
  <footer class="container">
    <p class="float-end"><a href="#">Back to top</a></p>
    <p>&copy; 2017–2021 Company, Inc. &middot; <a href="#">Privacy</a> &middot; <a href="#">Terms</a></p>
  </footer>
</main>


    <script src="../assets/dist/js/bootstrap.bundle.min.js"></script>

<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Login</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="login.php" method="post">
      <div class="modal-body">
        <img src="login.svg" style="width: 80%;margin:auto;display: block;">
        
          <div class="mb-3">
            <label for="recipient-name" class="col-form-label">E-mail:</label>
            <input type="text" name="email" class="form-control" id="recipient-name">
          </div>
          <div class="mb-3">
            <label for="recipient-name" class="col-form-label">Password:</label>
            <input type="Password" name="pass" class="form-control" id="recipient-name">
          </div>
        
      </div>
      <div class="modal-footer">
        <a type="button" class="btn btn-primary"  data-bs-toggle="modal" data-bs-target="#registerModal" data-bs-dismiss="modal">Signup</a>
        <button type="submit" class="btn btn-primary">Login</button>
      </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">

    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Register</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="register.php" method="post">
      <div class="modal-body">
        <img src="register.svg" style="width: 60%;margin:auto;display: block;">
        
          <div class="mb-3">
            <label for="recipient-name" class="col-form-label">E-mail:</label>
            <input type="text" name="email" class="form-control" id="recipient-name">
          </div>
          <div class="mb-3">
            <label for="recipient-name" class="col-form-label">Name:</label>
            <input type="text" name="name" class="form-control" id="recipient-name">
          </div>
          <div class="mb-3">
            <label for="recipient-name" class="col-form-label">Password:</label>
            <input type="Password" name="pass" class="form-control" id="recipient-name">
          </div>
          <div class="mb-3">
            <label for="recipient-name" class="col-form-label">Role:</label>
            <input type="radio" id="student" name="role" value="0"><label for="student">Student</label>
            <input type="radio" id="teacher" name="role" value="1"><label for="teacher">Teacher</label>
          </div>

        <a type="button" class="btn btn-primary mr-auto"  data-bs-toggle="modal" data-bs-target="#loginModal" data-bs-dismiss="modal">Login</a>
        <button type="submit" class="btn btn-primary">Signup</button>
        
      </div> </form>
    </div>
  </div>
</div>
      
  </body>
</html>
