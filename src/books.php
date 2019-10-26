<?php
    require 'config.php'
?>

<!DOCTYPE html>

<head>
    <title>Insert data to PostgreSQL with php - creating a simple web application</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        li {
            list-style: none;
        }
    </style>
</head>

<body>
    <h2>Enter information regarding book</h2>
    <ul>
        <form name="insert" action="books.php" method="POST">
            <li>Book Name:</li>
            <li><input type="text" name="book_name" /></li>
            <li>Author:</li>
            <li><input type="text" name="author" /></li>
            <li>Publisher:</li>
            <li><input type="text" name="publisher" /></li>
            <li>Price (USD):</li>
            <li><input type="text" name="price" /></li>
            <li>Date of publication:</li>
            <li><input type="date" name="dop" /></li>
            <li><input type="submit" name="submit"/></li>
        </form>
    </ul>
</body>

</html>
<?php
if(isset($_POST['submit'])){
    if($db){
        echo "success";
    }else{
        echo "failed";
    }
    $query = "INSERT INTO books (book_name,author,publisher,price,dop) VALUES ('$_POST[book_name]',
    '$_POST[author]','$_POST[publisher]',
    '$_POST[price]', '$_POST[dop]')";
    $result = pg_query($query); 

    if($result){
        echo "success2";
    }else{
        echo "fail2";
    }
}

?>