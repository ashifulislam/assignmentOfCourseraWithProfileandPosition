<?php
session_start();
$profile_id=$_GET['profile_id'];
$user_id=$_SESSION['user_id'];


?>
<?php
function validate_profile(){

    if(strlen($_POST['first_name'])==0 || strlen($_POST['last_name'])==0 || strlen($_POST['email'])==0 || strlen($_POST['headline']) ==0 || strlen($_POST['summary']) == 0){
        return 'All fields are required';

    }
    if (!strpos($_POST['email'], "@") === true) {
        return 'Email address must contain @';
    }
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
<?php
function load_position(){

}
load_position();


//        echo '<tr>
//                        <td>'.$fullName.'</td>
//                        <td>'.$row['headline'].'</td>
//                        <td>
//                <a href="edit.php?profile_id=5765">Edit |</a> <a href="delete.php?profile_id=5765">Delete</a>
//                <a href="view.php">View</a></td>
//                     </tr>';











?>
<?php
try{
    //Need to make a connection
    $con=new PDO("mysql:host=localhost;dbname=courseraassignment","root","");


    $statement=$con->prepare("select * from profile
                       where profile_id=:profile_id");
    $statement->execute(array(
        ':profile_id'=>$profile_id
    ));
    foreach($statement as $row){
        $firstName=$row['first_name'];
        $lastName=$row['last_name'];
        $Email=$row['email'];
        $Headline=$row['headline'];
        $Summary=$row['summary'];


//        echo '<tr>
//                        <td>'.$fullName.'</td>
//                        <td>'.$row['headline'].'</td>
//                        <td>
//                <a href="edit.php?profile_id=5765">Edit |</a> <a href="delete.php?profile_id=5765">Delete</a>
//                <a href="view.php">View</a></td>
//                     </tr>';





    }















}catch(PDOException $e){
    echo "error".$e->getMessage();
}

?>
<?php
    if(isset($_POST['first_name'])){

        $first_name=htmlentities($_POST['first_name']);
        $last_name=htmlentities($_POST['last_name']);
        $email=htmlentities($_POST['email']);
        $headline=htmlentities($_POST['headline']);
        $summary=htmlentities($_POST['summary']);
        $msg=validate_profile();
        if(is_string($msg)){
            $_SESSION['profile_error']=$msg;
            header("location:edit.php?profile_id=".$_REQUEST['profile_id']);
            return;
        }




            $stmt=$con->prepare(" UPDATE profile SET user_id=:user_id,
                first_name=:first_name,last_name=:last_name,email=:email,headline=:headline,
                summary=:summary WHERE profile_id=:profile_id");

            $stmt->execute(array(
                    ':user_id'=>$user_id,
                    ':first_name'=>$first_name,
                    ':last_name'=>$last_name,
                    ':email'=>$email,
                    ':headline'=>$headline,
                    ':summary'=>$summary,
                    ':profile_id'=>$profile_id
            ));
            $_SESSION['profile_edition']='Profile Updated';
            header('location:index.php');

    }


?>



<body>
<div class="container">
    <h1>Ashiful Islam Prince's Resume Registry</h1>


    <h1>Editing Profile for UMSI</h1>
    <?php
    if(isset($_SESSION['profile_error'])) {
    $error = $_SESSION['profile_error'];
    unset($_SESSION["profile_error"]);


    echo '<span class="text-danger">';


           echo $error;


           echo '</span>';
    }
    ?>
    <form method="post">
        <p>First Name:
            <input type="text" name="first_name" value="<?php
            echo $firstName;
            ?>"
              ></p><br>

        <p>Last Name:
            <input type="text" name="last_name" value="<?php
            echo $lastName;
            ?>"</p>

        <p>Email:
            <input type="text" name="email" value="<?php
            echo $Email;
            ?>"</p><br>
        <span class="text-danger">
            <?php
            if(isset($email_sign_error))
                echo $email_sign_error;

            ?>
        </span>


        <p>Headline:<br/>
            <input type="text" name="headline" value="<?php
            echo $Headline;
            ?>"</p>


        <p>Summary:<br/>
            <textarea name="summary" rows="8" cols="80">
                <?php
                echo $Summary;

                ?>
            </textarea>
        <p>Position : <input type="submit"  class="add_position" id="add_position" name="addPosition" value="+">

        <div class="position_fields" id="position_fields">

        </div>
        <?php
            $con=new PDO("mysql:host=localhost;dbname=courseraassignment","root","");

            $statement=$con->prepare("select * from position 
                       where profile_id=:profile_id ORDER BY rank");
            $statement->execute(array(
                ':profile_id'=>$_REQUEST['profile_id']
            ));

            foreach($statement as $row) {



            }


            ?>


        <p>
            <input type="submit" value="Save" name="btn" class="btn btn-primary">
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
            <textarea  name="desc'+countPos+'" rows="8" cols="80"></textarea>\
            </div>');
        });
    });




</script>

</body>
</html>
