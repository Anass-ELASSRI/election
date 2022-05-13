<?php
session_start();
if (isset($_SESSION["id"])) {
  if ($_SESSION['type'] == "admin") {
    header("Location:  ./adminDashboard.php");
  } else {
    header("Location:  ./index.php");
  }
}
$success = false;
$message = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  include 'dbh.php';

  $email = $_POST["email"];
  $motDePasse = $_POST["motDePasse"];

  $sql = "Select * from users where email='$email'";
  $stmt = $pdo->query($sql);
  $user = $stmt->fetch(PDO::FETCH_OBJ);
  $isSuccess = 0;


  if ($user) {
    if ($user->type == 'user') {

      $hashedPassword = $user->password_;
      if (password_verify($_POST["motDePasse"], $hashedPassword)) {
        $_SESSION['id'] = $user->id;
        $_SESSION['type'] = 'user';
        $_SESSION['nomComplete'] = $user->prenom . " " . $user->nom;
        header("Location:  ./index.php");
      }
    } else {
      $message = "Admin can not log in!";
    }
  } else {
    $message = "Invalid Email or Password!";
  }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Connexion</title>
  <link rel="stylesheet" href="style.css">

</head>

<body>
  <div class="form_wrapper">
    <div class="form_container">
      <div class="title_container">
        <h2>Login Form</h2>
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
          <?php
          if ($message) {
            echo '<div class="error-messsage">' . $message . '</div>';
          }

          ?>

          <div class="devMembre"><a href="registration.php">Devenir Membre</a></div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://use.fontawesome.com/4ecc3dbb0b.js"></script>
</body>


</html>