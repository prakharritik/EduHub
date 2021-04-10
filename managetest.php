<?php
  session_start();
  require_once "pdo.php";
 if(!isset($_SESSION['id']))
  header('location: logout.php');
if($_SESSION['role']==0)header('location: allclass.php');
date_default_timezone_set('Asia/Kolkata');
if(!isset($_SESSION['cid']))header('location: allclass.php');
$cid=$_SESSION['cid'];
$stmt = $pdo->prepare('SELECT * FROM class where id = :prof ');
    $stmt->execute(array(":prof" => $cid));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if($row===false)header('location: allclass.php');

if(!isset($_GET['tid']))header('location: test.php');
$tid=$_GET['tid'];
if(!is_numeric($tid))header('location: test.php');
$stmt = $pdo->prepare('SELECT * FROM test where id = :prof and cid=:ci');
    $stmt->execute(array(
      ":prof" => $tid,
      ":ci"=>$cid
  ));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if($row===false)header('location: test.php');

function save_record_image($image,$name = null){
  $API_KEY = '7694dfa01b2beeb09d3f7271ec71dc33';
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, 'https://api.imgbb.com/1/upload?key='.$API_KEY);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_POST, 1);
  $extension = pathinfo($image['name'],PATHINFO_EXTENSION);
  $file_name = ($name)? $name.'.'.$extension : $image['name'] ;
  $data = array('image' => base64_encode(file_get_contents($image['tmp_name'])), 'name' => $file_name);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
  $result = curl_exec($ch);
  if (curl_errno($ch)) {
      return 'Error:' . curl_error($ch);
  }else{
    return json_decode($result, true);
  }
  curl_close($ch);
}

$stmt = $pdo->prepare('SELECT * FROM ques where tid = :prof ');
$stmt->execute(array(":prof" => $tid));
$questions = $stmt->fetchAll(PDO::FETCH_ASSOC);



for ($i = 1; $i <= 100; $i++) {

            if (!isset($_POST['q' . $i]) && !isset($_POST['option' . $i.'_6'])) continue;

            $o1 = $_POST['option' . $i.'_1'];
            $o2 = $_POST['option' . $i.'_2'];
            $o3 = $_POST['option' . $i.'_3'];
            $o4 = $_POST['option' . $i.'_4'];
            $o5 = $_POST['option' . $i.'_5'];
            if(!isset($_FILES['option' . $i.'_6'])){$o6="NULL";}
                else{     
                 $return =save_record_image($_FILES['option' . $i.'_6'],'test');         
$o6=$return['data']['url'];

            $stmt = $pdo->prepare('INSERT INTO ques (tid, ques, o1, o2, o3, o4, correct,file,cid)  VALUES ( :pid, :rank, :year, :dec,:ot,:of,:co,:fi,:gi,:gh)');

            $stmt->execute(array(
                    ':pid' => $id,
                    ':rank' => $_POST['q' . $i],
                    ':year' => $o1,
                    ':dec'=>$o2,
                    ':ot'=>$o3,
                    ':of'=>$o4,
                    ':co'=>$o5,
                    ':fi'=> $o6,
                    ':gi'=>$_SESSION['class'])
            );



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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

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
            <a class="nav-link" href="test.php">
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
        <h1 class="h2"><?php echo $row['title']; ?></h1>
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
            <input type="text" name="topic" class="form-control" placeholder="Topic" value='.$row['title'].'>
          </div>
          <div class="mb-3">
            <label for="recipient-name" class="col-form-label">Date:</label>
            <input type="date" name="date" class="form-control" min="'.date("Y-m-d").'" value='.$row['date'].'>
          </div>
          <div class="mb-3">
            <label for="recipient-name" class="col-form-label">Start Time:</label>
            <input type="time" name="stime" class="form-control" value='.$row['stime'].'>
          </div>
          <div class="mb-3">
            <label for="recipient-name" class="col-form-label">End time:</label>
            <input type="time" name="etime" class="form-control" value='.$row['etime'].'>
          </div>
        </form>';
      ?>
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Questions</h1>
      </div>
      <?php
          foreach ($questions as $key) {
            if($key['date']==date('Y-m-d') && $key['stime']<=date('H:i:s') && $key['etime']>=date('H:i:s'))echo '<a href="managetest.php?tid='.$key['id'].'">test</a>';
          }
      ?>


<form method="post" enctype="multipart/form-data">
 <input type="submit" class="btn btn-primary m-auto d-block" id="addEdu" value="Add Question" style="font-size: 20px;">
        <div id="edu_fields">
        </div>

</form>
    </main>
  </div>
</div>


        





    <script>

       
        $(document).ready(function () {

  countEdu = 0;

            $('#addEdu').click(function (event) {
                event.preventDefault();
                if (countEdu >= 100) {
                    alert("Maximum of  hundred question entries exceeded");
                    return;
                }
                countEdu++;
                window.console && console.log("Adding education " + countEdu);
                $('#edu_fields').append(
                    '<div id="edu' + countEdu + '"  class="mb-5 mt-5" style="outline: 4px dashed blue;"> \
            <p class="text-center display-4">Ques:<br> <input type="text" class="form-control" name="q' + countEdu + '" value="" placeholder="Enter question here" required/></p>\
            <button style="background-color:#111;" class="m-auto d-block" onclick="$(\'#edu'+countEdu +'\').remove();return false;"><i class="fa fa-trash-o" style="font-size:48px;color:red"></i></button>\
            <br><input type="text" class="form-control" name="option' + countEdu + '_1" value="" placeholder="Option 1" required/> \
            <br><input type="text" class="form-control" name="option' + countEdu + '_2" value="" placeholder="Option 2" required/> \
            <br><input type="text" class="form-control" name="option' + countEdu + '_3" value="" placeholder="Option 3" required/> \
            <br><input type="text" class="form-control" name="option' + countEdu + '_4" value="" placeholder="Option 4" required/> \
            <br><p class="text-center">Enter correct (1-4):<input type="number" style="width:50px;" class="form-control d-block m-auto" name="option' + countEdu + '_5" value="" min="1" max="4" required/> </p>\
            <p style="text-align:center;">Add Image(optional)</p><input type="file" id="img" name="option' + countEdu + '_6" accept="image/*" style="display:block;margin:auto;" >\
            </div>'
                );

 

            });

        });

    </script>

    <script src="../assets/dist/js/bootstrap.bundle.min.js"></script>

      <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script><script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script><script src="dashboard.js"></script>
  </body>
</html>
