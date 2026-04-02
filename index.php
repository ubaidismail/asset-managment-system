<?php
include 'db/connection.php';
include 'inc/header.php';

$select_type = "SELECT i1.*, c1.name as category_name, t1.name as type_name 
                FROM items i1 
                left join categories c1 on i1.category_id = c1.id 
                left join types t1 on i1.type_id = t1.id;";
$query_run = mysqli_query($conn, $select_type);
$rows  = mysqli_fetch_all($query_run, MYSQLI_ASSOC);

?>

<div class="container">
    <div class="items-lists">
        <a href="items/add-items.php" class="btn btn-dark d-inline-flex justify-content-end">Add Items</a>
        <table class="table">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Item Name</th>
                <th scope="col">Item Description</th>
                <th scope="col">Item Category</th>
                <th scope="col">Item Type</th>
                <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
               <?php
               if(!empty($rows)){
                $count = 0;
                foreach($rows as $row){
                    $count ++;
                    ?>
                    <tr>
                        <td><?php echo $count; ?> </td>
                        <td><?php echo $row['name']; ?> </td>
                        <td><?php echo $row['item_description']; ?> </td>
                        <td><?php echo $row['category_name']; ?> </td>
                        <td><?php echo $row['type_name']; ?> </td>
                        <td><a href="#">View</a> - <a href="#">Edit</a> - <a href="#">Delete</a></td>
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

include 'inc/footer.php';
?>