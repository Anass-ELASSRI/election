<?php
session_start();

include 'dbh.php';
if(isset($_SESSION["id"])) {
        //    $sql = "select nom, prenom, text_presentation from candidat" ;
        $sql = "select *from candidat" ;
        $stmt = $pdo->query($sql);
        $candidats = $stmt->fetchAll(PDO::FETCH_OBJ);
  if($_SERVER['REQUEST_METHOD']== 'POST'){
    $nom=$_POST['nom'];
    $prenom=$_POST['prenom'];
    $text_presentation=$_POST['text_presentation'];
    $sexe=$_POST['sexe'];
    $query="INSERT INTO `candidat` (`id`, `nom`, `prenom`, `text_presentation`, `sexe`) VALUES (NULL, '$nom', '$prenom', '$text_presentation', '$sexe');";
    $stmt2 = $pdo->query($query);
    header('Location:adminDashboard.php');
    echo $sexe;
  }
    
        
    } else {
        header("Location:adminLogin.php");
    }
        
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rank</title>
    <link rel="stylesheet" href="style.css">    
</head>
<body>
    <header>
        <div><h3>Election</h3></div>
        <div>
        <a class='logout' href="logout.php">Deconnecter</a>
        </div>
    </header>


    
    
    <div class="container">
    <button class="addCandidat" id="add-candidat">Ajouter Candidat</button>


    <style>
      .addCandidat{
        background: #f5ba1a;
    height: 35px;
    line-height: 35px;
    width: 100%;
    border: none;
    outline: none;
    cursor: pointer;
    color: #fff;
    font-size: 1.1em;
    margin-bottom: 10px;
    margin-top: 10px;
    -webkit-transition: all 0.3s ease-in-out;
    -moz-transition: all 0.3s ease-in-out;
    -ms-transition: all 0.3s ease-in-out;
    transition: all 0.3s ease-in-out;
      }
      /* Modal Style */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}
.modal-content {
  border-radius: 7px;
  background-color: #fbfbfb;
  padding: 20px;
  width: 80%; 
  position: fixed;
  left: 50%;
  top: 50%;
  transform: translate(-50%, -50%);

}
.responsive-table tr th:nth-child(2){
  width:200px;
}
    </style>







  <table class="responsive-table" style="margin-top:20px;">
    <caption>Tous les candidats</caption>
    <thead>
      <tr>
        <th scope="col"></th>
        <th scope="col">Nom Candidat</th>
        <th scope="col">Presentation</th>
      </tr>
    </thead>
    <tbody>
        <?php 
                $i="1";
                foreach ($candidats as $candidat) {
                    echo "      <tr>
                        <td>".$i."</td>
                        <td>$candidat->prenom $candidat->nom</td>
                        <td>$candidat->text_presentation</td>      
                    </tr>";
                    $i++;
                }
        
?>
  </table>
</div>

<div id="add-modal" class="modal">
  <!-- Modal content -->
        <div class="form_wrapper">
          <div class="form_container">
            <div class="title_container">
              <h2>Ajouter Candidat</h2>
            </div>
            <div class="row clearfix">
              <div class="">
          <form method="post" action="" name="regisrationForm">
            <div class="row clearfix">
              <div class="col_half">
                <div class="input_field"> <span><i aria-hidden="true" class="fa fa-user"></i></span>
                <input type="text" name="prenom" placeholder="Prenom" required />
              </div>
            </div>
              <div class="col_half">
                <div class="input_field"> <span><i aria-hidden="true" class="fa fa-user"></i></span>
                  <input type="text" name="nom" placeholder="Nom" required />
                </div>
              </div>
            </div>
            <div class="input_field"> <span><i aria-hidden="true" class="fa fa-file-text"></i></span>
            <textarea name="text_presentation" placeholder="Text presentation"></textarea>
          </div>
          
          <div class="input_field radio_option">
            <input type="radio" name="sexe" id="rd1" value="H" required >
            <label for="rd1">Homme</label>
            <input type="radio" name="sexe" id="rd2" value="F" required >
            <label for="rd2">Femme</label>
          </div>
          
          <input class="button" type="submit" value="Ajouter" />
        </form>
        
      </div>
    </div>
  </div>
</div>
</div>
</tbody>

<script>
  // Get the modal
  var modal = document.getElementById("add-modal");
  
  
  // Get the button that opens the modal
  var btn = document.getElementById("add-candidat");
  
  // When the user clicks on the button, open the modal
  btn.onclick = function () {
    modal.style.display = "block";
  };

  // When the user clicks anywhere outside of the modal, close it
window.onclick = function (event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
};
</script>
<script src="https://use.fontawesome.com/4ecc3dbb0b.js"></script>


</body>
</html>