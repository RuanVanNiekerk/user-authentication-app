<?php
session_start();
$searchOptions = "";
function addTable($sortTarget){
    if(isset($_POST["order"])){
        updateTable();
    }elseif(isset($_POST["searchBar"])){
        $searchVal = $_POST["searchBar"];
        searchResults($searchVal);
    }elseif(isset($_POST["changeEntry"])){
        changeRecord();
    }else{
        fillTable('ASC', $sortTarget);
    }
}

if(isset($_POST['showBooks'])){
    $_SESSION['openTable'] = $_POST['showBooks'];
}elseif(isset($_POST['showAuthors'])){
    $_SESSION['openTable'] = $_POST['showAuthors'];
}elseif(isset($_POST['showMembers'])){
    $_SESSION['openTable'] = $_POST['showMembers'];
}

var_dump($_SESSION);

function fillTable($sortType='ASC', $sortTarget='book_name'){
    include 'connectServer.php';
    
    if($_SESSION["currentMemb"] == "Member"){
        $sql = "SELECT book_name, year, books.genre, age_group, authors.author_name "
                . "FROM books "
                . "LEFT JOIN authors ON books.author_id = authors.author_id "
                . "ORDER BY ".$sortTarget." ".$sortType.";";
        $result = $conn->query($sql);// Storing select query in a variable

        // Check if query was successful
        if($result){
            // Check if rows exist in selected table
            if($result->num_rows > 0){
                // Create an HTML table
                echo "<table>";
                echo "<tr>";
                    // Dispay the column names
                    echo "<th>Book Name</th>";
                    echo "<th>Year</th>";
                    echo "<th>Genre</th>";
                    echo "<th>Age Group</th>";
                    echo "<th>Author</th>";
                    echo "</tr>";
                while($row = $result->fetch_assoc()) {// Loop through the columns array
                    echo "<tr>";
                    // Dispay the column values, using the array
                    echo "<td>" . $row["book_name"]. "</td>";
                    echo "<td>" . $row["year"]. "</td>";
                    echo "<td>" . $row["genre"]. "</td>";
                    echo "<td>" . $row["age_group"]. "</td>";
                    echo "<td>" . $row["author_name"]. "</td>";
                    echo "</tr>";
                  }
                echo "</table>";
            }
        } else {
            echo "Error selecting table " . $conn->error;
        }
    }elseif($_SESSION["currentMemb"] == "Librarian"){
        echo '  <form method="post" action="">
                    <input type="submit" value="Books" name="showBooks">
                    <input type="submit" value="Authors" name="showAuthors">
                    <input type="submit" value="Members" name="showMembers">
                </form></br>';
        if($_SESSION['openTable'] == 'Authors'){
            $sql = "SELECT author_name, age "
                    . "FROM authors "
                . "ORDER BY ".$sortTarget." ".$sortType.";";
            $result = $conn->query($sql);// Storing select query in a variable
            // Check if query was successful
            if($result){
                // Check if rows exist in selected table
                if($result->num_rows > 0){
                    // Create an HTML table
                    echo "<table>";
                    echo "<tr>";
                    // Display the column names
                    echo "<th>Author</th>";
                    echo "<th>Author Age</th>";
                    echo "</tr>";

                    echo "<form method='post' action=''>";
                    echo "<input type='hidden' name='order'/>";//used to check if form was posted
                    echo "<tr>";
                    // Display the order options
                    echo "<td>Order: <input type='submit' value='A-Z' name='authASC'/> <input type='submit' value='Z-A' name='authDESC'/></td>";
                    echo "<td>Order: <input type='submit' value='ASC' name='authAgeASC'/> <input type='submit' value='DESC' name='authAgeDESC'/></td>";
                    echo "</tr>";
                    echo "</form>";

                    while($row = $result->fetch_assoc()) {// Loop through the columns array
                        echo "<form method='post' action=''>";
                        echo "<input type='hidden' name='changeEntry' value='".$row["author_name"]."'/>";//used to check if form was posted
                        echo "<input type='hidden' name='changeType' value='authors'/>";
                        echo "<tr>";
                        // Dispay the column values, using the array
                        echo "<td>" . $row["author_name"]. "</td>";
                        echo "<td>" . $row["age"]. "</td>";
                        echo "<td><input type='submit' value='Edit' name='Edit'/></td>";
                        echo "<td><input type='submit' value='Delete' name='Delete'/></td>";
                        echo "</tr>";
                        echo "</form>";
                      }
                    echo "</table>";
                }
            } else {
                echo "Error selecting table " . $conn->error;
            }
        }elseif($_SESSION['openTable'] == 'Members'){
            $sql = "SELECT name, membership "
                    . "FROM members "
                . "ORDER BY ".$sortTarget." ".$sortType.";";
            $result = $conn->query($sql);// Storing select query in a variable
            // Check if query was successful
            if($result){
                // Check if rows exist in selected table
                if($result->num_rows > 0){
                    // Create an HTML table
                    echo "<table>";
                    echo "<tr>";
                    // Display the column names
                    echo "<th>Member</th>";
                    echo "<th>Membership</th>";
                    echo "</tr>";

                    echo "<form method='post' action=''>";
                    echo "<input type='hidden' name='order'/>";//used to check if form was posted
                    echo "<tr>";
                    // Display the order options
                    echo "<td>Order: <input type='submit' value='A-Z' name='authASC'/> <input type='submit' value='Z-A' name='authDESC'/></td>";
                    echo "<td>Order: <input type='submit' value='ASC' name='authAgeASC'/> <input type='submit' value='DESC' name='authAgeDESC'/></td>";
                    echo "</tr>";
                    echo "</form>";

                    while($row = $result->fetch_assoc()) {// Loop through the columns array
                        echo "<form method='post' action=''>";
                        echo "<input type='hidden' name='changeEntry' value='".$row["name"]."'/>";//used to check if form was posted
                        echo "<input type='hidden' name='changeType' value='members'/>";
                        echo "<tr>";
                        // Dispay the column values, using the array
                        echo "<td>" . $row["name"]. "</td>";
                        echo "<td>" . $row["membership"]. "</td>";
                        echo "<td><input type='submit' value='Edit' name='Edit'/></td>";
                        echo "<td><input type='submit' value='Delete' name='Delete'/></td>";
                        echo "</tr>";
                        echo "</form>";
                      }
                    echo "</table>";
                }
            } else {
                echo "Error selecting table " . $conn->error;
            }
        }else{
            $sql = "SELECT book_name, year, books.genre, age_group, author_name, age "
                    . "FROM books "
                    . "LEFT JOIN authors ON books.author_id = authors.author_id "
                    . "ORDER BY ".$sortTarget." ".$sortType.";";
            $result = $conn->query($sql);// Storing select query in a variable
            // Check if query was successful
            if($result){
                // Check if rows exist in selected table
                if($result->num_rows > 0){
                    // Create an HTML table
                    echo "<table>";
                    echo "<tr>";
                    // Display the column names
                    echo "<th>Book Name</th>";
                    echo "<th>Year</th>";
                    echo "<th>Genre</th>";
                    echo "<th>Age Group</th>";
                    echo "<th>Author</th>";
                    echo "<th>Author Age</th>";
                    echo "</tr>";

                    echo "<form method='post' action=''>";
                    echo "<input type='hidden' name='order'/>";//used to check if form was posted
                    echo "<tr>";
                    // Display the order options
                    echo "<td>Order: <input type='submit' value='A-Z' name='bookASC'/> <input type='submit' value='Z-A' name='bookDESC'/></td>";
                    echo "<td>Order: <input type='submit' value='ASC' name='yearASC'/> <input type='submit' value='DESC' name='yearDESC'/></td>";
                    echo "<td>Order: <input type='submit' value='A-Z' name='genreASC'/> <input type='submit' value='Z-A' name='genreDESC'/></td>";
                    echo "<td>Order: <input type='submit' value='ASC' name='ageASC'/> <input type='submit' value='DESC' name='ageDESC'/></td>";
                    echo "<td>Order: <input type='submit' value='A-Z' name='authASC'/> <input type='submit' value='Z-A' name='authDESC'/></td>";
                    echo "<td>Order: <input type='submit' value='ASC' name='authAgeASC'/> <input type='submit' value='DESC' name='authAgeDESC'/></td>";
                    echo "</tr>";
                    echo "</form>";

                    while($row = $result->fetch_assoc()) {// Loop through the columns array
                        echo "<form method='post' action=''>";
                        echo "<input type='hidden' name='changeEntry' value='".$row["book_name"]."'/>";//used to check if form was posted
                        echo "<tr>";
                        // Dispay the column values, using the array
                        echo "<td>" . $row["book_name"]. "</td>";
                        echo "<td>" . $row["year"]. "</td>";
                        echo "<td>" . $row["genre"]. "</td>";
                        echo "<td>" . $row["age_group"]. "</td>";
                        echo "<td>" . $row["author_name"]. "</td>";
                        echo "<td>" . $row["age"]. "</td>";
                        echo "<td><input type='submit' value='Edit' name='Edit'/></td>";
                        echo "<td><input type='submit' value='Delete' name='Delete'/></td>";
                        echo "</tr>";
                        echo "</form>";
                      }
                    echo "</table>";
                }
            } else {
                echo "Error selecting table " . $conn->error;
            }
        }
    }
}

