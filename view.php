<?php
session_start();

?>
<?php

$profile_id = $_GET['profile_id'];


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
    <h1>Ashiful Islam Prince's view Resume</h1>

    <table border="1">
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Headline</th>
            <th>Summary</th>

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
                $email=$row['email'];
                $summary=$row['summary'];
                $fullName=$firstName." ".$lastName;

                echo '<tr>
                        <td>'.$fullName.'</td>
                        <td>'.$email.'</td>
                        <td>'.$row['headline'].'</td>
                        <td>'.$row['summary'].'</td>
                     </tr>';





            }




        }catch(PDOException $e){
            echo "error".$e->getMessage();
        }
echo  '</table>';
        echo '<p>
                  <b>Note:</b> Your implementation should retain data across multiple
                   logout/login sessions.  This sample implementation clears all its
                  data periodically - which you should not do in your implementation.
                 </p>';

        ?>

        <!--<tr> <td>
             <a href="view.php?profile_id=5765">Test Last</a></td><td>
             head</td>
         </tr>';-->


</div>

</body>
</html>