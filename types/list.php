<?php
include '../db/connection.php';
include '../inc/header.php';

$select_type = 'SELECT types.*, c1.name as category_name FROM types left join categories c1 on types.cat_id = c1.id ';
$query_run = mysqli_query($conn, $select_type);
$rows = mysqli_fetch_all($query_run, MYSQLI_ASSOC);

?>
<!-- need to get the type and the category -->
<div class="container">
    <div class="list-ams">
        <a href="add-type.php" class="btn btn-dark d-inline-flex justify-content-end">Add Types</a>
        <table class="table">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Category Name</th>
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
                        <td><?php echo $row['category_name']; ?> </td>
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