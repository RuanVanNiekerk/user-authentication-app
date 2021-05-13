<?php
session_start();
session_unset();

include 'connectServer.php';

if(isset($_POST["user"])){
    $searchName = $_POST['user'];
    $searchPass = $_POST['password'];    
    $sql = "SELECT name, password, membership "
            . "FROM members "
            . "WHERE name = '$searchName' AND password = '$searchPass'";
    $result = $conn->query($sql);
    
    if($result->num_rows > 0){
        while ($row = $result->fetch_assoc()){
            $_SESSION["currentMemb"] = $row["membership"];
        }
        $_SESSION["currentUser"] = $searchName;
        $_SESSION["currentPass"] = $searchPass;
        header("Location: library.php");
    }else{
        echo '<script type="text/javascript">';
        echo ' alert("Your Login Details are Invalid")';  //not showing an alert box.
        echo '</script>'; 
    }
    
}
?>
<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/styleSheet.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Girassol&family=Lato&display=swap" rel="stylesheet">
    <title></title>
</head>
<body>    
    <div class="container-parent">
        <div class="flex-container">
            <h1>The William Gibson Library</h1>
            <form class="flex-col" method="post" action="">
                <h2>Sign In</h2>
                <label class="label" for="user">Username: </label>
                <input class="input" name="user" type="text" required></br>
                <label class="label" for="password">Password: </label>
                <input class="input" name="password" type="password" required></br>
                <input class="submit" value="Sign In" type="submit" /></br></br>
                <a href="forgotPassword.php">Forgot your Password?</a></br></br>
                <a href="signUp.php">Create an Account</a>
            </form>            
        </div>
    </div>
</body>
</html>