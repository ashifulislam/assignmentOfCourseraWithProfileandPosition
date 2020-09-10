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
    <h1>Please Log In</h1>
     <span class="text-danger">
        <span class="text-danger">
        <?php
        if(isset($login_error))
            echo $login_error;
        ?>
    </span>
     </span>
    <form method="POST" action="login.php">
        <label for="email">Email</label>
        <input type="text" name="email" id="email"><br/>
        <label for="id_1723">Password</label>
        <input type="password" name="pass" id="pass"><br/>
        <input type="submit" name="login" onclick="return doValidate();" value="Log In">
        <input type="submit" name="cancel" value="Cancel">
    </form>
    <p>
        For a password hint, view source and find an account and password hint
        in the HTML comments.
        <!-- Hint:
        The account is umsi@umich.edu
        The password is the three character name of the
        programming language used in this class (all lower case)
        followed by 123. -->
    </p>
    <script>
        function doValidate() {
            console.log('Validating...');
            try {
                addr = document.getElementById('email').value;
                pw = document.getElementById('pass').value;
                console.log("Validating addr="+addr+" pw="+pw);
                if (addr == null || addr == "" || pw == null || pw == "") {
                    alert("Both fields must be filled out");
                    return false;
                }

                if ( addr.indexOf('@') == -1 ) {
                    alert("Invalid email address");
                    return false;
                }
                return true;
            } catch(e) {
                return false;
            }
            return false;
        }
    </script>


</div>

<?php
try{
    $con= new PDO("mysql:host=localhost;dbname=courseraassignment","root","");//We made the connection via pdo

    //First of all you need to submit the html form
    if(isset($_POST['login'])){

        $email=$_POST['email'];//Fetch the value from input field
        $password=$_POST['pass'];//Fetch the value from input field
        $salt="XyZzy12*_";
        $check = hash('md5', $salt.$password);
        $stmt = $con->prepare('SELECT * FROM users
        WHERE email = :em AND password = :pw');
        $stmt->execute(array( ':em' => $_POST['email'], ':pw' => $check));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if(empty($email) || empty($password)){
                echo 'All fields are required';

        }
        else if ( $row !== false ) {
            // Redirect the browser to index.php
            $_SESSION['email']=$row['email'];//For further working procedure
            $_SESSION['user_id']=$row['user_id'];
            //For further working procedure
            echo $_SESSION['user_id'];
            $_SESSION['princeLogin']="youAreLoggedIn";

            header("Location: index.php");
        }
        else{
            echo 'invalid login credentials';
        }


    }else{
        echo "invalid attempt";
    }
    }catch(PDOException $e){
    echo "error".$e->getMessage();
    }


?>

</body>