function updateTable(){
    //Order Table when ASC or DESC is clicked
    if(isset($_POST["order"])){
        foreach (array_keys($_POST) as $index){
            if(strpos($index,'ASC')==true){
                switch ($index){
                    case "bookASC":
                        $sortType = 'ASC';
                        $sortTarget = 'books.book_name';
                        fillTable($sortType, $sortTarget);
                        break;
                    case "yearASC":
                        $sortType = 'ASC';
                        $sortTarget = 'books.year';
                        fillTable($sortType, $sortTarget);
                        break;
                    case "genreASC":
                        $sortType = 'ASC';
                        $sortTarget = 'books.genre';
                        fillTable($sortType, $sortTarget);
                        break;
                    case "ageASC":
                        $sortType = 'ASC';
                        $sortTarget = 'books.age_group';
                        fillTable($sortType, $sortTarget);
                        break;
                    case "authASC":
                        $sortType = 'ASC';
                        $sortTarget = 'authors.author_name';
                        fillTable($sortType, $sortTarget);
                        break;
                    case "authAgeASC":
                        $sortType = 'ASC';
                        $sortTarget = 'authors.age';
                        fillTable($sortType, $sortTarget);
                        break;
                }
            }elseif(strpos($index,'DESC')==true){
                switch ($index){
                    case "bookDESC":
                        $sortType = 'DESC';
                        $sortTarget = 'books.book_name';
                        fillTable($sortType, $sortTarget);
                        break;
                    case "yearDESC":
                        $sortType = 'DESC';
                        $sortTarget = 'books.year';
                        fillTable($sortType, $sortTarget);
                        break;
                    case "genreDESC":
                        $sortType = 'DESC';
                        $sortTarget = 'books.genre';
                        fillTable($sortType, $sortTarget);
                        break;
                    case "ageDESC":
                        $sortType = 'DESC';
                        $sortTarget = 'books.age_group';
                        fillTable($sortType, $sortTarget);
                        break;
                    case "authDESC":
                        $sortType = 'DESC';
                        $sortTarget = 'authors.author_name';
                        fillTable($sortType, $sortTarget);
                        break;
                    case "authAgeDESC":
                        $sortType = 'DESC';
                        $sortTarget = 'authors.age';
                        fillTable($sortType, $sortTarget);
                        break;
                }
            }
        }
    }
}

