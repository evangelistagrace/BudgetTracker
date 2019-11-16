<!DOCTYPE html>
<html lang="en">
<?php include 'head.php';require 'form-process.php'?>

<body>
    <form action="form.php" method="POST">
        <label for="name">Name:
            <input type="text" name="name" id="">
        </label>

        <label for="day">
        Day:
            <input type="text" name="day" id="">
        </label>

        <button type="submit" name="submit">Submit</button>
    </form>


    <table class="nurses">
        <?php $query = pg_query("SELECT * FROM nurses")?>
        <?php while($result = pg_fetch_array($query)): ?>
            <tr>
                <td><?php echo $result['remark'] ?></td>
                <td><?php echo $result['daynum'] ?></td>
            </tr>
        <?php endwhile ?>

    </table>
</body>
</html>