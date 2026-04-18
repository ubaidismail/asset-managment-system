<?php
require_once 'init.php';
// $select_type = 'SELECT i1.*, c1.FullName as category_name, t1.FullName as type_name 
//                 FROM DigiInventoryItems i1 
//                 left join DigiInventoryCategories c1 on i1.CategoryID = c1.CategoryID 
//                 left join DigiInventoryTypes t1 on i1.TypeID = t1.TypeID where i1.status = 1 order by i1.ItemID desc limit 100';
$get_items = Item::getAll(100, 0);


// $rows = mysqli_fetch_all($query_run, MYSQLI_ASSOC);
// var_dump($rows);
if (isset($_GET['item_del'])) {
    $item_id = $_GET['item_del'];
    $delete_sql = Item::item_delete($item_id);
    if ($delete_sql) {
        header('Location: ' . $_SERVER['PHP_SELF']);
    } else {
        die('Error deleting item');
    }
}

include 'inc/header.php';

include 'inc/modals/forms/items/add-items.php';
?>

<div class="container">
    <div class="items-lists">
        <div class="top-btn d-flex justify-content-end mb-3 ">
            <button type="button" class="btn btn-dark " data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                Add Items
            </button>
        </div>
        <!--  -->
        <div class="row">
            <div class="col-md-3">
                <?php include 'inc/filter/filter-items.php'; ?>

            </div>
            <div class="col-md-9">
                <table class="table" id="table_list">
                    <?php
                    if (!empty($get_items)) {
                    ?>
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Asset Code</th>
                                <th scope="col">Item Name</th>
                                <th scope="col">Item Image</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 0;
                            foreach ($get_items as $row) {
                                $count++;
                            ?>
                                <tr>
                                    <td><?php echo $count; ?> </td>
                                    <td class="bebas-neue-bold"><?php echo $row['Barcode']; ?></td>
                                    <td><?php echo $row['FullName']; ?> </td>
                                    <td><img src="<?php echo $row['Picture']; ?>" alt="Item Image" width="100" height="100" style="object-fit:contain;"></td>
                                    <td>
                                        <a href="items/view-items.php?id=<?php echo $row['ItemID']; ?>" class="btn btn-sm btn-dark">View</a>
                                        <a href="?item_del=<?php echo $row['ItemID']; ?>" class="btn btn-sm btn-danger">Delete</a>
                                    </td>
                                </tr>
                            <?php
                            }

                            ?>
                        </tbody>
                </table>
            </div>
        </div>
    <?php
                    } else {
                        echo '<span class="alert alert-info d-block mt-4">No Items Found</span>';
                    }
    ?>
    </div>


</div>

<script>
    let table;

    $(document).ready(function() {

        // Initial (client-side)
        table = $('#table_list').DataTable({
            serverSide: false
        });

        $('#filter_by_cat, #filter_by_type, #filter_by_material, #filter_by_brand, #filter_by_location').on('change', function() {

            let category_id = $('#filter_by_cat').val();
            let type_id = $('#filter_by_type').val();
            let material_id = $('#filter_by_material').val();
            let brand = $('#filter_by_brand').val();
            let item_location = $('#filter_by_location').val();


            table.destroy();

            //  reinitialize with serverSide true
            table = $('#table_list').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: 'inc/fetchitems.php',
                    type: 'POST',
                    data: {
                        category_id: category_id,
                        type_id: type_id,
                        material_id: material_id,
                        brand: brand,
                        item_location: item_location
                    }
                },
                columns: [{
                        data: 'count'
                    },
                    {
                        data: 'asset_code'
                    },
                    {
                        data: 'name'
                    },
                    // {
                    //     data: 'category_name'
                    // },
                    // {
                    //     data: 'type_name'
                    // },
                    {
                        data: 'image'
                    },
                    {
                        data: 'action'
                    }
                ]

            });

        });

    });
</script>
<?php

include 'inc/footer.php';
?>