<?php
require_once 'init.php';
$select_type = 'SELECT i1.*, c1.name as category_name, t1.name as type_name 
                FROM inventory_items i1 
                left join inventory_categories c1 on i1.category_id = c1.id 
                left join inventory_types t1 on i1.type_id = t1.id where i1.status = 1 order by i1.id desc limit 100';
$query_run = mysqli_query($conn, $select_type);
$rows = mysqli_fetch_all($query_run, MYSQLI_ASSOC);

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
                    if (!empty($rows)) {
                    ?>
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Asset Code</th>
                                <th scope="col">Item Name</th>
                                <th scope="col">Item Category</th>
                                <th scope="col">Item Type</th>
                                <th scope="col">Item Image</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 0;
                            foreach ($rows as $row) {
                                $count++;
                            ?>
                                <tr>
                                    <td><?php echo $count; ?> </td>
                                    <td class="bebas-neue-bold"><?php echo $row['asset_code']; ?></td>
                                    <td><?php echo $row['name']; ?> </td>
                                    <td><?php echo $row['category_name']; ?> </td>
                                    <td><?php echo $row['type_name']; ?> </td>
                                    <td><img src="uploads/<?php echo $row['image']; ?>" alt="Item Image" width="100" height="100" style="object-fit:contain;"></td>
                                    <td><a href="items/view-items.php?id=<?= $row['id'] ?>"

                                            class="btn btn-sm btn-dark">View</a>
                                        <a href="<?php $_SERVER['PHP_SELF'] ?>?item_del=<?= $row['id'] ?>" class="btn btn-sm btn-danger">Delete</a>
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
                    {
                        data: 'category_name'
                    },
                    {
                        data: 'type_name'
                    },
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