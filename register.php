<?php // Do not put any HTML above this line
session_start();

require_once "pdo.php";
$salt = 'MmAaPpDd*_';

$failure = false;  // If we have no POST data

// Check to see if we have some POST data, if we do process it
if ( isset($_POST['email']) && isset($_POST['pass']) && isset($_POST['name']) && isset($_POST['role']) ) {
    if ( strlen($_POST['email']) < 1 || strlen($_POST['pass']) < 1 || strlen($_POST['name']) < 1) {
        $_SESSION['error'] = "All fields are required";
        header("Location: index.php");
        return;
    }  else if (strpos($_POST['email'], "@") === false) {
        $_SESSION['error'] = "Email must have an at-sign (@)";
        header("Location: index.php");
        return;
    }else { $em=$_POST['email'];
      $stmt = $pdo->prepare('SELECT * FROM users where email = :prof ');
    $stmt->execute(array(":prof" => $_POST['email']));
$rows2 = $stmt->fetchAll(PDO::FETCH_ASSOC);
 if (sizeof($rows2) > 0) {        $_SESSION['error'] = "Email already exists";
        header("Location: index.php");
        return;
    }

    
   $check = hash('md5', $salt . $_POST['pass']);
    $stmt = $pdo->prepare('INSERT INTO users (name, password, email,role) VALUES (  :fn, :ln, :em, :ab)');

        $stmt->execute(array(
                ':fn' => $_POST['name'],
                ':ln' => $check,
                ':em' => $_POST['email'],
                ':ab' => $_POST['role'])
        );
                
      
        $_SESSION['success'] = "Successfully Registered. Please Login";
        header("Location: index.php");
        return;
      

    }  


}
?>
	