<?php
session_start();


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


     <h1>Ashiful Islam Prince's index Resume</h1>
        <span class="text-success">
       <?php
       if(isset($_SESSION['profile_addition'])){


        echo $_SESSION['profile_addition'];
             $_SESSION['profile_addition']="";



        } if(isset($_SESSION['profile_edition'])){




                 echo $_SESSION['profile_edition'];
                 $_SESSION['profile_edition']="";
             }
       if(isset($_SESSION['profile_deletion'])){
           echo $_SESSION['profile_deletion'];
              $_SESSION['profile_deletion']="";
       }



                echo '</span>';
             ?>



        <?php
    if (isset($_SESSION['princeLogin']))
            {
              function logout(){
                  echo '<p><a href="logout.php">Logout</a></p>';

              }
              logout();
              function addNewEntry(){
                  echo'<p><a href="add.php">Add New Entry</a></p>';

              }
              function editAndDelete(){
                  echo '<a href="edit.php?profile_id='.$_SESSION['profile_id'].'">| Edit |</a> <a href="delete.php?profile_id='.$_SESSION['profile_id'].'">Delete</a>';

              }



            }
     else{
            echo '<div class="container">';


            echo '<p><a href="login.php">Please log in</a></p>';



         }




            echo '<table border="1">';
            echo '<tr>';
            echo '<th>Name</th>';

            echo '<th>Headline</th>';
            echo '<th>Action</th></tr>';

            try{
               $con= new PDO("mysql:host=localhost;dbname=courseraassignment","root","");//We made the connection via pdo

    //First of all you need to submit the html form
               $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $data=$con->prepare("select * from profile");
                $data->execute(array(
                ));


               foreach($data as $row){
                    $firstName=$row['first_name'];
                    $lastName=$row['last_name'];
                    $_SESSION['profile_id']=$row['profile_id'];
                    $fullName=$firstName." ".$lastName;

                        echo "<tr>";
                        echo "<td>$fullName</td>";
                        echo '<td>'.$row['headline'].'</td>';
                        echo "<td>";


                        echo '<a href="view.php?profile_id='.$_SESSION['profile_id'].'">View</a>';
                   if (isset($_SESSION['princeLogin'])){
                       editAndDelete();

                   }

                             
                               

                       echo "</td>";
                                          
                       echo "</tr>";






               }




                     }catch(PDOException $e){
                         echo "error".$e->getMessage();
                     }







            echo '</table>';

        if (isset($_SESSION['princeLogin'])){
            addNewEntry();


        }


?>
               <p>
                  Note: Your implementation should retain data across multiple
                   logout/login sessions.  This sample implementation clears all its
                  data periodically - which you should not do in your implementation.
                 </p>;




         </div>


           </body>


</html>