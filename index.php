<?php
session_start();
if (!isset($_SESSION["id"])) {
  header("Location:  ./login.php");
} else {
  if ($_SESSION['type'] == "admin") {
    header("Location:  ./adminLogin.php");
  }
}


include 'dbh.php';
$nom = $_SESSION["nomComplete"];
$sql = "select A.*, (Select count(B.ID) from vote AS B where B.id_candidat =A.id) AS NBR_VOTE  From candidat AS A order by NBR_VOTE DESC LIMIT 3";

$stmt1 = $pdo->query($sql);
$premiers = $stmt1->fetchAll(PDO::FETCH_OBJ);
$sql2 = "select * from candidat ";
$stmt2 = $pdo->query($sql2);
$candidats = $stmt2->fetchAll(PDO::FETCH_OBJ);
$id = $_SESSION['id'];
$sql3 = "select * from vote where id_electeur=" . $id;
$stmt3 = $pdo->query($sql3);
$voted = $stmt3->fetch(PDO::FETCH_OBJ);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Rank</title>
  <link rel="stylesheet" href="style.css">
  <style>
    .grid-container {
      display: grid;
      row-gap: 30px;
      justify-content: space-between;
      grid-template-columns: 30% 30% 30%;
      padding: 10px;
    }

    .grid-item {
      position: relative;
      background-color: rgba(255, 255, 255, 0.8);
      border: 1px solid #d2a834;
      height: 250px;
      display: grid;
      grid-template-rows: 85% 10%;
    }

    .profil-pic {
      border-radius: 50%;
      overflow: hidden;
      border: 1px solid #f5ba1a;
    }

    .profil-pic img {
      width: 100%;
      height: auto;

    }

    .profil-text {
      border-top: 1px solid #d2a834;
    padding: 10px;
    text-align: center;
    }

    .text-content {
      font-size: 16px;
     font-weight: 600;
      text-align: center;
    }

    .overlay {
      position: absolute;
      bottom: 100%;
      left: 0;
      right: 0;
      background-color: #121212d4;
      overflow: hidden;
      width: 100%;
      height: 0;
      transition: .5s ease;
    }

    .grid-item:hover .overlay {
      bottom: 0;
      height: 100%;
    }

    .overlay-content {
    position: absolute;
    overflow: hidden;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);
    width: 100%;
    padding: 15px;
    height: 100%;
    display: grid;
    grid-template-rows: auto auto;
    }
    .overlay-content .presentation{
      color: #ede2ba;
    font-size: 18px;
    font-weight: 500;
    text-align: justify;
    }
    .overlay-content .btn-container{
      text-align: center;
      align-self: end;
    }

    .btn-voter{
      outline: none;
    border: none;
    background-color: #6c7676;
    padding: 6px 25px;
    font-size: 15px;
    color: #f0c445;
    text-transform: uppercase;
    cursor: pointer;
    }
    .fuller-button {
      cursor: pointer;
      text-transform: uppercase;
font-weight: 600;
      color: white;
    background: none;
    border-radius: 0;
    padding: 7px 40px;
    letter-spacing: 4.2px;
    font-size: 15px;
    transition: background-color 0.3s, box-shadow 0.3s, color 0.3s;
}
.fuller-button.blue {
  box-shadow: inset 0 0 1em rgb(245 211 91 / 50%), 0 0 1em rgb(245 211 91 / 50%);
    border: var(--color-primary) solid 2px;
}
.fuller-button.blue:hover {
  background-color: var(--color-primary);
  box-shadow: inset 0 0 0 rgb(245 211 91 / 70%), 0 0 1.5em rgb(245 211 91 / 70%);
}

  </style>
</head>

<body>
  <header>
    <div>
      <img src="./img/logo.png">
    </div>
    <div>
      <?php
      echo "<p>" . $nom . "</p>";
      ?>
    </div>
    <div>
      <a class='logout' href="logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i></a>
    </div>
  </header>

  <div class="container">
    <h2>Top Candidats</h2>
    <ul class="responsive-table">
      <li class="table-header">
        <div class="col col-1">N?? Votes</div>
        <div class="col col-2">Nom Candidat</div>
        <div class="col col-3">genre</div>
        <div class="col col-4">presentation</div>
      </li>
      <?php
      foreach ($premiers as $candidat) {
        if($candidat->sexe == 'H'){
          $sexShow = 'Homme';
        }else{
          $sexShow = 'Femme';

        }
        echo "<li class='table-row'>
                <div class='col col-1'>$candidat->NBR_VOTE</div>
                <div class='col col-2'>$candidat->nom $candidat->prenom</div>
                <div class='col col-3'>$sexShow</div>
                <div class='col col-4'>$candidat->text_presentation</div>
              </li>";
      }
      ?>

    </ul>
  </div>










  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    function post(params) {

      // The rest of this code assumes you are not using a library.
      // It can be made less verbose if you use one.
      const form = document.createElement('form');
      form.method = 'post';
      form.action = 'voter.php';

      const hiddenField = document.createElement('input');
      hiddenField.type = 'hidden';
      hiddenField.name = 'id';
      hiddenField.value = params;

      form.appendChild(hiddenField);

      document.body.appendChild(form);
      form.submit();
    }

    function voter(id_candidat) {
      Swal.fire({

        icon: 'question',
        text: 'Voulez-vous voter pour cette personne',
        showDenyButton: true,
        showCancelButton: false,
        confirmButtonText: 'Voter',
        denyButtonText: `Anuller`,


      }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
          post(id_candidat);
        }
      })
    }
  </script>

  
<?php
  if (!$voted) {
    echo '<div class="container">
    <h2>Tous Les Candidats</h2>
             <div class="grid-container">';
      foreach ($candidats as $candidat) {
        echo "  <div class='grid-item'>
                <div class='profil-pic'>";
                if($candidat->sexe == 'H'){
                  echo "<img src='./img/man.png'>";
                }else{
  echo "<img src='./img/woman.png'>";

}
               echo "</div>
                <div class='profil-text'>
                  <div class='text-content'>
                  $candidat->prenom $candidat->nom
                  </div>
                </div>
                <div class='overlay'>
                  <div class='overlay-content'>
                
                    <div class='presentation'>$candidat->text_presentation</div>
                    <div class='btn-container'><button onclick='voter($candidat->id)' class='pure-button fuller-button blue'>Voter</button></div>
                  </div>
                </div>
              </div>";
      }
    echo '</div>
  </div>';
    }else {
      $sql4 = "select * from candidat where id=" . $voted->id_candidat;
      $stmt4 = $pdo->query($sql4);
      $candidat_voted = $stmt4->fetch(PDO::FETCH_OBJ);
      echo "<div><p class='voted_candidat'>vous avez deja vote ?? $candidat_voted->nom $candidat_voted->prenom</p></div>";
    }
  ?>
  <?php 
    if(isset($_SESSION['voted-success'])){
    echo '<script type="text/JavaScript"> 
    const Toast = Swal.mixin({
      toast: true,
      position: "bottom-end",
      showConfirmButton: false,
      timer: 3000,
      timerProgressBar: true,
      didOpen: (toast) => {
        toast.addEventListener("mouseenter", Swal.stopTimer)
        toast.addEventListener("mouseleave", Swal.resumeTimer)
      }
    })
    
    Toast.fire({
      icon: "success",
      title: "Vous avez votez"
    })
        </script>';
        

  }
  unset($_SESSION['voted-success']);
  ?>
    <script src="https://use.fontawesome.com/4ecc3dbb0b.js"></script>

</body>

</html>