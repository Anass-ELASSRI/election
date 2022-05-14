<?php 
session_start();
include 'dbh.php';

            $id_candidat=$_POST['id'];
            $id= $_SESSION['id'];

            $sql = "INSERT INTO `vote`( `id_electeur`, `id_candidat`) VALUES ('".$id."','$id_candidat');";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $_SESSION['voted-success'] = true;

            header('Location: index.php');

        ?>