<?php
require_once '../../init.php';

$get_stock = 'SELECT ij.*, i1.name as item_name FROM inventory_join_items ij left join inventory_items i1 on ij.item_id = i1.id where ij.status = 1 order by ij.id desc';
$query_run = mysqli_query($conn, $get_stock);
$rows = mysqli_fetch_all($query_run, MYSQLI_ASSOC);


include '../../inc/modals/forms/inventory/stock/add-stock.php';
include '../../inc/header.php';

?>
<!-- need to get the type and the category -->
<div class="container">
    <div class="list-ams">
        <div class="top-btn d-flex justify-content-end mb-3 ">
            <button type="button" class="btn btn-dark " data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                Add Asset
            </button>
        </div>
        <table class="table" id="table_list">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Asset Name</th>
                    <th scope="col">Barcode</th>
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
                            <td><?php echo $row['barcode_id']; ?> </td>
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

<script>
    let table;

    $(document).ready(function() {

        // Initial (client-side)
        table = $('#table_list').DataTable({
            serverSide: false
        });
    });
</script>

<?php
include '../../inc/footer.php';
?>