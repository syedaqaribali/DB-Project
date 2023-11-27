<?php
    include('./includes/connect.php');
    $id1 = $_GET['id1'];
    $id2 = $_GET['id2'];
    $id3 = $_GET['id3'];
    $sql = "DELETE from alert where driverID = '$id1' and rollNo = '$id3' and stopName = '$id2'";
    if(mysqli_query($con, $sql)){
        header('location:driverLogin.php');
    } else{
        echo "ERROR: Hush! Sorry";
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
    
</body>
</html>