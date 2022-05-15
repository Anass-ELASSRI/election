<?php
session_start();
if (!isset($_SESSION["id"])) {
  header("Location:  ./adminLogin.php");
} else {
  if ($_SESSION['type'] == "user") {
    header("Location:  ./index.php");
  }
}
$nom = $_SESSION["nomComplete"];

include 'dbh.php';
$sql = "select A.*, (Select count(B.ID) from vote AS B where B.id_candidat =A.id) AS NBR_VOTE  From candidat AS A order by NBR_VOTE DESC";
$stmt = $pdo->query($sql);
$candidats = $stmt->fetchAll(PDO::FETCH_OBJ);


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


    <style>

      /* Modal Style */
      .modal {
        display: none;
        /* Hidden by default */
        position: fixed;
        /* Stay in place */
        z-index: 1;
        /* Sit on top */
        left: 0;
        top: 0;
        width: 100%;
        /* Full width */
        height: 100%;
        /* Full height */
        overflow: auto;
        /* Enable scroll if needed */
        background-color: rgb(0, 0, 0);
        /* Fallback color */
        background-color: rgba(0, 0, 0, 0.4);
        /* Black w/ opacity */
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

      .responsive-table tr th:nth-child(2) {
        width: 200px;
      }

      .responsive-table {
        position: relative;
      }

      caption {
        position: absolute;
        top: -43px;
        right: 2px;
        z-index: 500;
      }

      caption button {
        border: 1px solid #f2ba18;
        color: #95a5a6;
        font-size: 25px;
        width: 35px;
        height: 35px;
        cursor: pointer;
      }
      caption button:hover {
        background-color: #f5ba1a;
      }
    </style>







    <table class="responsive-table" style="margin-top:20px;">
      <h2>Tous les candidats</h2>
      <caption><button id="add-candidat">+</button></caption>
      <thead>
        <tr>
          <th scope="col"></th>
          <th scope="col">Nom Candidat</th>
          <th scope="col">Presentation</th>
          <th scope="col">nombre votes</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $i = "1";
        foreach ($candidats as $candidat) {
          echo "      <tr>
                        <td>" . $i . "</td>
                        <td>$candidat->prenom $candidat->nom</td>
                        <td>$candidat->text_presentation</td>      
                        <td>$candidat->NBR_VOTE</td>      
                        <td><div class='grid-row'><button class='deleteButton' onclick='deleteCandidat($candidat->id)'><i class='fa fa-trash' aria-hidden='true'></i></button>
                        <button onclick='editCandidat(\"$candidat->id\",\"$candidat->prenom\",\"$candidat->nom\",\"$candidat->sexe\",\"$candidat->text_presentation\")' class='deleteButton'><i class='fa fa-pencil' aria-hidden='true'></i></button></div></td>      
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
            <form method="post" action="addCandidat.php" name="addForm">
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
                <input type="radio" name="sexe" id="rd1" value="H" required>
                <label for="rd1">Homme</label>
                <input type="radio" name="sexe" id="rd2" value="F" required>
                <label for="rd2">Femme</label>
              </div>

              <input class="btn-flat" type="submit" value="Ajouter" />
            </form>

          </div>
        </div>
      </div>
    </div>
  </div>
  <div id="edit-modal" class="modal">
    <!-- Modal content -->
    <div class="form_wrapper">
      <div class="form_container">
        <div class="title_container">
          <h2>Modifier Candidat</h2>
        </div>
        <div class="row clearfix">
          <div class="">
            <form method="post" action="editCandidat.php" name="editform">
              <input type="hidden" name="id">
              <div class="row clearfix">
                <div class="col_half">
                  <div class="input_field"> <span><i aria-hidden="true" class="fa fa-user"></i></span>
                    <input id="edit-prenom" type="text" name="prenom" placeholder="Prenom" required />
                  </div>
                </div>
                <div class="col_half">
                  <div class="input_field"> <span><i aria-hidden="true" class="fa fa-user"></i></span>
                    <input id="edit-nom" type="text" name="nom" placeholder="Nom" required />
                  </div>
                </div>
              </div>
              <div class="input_field"> <span><i aria-hidden="true" class="fa fa-file-text"></i></span>
                <textarea id="edit-presentation" name="text_presentation" placeholder="Text presentation"></textarea>
              </div>

              <div class="input_field radio_option">
                <input type="radio" name="sexe" id="rd1" value="H" required>
                <label for="rd1">Homme</label>
                <input type="radio" name="sexe" id="rd2" value="F" required>
                <label for="rd2">Femme</label>
              </div>

              <input class="button" type="submit" value="Enregistrer" />
            </form>

          </div>
        </div>
      </div>
    </div>
  </div>
  </tbody>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    function post(action, method,  params) {

      // The rest of this code assumes you are not using a library.
      // It can be made less verbose if you use one.
      const form = document.createElement('form');
      form.method = method;
      form.action = action;

      Object.keys(params).forEach(key => {
        console.log(key, params[key]);
        const hiddenField = document.createElement('input');
        hiddenField.type = 'hidden';
        hiddenField.name = key;
        hiddenField.value = params[key];
  
        form.appendChild(hiddenField);
      });

      document.body.appendChild(form);
      form.submit();
    }

    function deleteCandidat(id_candidat) {
      Swal.fire({

        icon: 'question',
        title: 'vous êtes sûr de supprimer cette candidat',
        focusConfirm: false,
        showDenyButton: true,
        showCancelButton: false,
        confirmButtonText: 'supprrimer',
        denyButtonText: `Anuller`,
        confirmButtonColor:'#e34b4b',
        denyButtonColor:'#94a9ee',


      }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
          post('deleteCandidat.php', 'post', {'id':id_candidat});
        }
      })
    }
    function editCandidat(id, prenom, nom, sexe, presentation) {
      var prenomInput = document.getElementById("edit-prenom");
      var nomInput = document.getElementById("edit-nom");
      var sexeRadio = document.getElementById("edit-sexe");
      var presentationInput = document.getElementById("edit-presentation");
      var editModal = document.getElementById("edit-modal");
      prenomInput.value = prenom;
      nomInput.value = nom;
      presentationInput.value = presentation;
      prenomInput.value = prenom;
      document.editform.sexe.value = sexe;
      document.editform.id.value = id;
      editModal.style.display = "block";


    }
    // Get the modal
    var addModal = document.getElementById("add-modal");
    var editModal = document.getElementById("edit-modal");


    // Get the button that opens the modal
    var btn = document.getElementById("add-candidat");

    // When the user clicks on the button, open the modal
    btn.onclick = function() {
      addModal.style.display = "block";
    };

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
      if (event.target == addModal) {
        addModal.style.display = "none";
      }
      if (event.target == editModal) {
        editModal.style.display = "none";
      }
    };
  </script>
   <?php 
  
        if(isset($_SESSION['deleted-success'])){
          echo "<script type='text/JavaScript'> 
          const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
              toast.addEventListener('mouseenter', Swal.stopTimer)
              toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
          })
          
          Toast.fire({
            icon: 'success',
            title: 'vous avez supprimé cette candidat'
          })
          </script>";
              
          unset($_SESSION['deleted-success']);
          
        }
        if(isset($_SESSION['added-success'])){
          echo "<script type='text/JavaScript'> 
          const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
              toast.addEventListener('mouseenter', Swal.stopTimer)
              toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
          })
          
          Toast.fire({
            icon: 'success',
            title: 'vous avez ajouté cette candidat'
          })
              </script>";
              unset($_SESSION['added-success']);
    
      
            }
        if(isset($_SESSION['edit-success'])){
          echo "<script type='text/JavaScript'> 
          const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
              toast.addEventListener('mouseenter', Swal.stopTimer)
              toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
          })
          
          Toast.fire({
            icon: 'success',
            title: 'vous avez modifieé cette candidat'
          })
              </script>";
              unset($_SESSION['edit-success']);
    
      
            }
  ?>
  <script src="https://use.fontawesome.com/4ecc3dbb0b.js"></script>


</body>

</html>