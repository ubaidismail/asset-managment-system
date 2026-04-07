<?php
require_once '../init.php';


$select_type = 'SELECT types.*, c1.name as category_name FROM types left join categories c1 on types.cat_id = c1.id where types.status = 1 order by types.id desc';
$query_run = mysqli_query($conn, $select_type);
$rows = mysqli_fetch_all($query_run, MYSQLI_ASSOC);

if (isset($_GET['type_del'])) {
    $type_del = $_GET['type_del'];
    $delete_sql = 'Update types set status = 0 where id = ' . $type_del;
    if (mysqli_query($conn, $delete_sql)) {
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    } else {
        echo 'Error deleting type: ' . mysqli_error($conn);
    }
}
include '../inc/header.php';
?>
<!-- need to get the type and the category -->
<div class="container">
    <div class="list-ams">
        <div class="top-btn d-flex justify-content-end mb-3 ">
            <a href="add-type.php" class="btn btn-dark d-inline-flex justify-content-end">Add Types</a>
        </div>
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
                            <td><a href="edit-type.php?id=<?php echo $row['id']; ?>">Edit</a> - <a href="<?php echo $_SERVER['PHP_SELF'] ?>?type_del=<?php echo $row['id']; ?>">Delete</a></td>
                        </tr>
                <?php
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php
include '../inc/footer.php';
?>