function searchResults($searchVal){
    include 'connectServer.php';
    
    if($_SESSION["currentMemb"] == "Member"){
        $sql = "SELECT book_name, year, genre, age_group "
                . "FROM books "
                . "WHERE book_name LIKE '%".$searchVal."%' ;";
        $result = $conn->query($sql);// Storing select query in a variable

        // Check if query was successful
        if($result){
            // Check if rows exist in selected table
            if($result->num_rows > 0){
                // Create an HTML table
                echo "<table>";
                echo "<tr>";
                    // Dispay the column names
                    echo "<th>Book Name</th>";
                    echo "<th>Year</th>";
                    echo "<th>Genre</th>";
                    echo "<th>Age Group</th>";
                    echo "</tr>";
                while($row = $result->fetch_assoc()) {// Loop through the columns array
                    echo "<tr>";
                    // Dispay the column values, using the array
                    echo "<td>" . $row["book_name"]. "</td>";
                    echo "<td>" . $row["year"]. "</td>";
                    echo "<td>" . $row["genre"]. "</td>";
                    echo "<td>" . $row["age_group"]. "</td>";
                    echo "</tr>";
                  }
                echo "</table>";
            } else {
                echo '<script type="text/javascript">';
                echo ' alert("There are no records that match what you searched")';
                echo '</script>';
                filltable();
            }
        } else {
            echo "Error selecting table " . $conn->error;
        }
    }elseif($_SESSION["currentMemb"] == "Librarian"){
        $sql = "SELECT book_name, year, books.genre, age_group, author_name, age "
                . "FROM books "
                . "LEFT JOIN authors ON books.author_id = authors.author_id "
                . "WHERE book_name LIKE '%".$searchVal."%' OR author_name LIKE '%".$searchVal."%';";
        $result = $conn->query($sql);// Storing select query in a variable

        // Check if query was successful
        if($result){
            // Check if rows exist in selected table
            if($result->num_rows > 0){
                // Create an HTML table
                echo "<table>";
                echo "<tr>";
                // Display the column names
                echo "<th>Book Name</th>";
                echo "<th>Year</th>";
                echo "<th>Genre</th>";
                echo "<th>Age Group</th>";
                echo "<th>Author</th>";
                echo "<th>Author Age</th>";
                echo "</tr>";
                                    
                while($row = $result->fetch_assoc()) {// Loop through the columns array
                    echo "<form method='post' action=''>";
                    echo "<input type='hidden' name='changeEntry' value='".$row["book_name"]."'/>";//used to check if form was posted
                    echo "<tr>";
                    // Dispay the column values, using the array
                    echo "<td>" . $row["book_name"]. "</td>";
                    echo "<td>" . $row["year"]. "</td>";
                    echo "<td>" . $row["genre"]. "</td>";
                    echo "<td>" . $row["age_group"]. "</td>";
                    echo "<td>" . $row["author_name"]. "</td>";
                    echo "<td>" . $row["age"]. "</td>";
                    echo "<td><input type='submit' value='Edit' name='Edit'/></td>";
                    echo "<td><input type='submit' value='Delete' name='Delete'/></td>";
                    echo "</tr>";
                    echo "</form>";
                  }
                echo "</table>";
            } else {
                echo '<script type="text/javascript">';
                echo ' alert("There are no records that match what you searched")';
                echo '</script>';
                filltable();
            }
        } else {
            echo "Error selecting table " . $conn->error;
        }
        
    }
}

