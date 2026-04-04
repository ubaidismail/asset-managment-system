<?php
require_once '../init.php';
include '../inc/header.php';


$select_cat = "SELECT * FROM categories";
$query_run = mysqli_query($conn, $select_cat);
$rows  = mysqli_fetch_all($query_run, MYSQLI_ASSOC);

?>

<div class="container">
    <div class="list-ams">
        <div class="top-btn d-flex justify-content-end mb-3 ">
            <a href="add-categories.php" class="btn btn-dark d-inline-flex justify-content-end">Add Categories</a>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($rows)) {
                    $count = 0;
                    foreach ($rows as $row) {
                        $count++;
                ?>
                        <tr>
                            <td><?php echo $count; ?> </td>
                            <td><?php echo $row['name']; ?> </td>
                            <td><a href="#">Edit</a> - <a href="#">Delete</a></td>
                        </tr>
                <?php
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>