<?php
      session_start();include 'pdo.php';
      $name=$_SESSION['name'];
        $email=$_SESSION['student_id'];
        $inst=$_SESSION['iname'];
    $stmt = $pdo->prepare('SELECT * FROM test where cid = :prof and id= :d');
    $stmt->execute(array(":prof" => $_SESSION['class'],
        ":d"=>$_SESSION['quiz'])
);$c=0;
    $test = $stmt->fetch();
    $stmt = $pdo->prepare('SELECT * FROM ques where tid = :prof');
    $stmt->execute(array(":prof" => $_SESSION['quiz']));
    $schools = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if(isset($_POST['submit'])){
        $i=0;$s=0;
        foreach ($schools as $key) {
            ++$i;
            if(!isset($_POST['a'.$i]))continue;
            if ($_POST['a'.$i]==$key['correct']) {
                $s++;

            }
        }
        if($_SESSION['institute_name']=='d@demo.com'){
            $_SESSION['message']='Score:'.$s.'  Times Tab switched:'.$_POST['cheat'];
        }
        else{
        $stmt = $pdo->prepare('INSERT INTO marks_'.$_SESSION['institute_name'].' ( sid,tid, marks,cheat) VALUES (  :fn, :ln,:da,:ti)');

        $stmt->execute(array(
                ':fn' => $email,
                ':ln' => $_SESSION['quiz'],
                ':da' => $s,
                ':ti' => $_POST['cheat'])
        );
        }
        header("location:home_student.php");
        return;
}
        ?>
<html>
    <head>
        <title>E-Svadhyaya/Test</title>
		<meta charset='utf-8'>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-material-design@4.1.1/dist/css/bootstrap-material-design.min.css" integrity="sha384-wXznGJNEXNG1NFsbm0ugrLFMQPWswR3lds2VeinahP8N0zJw9VWSopbjv2x7WCvX" crossorigin="anonymous">
    <link    rel="stylesheet"    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"  />
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>
		<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
		<script type="text/javascript" src="js/mdb.min.js"></script>
		<link rel="icon" href="pictures/log.jpeg" style="image/jpeg">
        <link href='https://fonts.googleapis.com/css?family=Brawler' rel='stylesheet'>
        <link rel="stylesheet" type="text/css" href="style2.css">
        <link rel="stylesheet" type="text/css" href="styles.css">
<style>
    h4{
        color: #111;
        font-size: 30px;
        font-weight: bolder;
    }
    .noselect {
  -webkit-touch-callout: none; /* iOS Safari */
    -webkit-user-select: none; /* Safari */
     -khtml-user-select: none; /* Konqueror HTML */
       -moz-user-select: none; /* Old versions of Firefox */
        -ms-user-select: none; /* Internet Explorer/Edge */
            user-select: none; /* Non-prefixed version, currently
                                  supported by Chrome, Edge, Opera and Firefox */
}

</style>
</head>

<body class="noselect">
    <div id='timer' class="text-center text-white"></div>
    <div class="container mt-5">
        
    <div class="d-flex justify-content-center row">
        <div class="col-md-10 col-lg-10">
            <div class="border">
                <div class="question bg-white p-3 border-bottom">
                    <div class="d-flex flex-row justify-content-between align-items-center mcq">
                        <h4 ><?php echo $test['title'];?></h4>
                    </div>
                </div>
            <form method="post">
                <?php
                $c=0;
                foreach ($schools as $key) {
                    ++$c;
                echo'<div class="question bg-white p-3 border-bottom">
                    <div class="d-flex flex-row align-items-center question-title">
                        <h3 class="text-danger">Q.</h3>
                        <h5 class="mt-1 ml-2">'.$key['ques'].'</h5>
                    </div>
                    <div class="ans ml-2">
                        <label class="radio"> <input type="radio" name="a'.$c.'" value="1"> <span>'.$key['o1'].'</span>
                        </label>
                    </div>
                    <div class="ans ml-2">
                        <label class="radio"> <input type="radio" name="a'.$c.'" value="2"> <span>'.$key['o2'].'</span>
                        </label>
                    </div>
                    <div class="ans ml-2">
                        <label class="radio"> <input type="radio" name="a'.$c.'" value="3"> <span>'.$key['o3'].'</span>
                        </label>
                    </div>
                    <div class="ans ml-2">
                        <label class="radio"> <input type="radio" name="a'.$c.'" value="4"> <span>'.$key['o4'].'</span>
                        </label>
                    </div></div>';

}

                ?>
                <input type="hidden" name="cheat" value='0' id='cheat'>
                <div class="d-flex flex-row justify-content-between align-items-right p-3 bg-white"><input class="btn btn-primary border-success align-items-center btn-success" type="submit" name="submit" value="Submit"></div>
            </form>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('contextmenu', event => event.preventDefault());
   var c=0;
   document.addEventListener('visibilitychange', function(){
   document.title = document.visibilityState;
   if(document.visibilityState=='hidden'){c++;document.getElementById('cheat').value=c;
   }
  
});
   if (sessionStorage.getItem("counter")) {

        var value = sessionStorage.getItem("counter");
      }
else {
      var value = 0;
    }
    const timeSpan = document.getElementById('timer');

const mins = <?php echo $test['duration'];?>;
const now = new Date().getTime();
if(value!=0)
value=mins * 60 * 1000 -value;
const deadline = mins * 60 * 1000 + now - value;


setInterval(() => {
  var currentTime = new Date().getTime();
  var distance = deadline - currentTime;
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);
  value= minutes * 60 * 1000 + seconds * 1000;
sessionStorage.setItem("counter", value);
  timeSpan.innerHTML = minutes + 'min ' + seconds + 'seconds';
  if(minutes<=0 && seconds<=0){sessionStorage.clear();
    window.location.assign('home_student.php');
  }
}, 500)

        $(document).keydown(function (event) {
            if (event.keyCode == 123) {
                return false;
            }
            else if ((event.ctrlKey && event.shiftKey && event.keyCode == 73) || (event.ctrlKey && event.shiftKey && event.keyCode == 74)) {
                return false;
            }
        });

</script>
</body>
</html>