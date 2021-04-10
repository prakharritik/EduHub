<?php
      session_start();include 'connect.php';
      $name=$_SESSION['name'];
        $email=$_SESSION['student_id'];
        $institute_name=$_SESSION['institute_name'];
                 if ($_GET['cid']!=$_SESSION['class']) {
                    Print "<script>window.location.assign('home.php')</script>";
            }
        if(isset($_GET['cid']) && is_numeric($_GET['cid'])){}
      else{
      Print "<script>alert('Some error occured. Please login again')</script>";
      Print "<script>window.location.assign('home.php')</script>";
      exit();
      }?><html>
    <head>
        <title>E-Svadhyaya/Doubt Sessions</title>
		<meta charset='utf-8'>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons">
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-material-design@4.1.1/dist/css/bootstrap-material-design.min.css" integrity="sha384-wXznGJNEXNG1NFsbm0ugrLFMQPWswR3lds2VeinahP8N0zJw9VWSopbjv2x7WCvX" crossorigin="anonymous">
    <link    rel="stylesheet"    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"  />
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons">
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>
		<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
		<script type="text/javascript" src="js/mdb.min.js"></script>
		<link rel="icon" href="pictures/log.jpeg" style="image/jpeg">
        <link href='https://fonts.googleapis.com/css?family=Brawler' rel='stylesheet'>
        <link rel="stylesheet" type="text/css" href="style2.css">
        <link rel="stylesheet" type="text/css" href="styles.css">
        <style>

	
			.navbar{
	width:100%;
	font-size:18px;
}
h4{
  color: white;
}

            h2{
                text-align:center;
                margin:20%;
                font-size:50px;
                padding:10px 5px;
                font-family:'Brawler';
                box-sizing:border-box;
                border:5px solid black;
                border-radius:10px;
				color:white;
            }
			.navbar{
	width:100%;
	font-size:18px;
}
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

        </style>
    </head>
    <body>
    	<?php
      if (isset($_POST['submit'])) {
        $name=$_SESSION['name'];
        $email=$_SESSION['student_id'];
        $re=$_POST['review'];

            if (isset($_POST['review']) && strlen($_POST['review'])>0) {
              date_default_timezone_set('Asia/Kolkata');
$x=date('d-m-Y H:i');
              $insert_query="INSERT INTO discussion(t_username,message,cid,name,time,iid) VALUES('$email','$re','".$_GET['cid']."','$name','$x','$institute_name')";
              $perform_insert_query=mysqli_query($con,$insert_query);
            }
                }
?>
        <a href="#fo"><i class='fas fa-arrow-circle-down' style='font-size:48px;color:red;position: fixed;right: 10px;bottom: 10px;'></i></a>
		<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
			<a class="navbar-brand" href="home.php"><img src="pictures/log3.jpg"  alt="logo.jpeg" style="width:80px;"></a>
      <h1>E-Svadhyaya</h1>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
					<li class="nav-item">
						<a class="nav-link" href="view_subject.php?cid=<?php echo $_SESSION['class'];?>">Back</a>
					</li>
                </ul>
            </div>
        </nav>
          <?php 
                      $q=mysqli_query($con,"SELECT * from discussion where cid=".$_GET['cid']." and iid='$institute_name'");
   $num= mysqli_num_rows($q);
   if($num>0){
         $rev=mysqli_fetch_all($q);
                   foreach ($rev as $key) {
                     $a=$key[2];$b=$key[1];
                     if($key[3]==$email){
                     echo "<div class='a' style='' class='mr-5'><h6 style='color:black;font-weight:bold;display:inline;'>You</h6>&nbsp;&nbsp;&nbsp;&nbsp; ".$key[5]."<p style='margin-left:10%;font-size:20px;'>".$b."</p></div>";}
                    else{
                      echo "<div class='b' style='' class='ml-5 mr-5'><h6 style='color:black;display:inline;'>".$a."</h6>&nbsp;&nbsp;&nbsp;&nbsp;".$key[5]."<p style='margin-left:10%;font-size:20px;'>".$b."</p></div>";
                    }
                   }}
                ?>
                     <div style="bottom: 20px;right: 0px;">
                       <form method="POST" id="fo">
                        
                                 <textarea id="subject" name="review" class="form-control mt-4" style="width:100%;background-color: #8ae9b3;
background-image: linear-gradient(315deg, #8ae9b3 0%, #c8d6e5 74%);" rows="5" placeholder="Write a message"></textarea>
<?php
if($_SESSION['institute_name']!='d@demo.com'){
                           echo'<input type="submit" name="submit" class="clicky mb-5" style="display: block;margin: auto;" >';}
?>
            </form>
                  </div>
                   <?php 
                    if($_SESSION['institute_name']=='d@demo.com'){
                          echo'    <div class="alert alert-info animate__animated animate__fadeInRight">    <div class="container">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true"><i class="material-icons">clear</i></span>
            </button>
      Here the students can discuss with their peers and teachers.</div>
        </div>';}
        ?>
    </body> 

</html>