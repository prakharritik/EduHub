<?php
      session_start();include 'pdo.php';

    $stmt = $pdo->prepare('SELECT * FROM test where cid = :prof and id= :d');
    $stmt->execute(array(":prof" => $_SESSION['cid'],
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

        $stmt = $pdo->prepare('INSERT INTO marks ( sid,tid, marks) VALUES (  :fn, :ln,:da,:ti)');

        $stmt->execute(array(
                ':fn' => $email,
                ':ln' => $_SESSION['quiz'],
                ':da' => $s)
        );
        
        header("location:test.php");
        return;
}
        ?>
<html>
    <head>
       
		<meta charset='utf-8'>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
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
    <div id='timer' class="text-center "></div>
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


const deadline =new Date('<?php echo $test['etime'];?>');

console.log(deadline);
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