<?php 
session_start();
include 'dbh.php';

    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $text_presentation = $_POST['text_presentation'];
    $sexe = $_POST['sexe'];
    $query = "INSERT INTO `candidat` (`id`, `nom`, `prenom`, `text_presentation`, `sexe`) VALUES (NULL, '$nom', '$prenom', '$text_presentation', '$sexe');";
    $stmt2 = $pdo->query($query);
    $_SESSION['added-success'] = true;


    header('Location:adminDashboard.php');
?>