<?php
include 'connectServer.php';

if(isset($_POST['user'])){
    if($_POST['password']==$_POST['confPassword']){
        $name = $_POST['user'];
        $userPassword = $_POST['password'];

        $sql = "UPDATE members "
               . "SET password = '$userPassword' "
               . "WHERE name = '$name'";

        // Check whether insert was successful
        if ($conn->query($sql) === TRUE) {
            echo '<script type="text/javascript">';
            echo ' alert("The record has successfully been updated.")';  //not showing an alert box.
            echo '</script>';
        } else {
            echo '<script type="text/javascript">';
            echo ' alert('.$created.'"Error:'.$sql.' <br>"'.$conn->error;')';  //not showing an alert box.
            echo '</script>';
        }
    }else{
        echo '<script type="text/javascript">';
        echo ' alert("Please Confirm your Password.")';  //not showing an alert box.
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
    <title></title>
</head>
<body>
    <div class="container-parent">
        <div class="flex-container">
            <form class="flex-col" method="post">
                <h1>Reset Password</h1>
                <label for="user">Username: </label>
                <input class="input" name="user" type="text" required></br>
                <label for="password">New Password: </label>
                <input class="input" name="password" type="password" required></br>
                <label for="confPassword">Confirm Password: </label>
                <input class="input" name="confPassword" type="password" required></br>
                <input class="submit" type="submit"><br/>
                <a href="index.php">Return to Sign In</a>
            </form>            
        </div>
    </div>
</body>
</html>