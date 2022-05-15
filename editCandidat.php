<?php 
session_start();
include 'dbh.php';

    $id = $_POST['id'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $text_presentation = $_POST['text_presentation'];
    $sexe = $_POST['sexe'];
    $query = "UPDATE candidat SET nom = '$nom', prenom ='$prenom', sexe = '$sexe', text_presentation = '$text_presentation' WHERE id=$id";
    $stmt2 = $pdo->query($query);
    $_SESSION['edited-success'] = true;


    header('Location:adminDashboard.php');
?>