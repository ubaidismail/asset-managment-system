<?php
include 'db/connection.php';
include 'inc/header.php';

$select_type = 'SELECT i1.*, c1.name as category_name, t1.name as type_name 
                FROM items i1 
                left join categories c1 on i1.category_id = c1.id 
                left join types t1 on i1.type_id = t1.id;';
$query_run = mysqli_query($conn, $select_type);
$rows = mysqli_fetch_all($query_run, MYSQLI_ASSOC);

?>

<div class="container">
    <div class="items-lists">
        <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
            Add Items
        </button>
        <table class="table">
            <?php
             if (!empty($rows)) {
                ?>
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Item Name</th>
                    <!-- <th scope="col">Item Description</th> -->
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
                            <td><?php echo $row['name']; ?> </td>
                            <!-- <td><?php echo $row['item_description']; ?> </td> -->
                            <td><?php echo $row['category_name']; ?> </td>
                            <td><?php echo $row['type_name']; ?> </td>
                            <td><img src="uploads/<?php echo $row['image']; ?>" alt="Item Image" width="100" height="100" style="object-fit:contain;"></td>
                            <td><a href="#">View</a> - <a href="#">Edit</a> - <a href="#">Delete</a></td>
                        </tr>
                <?php
                    }
                
                ?>
            </tbody>
        </table>
        <?php
             } else {
                echo '<span class="alert alert-info d-block mt-4">No Items Found</span>';
             }
             ?>
    </div>

    <!-- Modal -->
    <?php include 'inc/modals/forms/items/add-items.php'; ?>

</div>


<?php

include 'inc/footer.php';
?>