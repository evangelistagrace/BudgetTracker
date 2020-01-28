<?php


$mainArr = array();

$dataArr = ['1','2','3','5'];
$dataArr2 = ['2','4','3','5'];


$arr1 = array(
    "label" => "Groceries",
    "data" => $dataArr
);

$arr2 = array(
    "label" => "Food",
    "data" => $dataArr2
);

array_push($mainArr, $arr1);
array_push($mainArr, $arr2);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Testing</title>
</head>
<body>
    

    <script>
        var mainArr = <?php echo json_encode($mainArr, JSON_PRETTY_PRINT) ?>;

        console.log( mainArr[1].data[2] );
    </script>
</body>
</html>