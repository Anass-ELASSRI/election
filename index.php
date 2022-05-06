<?php
session_start();

include 'dbh.php';
if(isset($_SESSION["id"])) {
        $nom = $_SESSION["nomComplete"];
        //    $sql = "select nom, prenom, text_presentation from candidat" ;
        $sql = "select candidat.*, count(*) AS NBR_VOTE from candidat join vote on candidat.id =
        vote.id_candidat GROUP by vote.id_candidat order by COUNT(*) DESC LIMIT 3" ;
        $stmt1 = $pdo->query($sql);
        $premiers = $stmt1->fetchAll(PDO::FETCH_OBJ);
        $sql2 = "select * from candidat " ;
        $stmt2 = $pdo->query($sql2);
        $candidats = $stmt2->fetchAll(PDO::FETCH_OBJ);
        $id= $_SESSION['id'];
        $sql3="select * from vote where id_electeur=".$id;
        $stmt3 = $pdo->query($sql3);
        $voted = $stmt3->fetch(PDO::FETCH_OBJ);
    
        
    } else {
        header("Location:login.php");
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
            <?php
                echo "<p>".$nom."</p>";
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
        if(! $voted){
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
                $i="1";
                foreach ($candidats as $candidat) {
                    echo "      <tr>
                        <td>".$i."</td>
                        <td>$candidat->prenom</td>
                        <td>$candidat->nom</td>      
                        <td><a class='voter' href='voter.php?id=$candidat->id'>Voter</a>
                        </td>      
                    </tr>
                    ";
                    $i++;
                }
        

      echo "
    </tbody>
  </table>
</div>";
            }else{
              $sql4="select * from candidat where id=".$voted->id_candidat;
              $stmt4 = $pdo->query($sql4);
              $candidat_voted = $stmt4->fetch(PDO::FETCH_OBJ);
                echo "<div><p class='voted_candidat'>vous avez deja vote à $candidat_voted->nom $candidat_voted->prenom</p></div>";
            }
?>
                        


</body>
</html>