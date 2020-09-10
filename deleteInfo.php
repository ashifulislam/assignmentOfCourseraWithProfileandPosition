<?php
session_start();
$profile_id=$_GET['profile_id'];


?>
    <?php

        try {
            $con = new PDO("mysql:host=localhost;dbname=courseraassignment", "root", "");//We made the connection via pdo
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $statement=$con->prepare("DELETE from profile
                       where profile_id=:profile_id");
            $statement->execute(array(
                ':profile_id'=>$profile_id
            ));
            $_SESSION['profile_deletion']='Profile Deleted';
            header("location:index.php");
        }catch(PDOException $e){
            echo "error".$e->getMessage();
        }



    ?>
