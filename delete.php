<?php
session_start();
$profile_id=$_GET['profile_id'];


?>
<?php
if(!isset($_SESSION['princeLogin']))
   die('Not Logged in');

?>

<!DOCTYPE html>
<html>
<head>
    <title>Ashiful Islam Prince</title>
    <!-- bootstrap.php - this is HTML -->

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet"
          href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
          integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7"
          crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet"
          href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css"
          integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r"
          crossorigin="anonymous">
    <script
            src="https://code.jquery.com/jquery-3.2.1.js"
            integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
            crossorigin="anonymous"></script>

</head>
<body>

<div class="container">
    <h1>Ashiful Islam Prince's Resume delete registry</h1>
       <table border="1">
    <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Headline</th>
        <th>Summary</th>
    </tr>
    <?php
    try{
        $con= new PDO("mysql:host=localhost;dbname=courseraassignment","root","");//We made the connection via pdo

        //First of all you need to submit the html form
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $statement=$con->prepare("select * from profile
                       where profile_id=:profile_id");
        $statement->execute(array(
            ':profile_id'=>$profile_id
        ));
        foreach($statement as $row){
            $firstName=$row['first_name'];
            $lastName=$row['last_name'];
            $fullName=$firstName." ".$lastName;

            echo '<tr>
                        <td>'.$fullName.'</td>
                        <td>'.$row['email'].'</td>
                        <td>'.$row['headline'].'</td>
                        <td>'.$row['summary'].'</td>
                       
                        </tr>';

           echo  '</table>';








        }





    }catch(PDOException $e){
        echo "error".$e->getMessage();
    }


    ?>
           <form method="post" name="deleteForm" action="">
               <input type="hidden" name="Profile_id" value="<?php
               echo $profile_id;
               ?>"

               >
               <input type="submit" onClick="return confirm('are you sure you want to delete this?');" name="Delete" value="delete">
               <input type="submit" name="cancel" value="cancel">
           </form>;

           <?php
           if(isset($_POST['Profile_id']) && isset($_POST['Delete'])){

                   $con = new PDO("mysql:host=localhost;dbname=courseraassignment", "root", "");//We made the connection via pdo
                   $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                   $statement=$con->prepare("DELETE from profile
                       where profile_id=:profile_id");
                   $statement->execute(array(
                       ':profile_id'=>$profile_id
                   ));
                   $_SESSION['profile_deletion']='Profile Deleted';
                   header("location:index.php");
               }





           ?>


</div>
</body>
</html>
