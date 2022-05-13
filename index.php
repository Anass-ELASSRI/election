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

</head>

<body>
  <header>
    <div>
      <h3>Election</h3>
    </div>
    <div>
      <?php
      echo "<p>" . $nom . "</p>";
      ?>
    </div>
    <div>
      <a class='logout' href="logout.php">Deconnecter</a>
    </div>
  </header>


  <div class="container">
    <h2>Top 3 Candidats</h2>
    <ul class="responsive-table">
      <li class="table-header">
        <div class="col col-1">N° Votes</div>
        <div class="col col-2">Nom Candidat</div>
        <div class="col col-3">text</div>
      </li>
      <?php
      foreach ($premiers as $candidat) {
        echo "<li class='table-row'>
                <div class='col col-1'>$candidat->NBR_VOTE</div>
                <div class='col col-2'>$candidat->nom $candidat->prenom</div>
                <div class='col col-3'>$candidat->text_presentation</div>
              </li>";
      }
      ?>

    </ul>
  </div>











  <?php
  if (!$voted) {
    echo '

    <div class="container">
  <table class="responsive-table">
    <caption>Tous les candidats</caption>
    <thead>
      <tr>
        <th scope="col"></th>
        <th scope="col">Prenom candidat</th>
        <th scope="col">Nom condidat</th>
        <th scope="col">Voter</th>
      </tr>
    </thead>
    <tbody>';
    $i = "1";
    foreach ($candidats as $candidat) {
      echo "      <tr>
                        <td>" . $i . "</td>
                        <td>$candidat->prenom</td>
                        <td>$candidat->nom</td>      
                        <td><buttton onclick='voter($candidat->id)' class='voter'>Voter</buttton>
                        </td>      
                    </tr>
                    ";
      $i++;
    }


    echo "
    </tbody>
  </table>
</div>";
  } else {
    $sql4 = "select * from candidat where id=" . $voted->id_candidat;
    $stmt4 = $pdo->query($sql4);
    $candidat_voted = $stmt4->fetch(PDO::FETCH_OBJ);
    echo "<div><p class='voted_candidat'>vous avez deja vote à $candidat_voted->nom $candidat_voted->prenom</p></div>";
  }
  ?>

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
        title: 'Do you vote to this person',
        showDenyButton: true,
        showCancelButton: false,
        confirmButtonText: 'Voter',
        denyButtonText: `Anuller`,


      }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
          Swal.fire('Saved!', '', 'success');
          post(id_candidat);
        }
      })
    }
  </script>

<style>
.grid-container {
  display: grid;
  gap: 20px 100px;
  grid-template-columns: 1fr 1fr 1fr;
  background-color: #2196F3;
  padding: 10px;
}
.grid-item {
  background-color: rgba(255, 255, 255, 0.8);
  border: 1px solid rgba(0, 0, 0, 0.8);
  height: 230px;
  display: grid;
  grid-template-rows: 2fr 1fr;
}
.profil-pic {
  background-color: red;
}
</style>
<div class="container">

<div class="grid-container">
  <?php
    foreach ($candidats as $candidat) {
      echo "  <div class='grid-item'>
                <div class='profil-pic'>
                  
                </div>
                <div class='profil-text'></div>
              </div>";
    }
  ?>
</div>
</div>
</body>

</html>