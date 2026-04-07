<?php
require_once '../init.php';


$get_materials = Materials::getAll();

$get_materials = 'SELECT materials.*, t1.name as type_name FROM materials left join types t1 on materials.type_id = t1.id where materials.status = 1 order by materials.id desc';
$query_run = mysqli_query($conn, $get_materials);
$rows = mysqli_fetch_all($query_run, MYSQLI_ASSOC);

if (isset($_GET['material_del'])) {
    $material_id = $_GET['material_del'];
    $delete_sql = 'Update materials set status = 0 where id = ' . $material_id;
    if (mysqli_query($conn, $delete_sql)) {
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    } else {
        echo 'Error deleting materials: ' . mysqli_error($conn);
    }
}

include '../inc/header.php';

?>
<!-- need to get the type and the category -->
<div class="container">
    <div class="list-ams">
         <div class="top-btn d-flex justify-content-end mb-3 ">
        <a href="add-materials.php" class="btn btn-dark d-inline-flex justify-content-end">Add Materials</a>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Material</th>
                    <th scope="col">Type</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($rows)) {
                    $count = 0;
                    foreach ($rows as $material) {
                        $count++;
                ?>
                        <tr>
                            <td><?php echo $count; ?> </td>
                            <td><?php echo $material['name']; ?> </td>
                            <td><?php echo $material['type_name']; ?> </td>
                            <td><a href="edit-material.php?id=<?php echo $material['id']; ?>">Edit</a> - <a href="<?php echo $_SERVER['PHP_SELF']?>?material_del=<?php echo $material['id']; ?>">Delete</a></td>
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