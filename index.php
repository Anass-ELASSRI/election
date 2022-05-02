<?php
session_start();
if(! isset($_SESSION["id"])) {
    header("Location:login.php");
}
$id = $_SESSION["id"];
$nomComlete = $_SESSION["nomComplete"];

if($_SERVER["REQUEST_METHOD"] == "POST") {

    session_start();
    unset($_SESSION["id"]);
    unset($_SESSION["nomComplete"]);
    header("Location:login.php");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        echo "<h1>".$_SESSION["nomComplete"]." you can vote</h1>";
    ?>
    
    <form action="" method="post">
        <button type="submit">logout</button>
    </form>

</body>
</html>