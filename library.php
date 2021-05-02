<?php
session_start();
$searchOptions = "";
function addTable(){
    if(isset($_POST["order"])){
        updateTable();
    }elseif(isset($_POST["searchBar"])){
        $searchVal = $_POST["searchBar"];
        searchResults($searchVal);
    }elseif(isset($_POST["changeEntry"])){
        changeRecord();
    }else{
        fillTable();
    }
}

function fillTable($sortType='ASC', $sortTarget='books.book_name'){
    include 'connectServer.php';
    
    if($_SESSION["currentMemb"] == "Member"){
        $sql = "SELECT book_name, year, genre, age_group "
                . "FROM books "
                . "ORDER BY ".$sortTarget." ".$sortType.";";
        $result = $conn->query($sql);// Storing select query in a variable

        // Check if query was successful
        if($result){
            // Check if rows exist in selected table
            if($result->num_rows > 0){
                echo "<form method='post' action=''>";
                echo '<input class="input" type="text" name="searchBar" placeholder="Search For a Book..."/>';
                echo '<input class="submit" type="submit">';
                echo "</form>";
                // Create an HTML table
                echo "<table>";
                echo "<tr>";
                    // Dispay the column names
                    echo "<td>Book Name</td>";
                    echo "<td>Year</td>";
                    echo "<td>Genre</td>";
                    echo "<td>Age Group</td>";
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
            }
        } else {
            echo "Error selecting table " . $conn->error;
        }
    }elseif($_SESSION["currentMemb"] == "Librarian"){
        $sql = "SELECT book_name, year, books.genre, age_group, author_name, age "
                . "FROM books "
                . "LEFT JOIN authors ON books.author_id = authors.author_id "
                . "ORDER BY ".$sortTarget." ".$sortType.";";
        $result = $conn->query($sql);// Storing select query in a variable
        // Check if query was successful
        if($result){
            // Check if rows exist in selected table
            if($result->num_rows > 0){
                echo "<form method='post' action=''>";
                echo '<input class="input" type="text" name="searchBar" placeholder="Search For a Book or Author..."/>';
                echo '<input class="submit" type="submit">';
                echo "</form>";
                // Create an HTML table
                echo "<table>";
                echo "<tr>";
                // Display the column names
                echo "<td>Book Name</td>";
                echo "<td>Year</td>";
                echo "<td>Genre</td>";
                echo "<td>Age Group</td>";
                echo "<td>Author</td>";
                echo "<td>Author Age</td>";
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
                echo "<form method='post' action=''>";
                echo '<input class="input" type="text" name="searchBar" placeholder="Search For a Book..."/>';
                echo '<input class="submit" type="submit">';
                echo "</form>";
                // Create an HTML table
                echo "<table>";
                echo "<tr>";
                    // Dispay the column names
                    echo "<td>Book Name</td>";
                    echo "<td>Year</td>";
                    echo "<td>Genre</td>";
                    echo "<td>Age Group</td>";
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
                echo "<form method='post' action=''>";
                echo '<input class="input" type="text" name="searchBar" placeholder="Search For a Book or Author..."/>';
                echo '<input class="submit" type="submit">';
                echo "</form>";
                // Create an HTML table
                echo "<table>";
                echo "<tr>";
                // Display the column names
                echo "<td>Book Name</td>";
                echo "<td>Year</td>";
                echo "<td>Genre</td>";
                echo "<td>Age Group</td>";
                echo "<td>Author</td>";
                echo "<td>Author Age</td>";
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
    }elseif(isset ($_POST["SaveNew"])){
        include 'connectServer.php';

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
    }elseif(isset($_POST["Delete"])){
        include 'connectServer.php';

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
            <div class="flex-col">
                <?php
                    addTable();
                ?>    
            </div>
        </div>
    </div>    
</body>
</html>