function changeRecord(){
    if(isset($_POST["Edit"])){
        include 'connectServer.php';
        
        if($_POST['changeType']=='authors'){
            $sql = "SELECT author_name, age, genre "
                    . "FROM authors "
                    . "WHERE author_name = '".$_POST['changeEntry']."';";
            $result = $conn->query($sql);// Storing select query in a variable

            // Check if query was successful
            if($result){            
                while($row = $result->fetch_assoc()) {// Loop through the columns array
                    echo "<form method='post' action=''>";
                    echo "<input type='hidden' name='changeEntry' value='".$row["author_name"]."'/>";//used to check if form was posted
                    echo "<label>Name:<input type='text' name='newAuth' value ='" . $row["author_name"]. "' ></input ></label></br>";
                    echo "<label>Age:<input type='text' name='newAge' value ='" . $row["age"]. "' ></input ></label></br>";
                    echo "<label>Genre:<input type='text' name='newGenre' value ='" . $row["genre"]. "' ></input ></label></br>";
                    echo "<input class='submit' type='submit' value='Save' name='SaveNew'/>";
                    echo "</form>";
                  }
            }else{
                echo "Error selecting table " . $conn->error;
            }
        }elseif($_POST['changeType']=='members'){
            $sql = "SELECT name, membership "
                    . "FROM members "
                    . "WHERE name = '".$_POST['changeEntry']."';";
            $result = $conn->query($sql);// Storing select query in a variable

            // Check if query was successful
            if($result){            
                while($row = $result->fetch_assoc()) {// Loop through the columns array
                    echo "<form method='post' action=''>";
                    echo "<input type='hidden' name='changeEntry' value='".$row["name"]."'/>";//used to check if form was posted
                    echo "<label>Genre:<input type='text' name='newName' value ='" . $row["name"]. "' ></input ></label></br>";
                    echo "<label>Age Group:<input type='text' name='newMembership' value ='" . $row["membership"]. "' ></input ></label></br>";
                    echo "<input class='submit' type='submit' value='Save' name='SaveNew'/>";
                    echo "</form>";
                  }
            }else{
                echo "Error selecting table " . $conn->error;
            }
        }else{
            $sql = "SELECT book_name, year, books.genre, age_group, author_name, age "
                . "FROM books "
                . "LEFT JOIN authors ON books.author_id = authors.author_id "
                . "WHERE book_name = '".$_POST['changeEntry']."';";
            $result = $conn->query($sql);// Storing select query in a variable

            // Check if query was successful
            if($result){            
                while($row = $result->fetch_assoc()) {// Loop through the columns array
                    echo "<form method='post' action=''>";
                    echo "<input type='hidden' name='changeEntry' value='".$row["book_name"]."'/>";//used to check if form was posted
                    echo "<input type='hidden' name='changeType' value='books'/>";
                    echo "<label>Name:<input type='text' name='newName' value ='" . $row["book_name"]. "' ></input ></label></br>";
                    echo "<label>Year:<input type='text' name='newYear' value ='" . $row["year"]. "' ></input ></label></br>";
                    echo "<label>Genre:<input type='text' name='newGenre' value ='" . $row["genre"]. "' ></input ></label></br>";
                    echo "<label>Age Group:<input type='text' name='newAgeGroup' value ='" . $row["age_group"]. "' ></input ></label></br>";
                    echo "<input class='submit' type='submit' value='Save' name='SaveNew'/>";
                    echo "</form>";
                  }
            }else{
                echo "Error selecting table " . $conn->error;
            }
        }
        
    }elseif(isset ($_POST["SaveNew"])){ //saves new values
        include 'connectServer.php';
        
        if($_POST['changeType']=='authors'){
            $sql = "UPDATE authors "
                . "SET author_name = '".$_POST['newAuth']."', age = '".$_POST['newAge']."', genre = '".$_POST['newGenre']."' "
                . "WHERE author_name = '".$_POST['changeEntry']."';";
            $result = $conn->query($sql);// Storing select query in a variable

            // Check if query was successful
            if($result){            
                fillTable();
            }else{
                echo "Error selecting table " . $conn->error;
            }
        }elseif($_POST['changeType']=='members'){
            $sql = "UPDATE members "
                . "SET name = '".$_POST['newName']."', membership = '".$_POST['newMembership']."' "
                . "WHERE name = '".$_POST['changeEntry']."';";
            $result = $conn->query($sql);// Storing select query in a variable

            // Check if query was successful
            if($result){            
                fillTable();
            }else{
                echo "Error selecting table " . $conn->error;
            }
        }else{
           $sql = "UPDATE books "
                . "SET book_name = '".$_POST['newName']."', year = '".$_POST['newYear']."', books.genre = '".$_POST['newGenre']."'"
                . ", age_group = '".$_POST['newAgeGroup']."' "
                . "WHERE book_name = '".$_POST['changeEntry']."';";
            $result = $conn->query($sql);// Storing select query in a variable

            // Check if query was successful
            if($result){            
                fillTable();
            }else{
                echo "Error selecting table " . $conn->error;
            } 
        }
        
    }elseif(isset($_POST["Delete"])){
        include 'connectServer.php';
        
        if($_POST['changeType']=='authors'){
            $sql = "DELETE FROM authors "
                  . "WHERE author_name = '".$_POST["changeEntry"]."';";
            $result = $conn->query($sql);// Storing select query in a variable

            // Check if query was successful
            if($result){
              fillTable(); 
            }else{
              echo "Error selecting table " . $conn->error;
            }
        }elseif($_POST['changeType']=='members'){
            $sql = "DELETE FROM members "
                  . "WHERE name = '".$_POST["changeEntry"]."';";
            $result = $conn->query($sql);// Storing select query in a variable

            // Check if query was successful
            if($result){
              fillTable(); 
            }else{
              echo "Error selecting table " . $conn->error;
            }
        }else{
            $sql = "DELETE FROM books "
                  . "WHERE book_name = '".$_POST["changeEntry"]."';";
            $result = $conn->query($sql);// Storing select query in a variable

            // Check if query was successful
            if($result){
              fillTable(); 
            }else{
              echo "Error selecting table " . $conn->error;
            }
        }
        
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
    <link href="https://fonts.googleapis.com/css2?family=Abril+Fatface&family=Lato&display=swap" rel="stylesheet">
    <title></title>
</head>
<body>
    <div class="container-parent">
        <div class="flex-container">
            <h1>Library Catalog</h1>
            <div class="flex-col" id="catalog">
                <a href="index.php">Log Out</a><br/>
                <form method='post' action=''>
                <input id="searchBar" class="input" type="text" name="searchBar" placeholder="Search For a Book..."/>
                <input class="submit" type="submit" value="search">
                </form>
                <div id="table">
                    <?php
                        if($_SESSION['openTable'] == 'Books'){
                            addTable('book_name');
                        }elseif($_SESSION['openTable'] == 'Authors'){
                            addTable('author_name');
                        }elseif($_SESSION['openTable'] =='Members'){
                            addTable('name');
                        }
                        
                    ?>                    
                </div>
            </div>
        </div>
    </div>    
</body>
</html>