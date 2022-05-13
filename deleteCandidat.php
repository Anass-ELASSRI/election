<?php 
session_start();
include 'dbh.php';

    $id_candidat=$_POST['id'];
    $id= $_SESSION['id'];

    $sql = "INSERT INTO `vote`( `id_electeur`, `id_candidat`) VALUES ('".$id."','$id_candidat');";
    $sql = "DELETE FROM `vote` WHERE id_candidat = $id_candidat";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $sql = "DELETE FROM `candidat` WHERE id = $id_candidat";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    header('Location: adminDashboard.php');

?>