<?php

if(isset($_POST['add-expense'])) {
    $categoryname = $_POST['category-name'];
    $expensetitle = $_POST['expense-title'];
    $expenseamount = $_POST['expense-amount'];
    $expensedate = $_POST['expense-date'];

    $query = pg_query("INSERT INTO expenses(categoryname, expensetitle, expenseamount, expensedate) VALUES ('$categoryname','$expensetitle', $expenseamount, '$expensedate') ");


}



?>