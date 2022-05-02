<?php
session_start();
if(isset($_SESSION["id"])) {
    header("Location:index.php");
 }
$success = false;
$message = false;
if($_SERVER["REQUEST_METHOD"] == "POST") {

    include 'dbh.php';

    $email = $_POST["email"];
    $motDePasse = $_POST["motDePasse"];
    
    $sql = "Select * from users where email='$email'";
    $stmt = $pdo->query($sql);
    $user = $stmt->fetch(PDO::FETCH_OBJ);
    $isSuccess = 0;


    if($user) {
        $hashedPassword = $user->password_;
        if (password_verify($_POST["motDePasse"], $hashedPassword)) {
            $isSuccess = 1;
        }
    }
    if ($isSuccess == 0) {
        $message = "Invalid Email or Password!";
    } else {
      $_SESSION['id'] = $user->id;
      $_SESSION['nomComplete'] = $user->prenom . " " . $user->nom;
        header("Location:  ./index.php");
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inscription</title>
  <link rel="stylesheet" href="style.css">

</head>

<body>
  
<?php
  if(isset($_SESSION["id"])) {
      echo $_SESSION["id"];
  }

    if($message){
        echo '<h2>'.$message.'</h2>';
    }
    if($success){
        echo '<h2>inscri avec success</h2>';
    }
?>
  <div class="form_wrapper">
    <div class="form_container">
      <div class="title_container">
        <h2>Responsive Login Form</h2>
      </div>
      <div class="row clearfix">
        <div class="">
          <form method="post" action="" name="loginForm">
            <div class="input_field"> <span><i aria-hidden="true" class="fa fa-envelope"></i></span>
              <input type="email" name="email" placeholder="Email" required />
            </div>
            <div class="input_field"> <span><i aria-hidden="true" class="fa fa-lock"></i></span>
              <input type="password" name="motDePasse" placeholder="Mot De Passe" required />
            </div>

            
            <input class="button" type="submit" value="Login" />
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- <script src="https://use.fontawesome.com/4ecc3dbb0b.js"></script> -->
  </body>


</html>