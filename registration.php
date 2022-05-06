<?php
session_start();
if(isset($_SESSION["id"])) {
    header("Location:index.php");
 }

$exists=false;
    
if($_SERVER["REQUEST_METHOD"] == "POST") {
      
    // include 'DataSource.php'; 
    include 'dbh.php';


    $prenom = $_POST["prenom"]; 
    $nom = $_POST["nom"]; 
    $email = $_POST["email"];
    $motDePasse = $_POST["motDePasse"];
    $sexe = $_POST["sexe"];
            
    $sql = "Select * from users where email='$email'";
    $stmt = $pdo->query($sql);


    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if(! $user) {
        if($exists==false) {
    
            $hash = password_hash($motDePasse, PASSWORD_DEFAULT);
                
            // Password Hashing is used here. 
            echo $sexe;
            $sql = "INSERT INTO `users` ( `prenom`, `nom`, `email`, `sexe`, `password_`) VALUES ('$prenom', '$nom', '$email', '$sexe', '$hash')";
    
            $stmt = $pdo->prepare($sql);
            $inserted = $stmt->execute();
            if ($inserted) {
                header("Location:  ./login.php"); 
            }
        } 
    }else{
        $exists="email not available"; 
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
    if($exists) {
        echo ' <div class="alert alert-danger 
        alert-dismissible fade show" role="alert">
        
        <strong>Error!</strong> '. $exists.'
        <button type="button" class="close" 
        data-dismiss="alert" aria-label="Close"> 
        <span aria-hidden="true">×</span> 
        </button>
        </div> '; 
    }
     
    ?>
  <div class="form_wrapper">
    <div class="form_container">
      <div class="title_container">
        <h2>Inscription Form</h2>
      </div>
      <div class="row clearfix">
        <div class="">
          <form method="post" action="" name="regisrationForm">
            <div class="row clearfix">
              <div class="col_half">
                <div class="input_field"> <span><i aria-hidden="true" class="fa fa-user"></i></span>
                  <input type="text" name="prenom" placeholder="Prenom" />
                </div>
              </div>
              <div class="col_half">
                <div class="input_field"> <span><i aria-hidden="true" class="fa fa-user"></i></span>
                  <input type="text" name="nom" placeholder="Nom" required />
                </div>
              </div>
            </div>
            <div class="input_field"> <span><i aria-hidden="true" class="fa fa-envelope"></i></span>
              <input type="email" name="email" placeholder="Email" required />
            </div>
            <div class="input_field"> <span><i aria-hidden="true" class="fa fa-lock"></i></span>
              <input type="password" name="motDePasse" placeholder="Mot De Passe" required />
            </div>

            <div class="input_field radio_option">
              <input type="radio" name="sexe" id="rd1" value="H" required>
              <label for="rd1">Homme</label>
              <input type="radio" name="sexe" id="rd2" value="F" required>
              <label for="rd2">Femme</label>
            </div>
            
            <div class="input_field checkbox_option">
              <input type="checkbox" id="cb1" required>
              <label for="cb1">I agree with terms and conditions</label>
            </div>
            <input class="button" type="submit" value="Register" />
          </form>
          <div class="devMembre"><a href="login.php">Connexion</a></div>

        </div>
      </div>
    </div>
  </div>

  <script src="https://use.fontawesome.com/4ecc3dbb0b.js"></script>
</body>


</html>