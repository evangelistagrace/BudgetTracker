<!-- <?php

pg_connect("dbname=book user=postgres password=413506") or die("Couldn't Connect ".pg_last_error()); // Connect to the Database
/* Use the Query */
$query = pg_query("INSERT INTO books (bookname, bookauthor) VALUES ('Alice in Wonderland', 'Carol Lewis') ");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <?php $query2 = pg_query("SELECT * FROM books") ?>
    <?php while($result = pg_fetch_array($query2)): ?>
        <p><?php echo $result['bookname'] ?></p>
    <?php endwhile ?>
</body>
</html> -->