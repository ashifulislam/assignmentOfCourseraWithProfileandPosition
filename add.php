<?php
session_start();

$user_id=$_SESSION['user_id'];

?>
<?php
//Here I validate the profile
function validate_profile(){
    if (strlen($_POST['first_name'])==0 || strlen($_POST['last_name'])==0 || strlen($_POST['email'])==0 || strlen($_POST['headline'])==0 || strlen($_POST['summary'])==0){
        return "All fields are required";

    }
   else if (!strpos($_POST['email'], "@") === true) {
        return 'Email address must contain @';
    }
}
function validate_position(){
    for($i=1; $i<9; $i++){
        if(! isset($_POST['year'.$i]))continue;
        if(! isset($_POST['desc'.$i]))continue;
        $year=$_POST['year'.$i];
        $desc=$_POST['desc'.$i];
        if(strlen($year)==0 || strlen($desc)==0){
            return "All fields are required";
        }
        else if(! is_numeric($year)){
            return 'year name must be numeric';
        }
    }
}


?>

<?php
    try{
        //Need to make a connection
        $con=new PDO("mysql:host=localhost;dbname=courseraassignment","root","");
        //You need to submit first the form
        if(isset($_POST['add'])) {
            //Fetch the value from the input field
            $firstName = htmlentities($_POST['first_name']);
            $lastName = htmlentities($_POST['last_name']);
            $email = htmlentities($_POST['email']);
            $headline = htmlentities($_POST['headline']);
            $summary = htmlentities($_POST['summary']);


            if(isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['email'])&&
            isset($_POST['headline']) && isset($_POST['summary'])){
                $msg=validate_profile();
                if(is_string($msg)){
                   $_SESSION['error_message']=$msg;
                   header('location:add.php');
                   return;

                }
               $msg=validate_position();
               if(is_string($msg)){
                    $_SESSION['error_message']=$msg;
                    header('location:add.php');
                    return;
                }


                    //insert to profile
                    //To create an insert query
                    $insert = $con->prepare("insert into profile(user_id,first_name,last_name,email,headline,summary)
                    values(:user_id,:firstName,:lastName,:email,:headline,:summary)");
                    //Here we need to bind those variable for storing value into the database
                    $insert->bindParam(':user_id', $user_id);
                    $insert->bindParam(':firstName', $firstName);
                    $insert->bindParam(':lastName', $lastName);
                    $insert->bindParam(':email', $email);
                    $insert->bindParam(':headline', $headline);
                    $insert->bindParam(':summary', $summary);
                    //Now need to execute the operation
                    $insert->execute();
                    $profile_id=$con->lastInsertId();

                    //insert to position
                    $rank=1;
                    for($i=1; $i<=9; $i++){
                        if(! isset($_POST['year'.$i])) continue;
                        if(! isset($_POST['desc'.$i])) continue;
                        $insert = $con->prepare("insert into position (profile_id,rank,year,description)
                         values(:profile_id,:rank,:year,:desc)");
                        //Here we need to bind those variable for storing value into the database
                        $insert->bindParam(':profile_id', $profile_id);
                        $insert->bindParam(':rank', $rank);
                        $insert->bindParam(':year', $_POST['year'.$i]);
                        $insert->bindParam(':desc', $_POST['desc'.$i]);

                        //Now need to execute the operation
                        $rank++;
                        $insert->execute();

                    }
                $_SESSION['profile_addition'] = 'Profile added';
                header("location:index.php");









            }











        }
    }catch(PDOException $e){
        echo "error".$e->getMessage();
    }

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


    <h1>Adding Profile for UMSI</h1>
    <?php

       if(isset($_SESSION['error_message'])) {
           $error = $_SESSION['error_message'];
           unset($_SESSION["error_message"]);


           echo '<span class="text-danger">';


           echo $error;


           echo '</span>';
       }


    ?>
    <form id="add_post" name="add_details" method="post" action="add.php">
        <p>First Name:
            <input type="text" name="first_name" size="60"/></p><br>

        <p>Last Name:
            <input type="text" name="last_name" size="60"/></p>

        <p>Email:
            <input type="text" name="email" size="30"/></p><br>
            <span class="text-danger">
                <?php
                if(isset($email_sign_error))
                   echo $email_sign_error;
                ?>
            </span>


        <p>Headline:<br/>
            <input type="text" name="headline" size="80"/></p>


        <p>Summary:<br/>
            <textarea name="summary" rows="8" cols="80"></textarea></p>

        <p>Position : <input type="submit"  class="add_position" id="add_position" name="addPosition" value="+">
           <div class="position_fields" id="position_fields">

           </div>
        </p>

        <p>
            <input type="submit" name="add" id="add_button" value="Add">
            <input type="submit" name="cancel" value="Cancel">
        </p>


    </form>

</div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        var countPos=0;
        var add_button=$('#add_position');
        var wrapper=$('#position_fields');
        window.console && console.log('Document ready called');
        $(add_button).click(function(event){
            // http://api.jquery.com/event.preventdefault/
            event.preventDefault();
            if ( countPos >=9 ) {
                alert("Maximum of nine position entries exceeded");
                return;
            }
            countPos++;
            window.console && console.log("Adding position "+countPos);
            $(wrapper).append(
                '<div id="position'+countPos+'"> \
            <p>Year: <input type="text" name="year'+countPos+'" value="" /> \
            <input type="button" value="-" \
                onclick="$(\'#position'+countPos+'\').remove();return false;"></p> \
            <textarea name="desc'+countPos+'" rows="8" cols="80"></textarea>\
            </div>');
        });
    });




</script>

</body>
</html>
