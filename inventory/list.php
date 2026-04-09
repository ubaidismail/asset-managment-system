<?php
require_once '../init.php';




$get_inventory = 'SELECT inventory.*, i1.name as item_name FROM inventory left join items i1 on inventory.item_id = i1.id where inventory.status = 1 order by inventory.id desc';
$query_run = mysqli_query($conn, $get_inventory);
$rows = mysqli_fetch_all($query_run, MYSQLI_ASSOC);

// if (isset($_GET['material_del'])) {
//     $material_id = $_GET['material_del'];
//     $delete_sql = 'Update materials set status = 0 where id = ' . $material_id;
//     if (mysqli_query($conn, $delete_sql)) {
//         header('Location: ' . $_SERVER['PHP_SELF']);
//         exit;
//     } else {
//         echo 'Error deleting materials: ' . mysqli_error($conn);
//     }
// }

include '../inc/header.php';
include '../inc/modals/forms/inventory/add-inventory.php';
?>
<!-- need to get the type and the category -->
<div class="container">
    <div class="list-ams">
        <div class="top-btn d-flex justify-content-end mb-3 ">
            <button type="button" class="btn btn-dark " data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                Add Inventory
            </button>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Inventory Name</th>
                    <th scope="col">Stock Quantity</th>
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
                            <td><?php echo $row['item_name']; ?> </td>
                            <td><?php echo $row['stock']; ?> </td>
                            <td><a href="edit-inventory.php?id=<?php echo $row['id']; ?>">Edit</a> - <a href="<?php echo $_SERVER['PHP_SELF'] ?>?inventory_del=<?php echo $row['id']; ?>">Delete</a></td>
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