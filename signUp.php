<?php
include 'connectServer.php';

if(isset($_POST['newUser'])){
    if($_POST['password']==$_POST['confPassword']){
        $name = $_POST['newUser'];
        $userPassword = $_POST['password'];
        $membership = $_POST['userType'];

        $sql = "INSERT INTO members (name, password, membership)"
               . "VALUES ('$name', '$userPassword', '$membership')";

        // Check whether insert was successful
        if ($conn->query($sql) === TRUE) {
            echo '<script type="text/javascript">';
            echo ' alert("New record created successfully.")';  //not showing an alert box.
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
                <h1>Create a New Account</h1>
                <label for="newUser">Username: </label>
                <input class="input" name="newUser" type="text" required></br>
                <p>Account Type: </p>
                <input name="userType" type="radio" value="Member" required>
                <label for="userType">Member</label>
                <input name="userType" type="radio" value="Librarian" >
                <label for="userType">Librarian</label></br>
                <label for="password">Password: </label>
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