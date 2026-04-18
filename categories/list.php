<?php
require_once '../init.php';



$rows = Categories::getAll();

if (isset($_GET['cat_del'])) {
    $cat_id = $_GET['cat_del'];
    $delete_sql = Categories::category_delete($cat_id);
    if ($delete_sql) {
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    } else {
        echo 'Error deleting category: ' . mysqli_error($conn);
    }
}

include '../inc/header.php';
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
                            <td><?php echo $row['FullName']; ?> </td>
                            <td><a href="edit-category.php?id=<?php echo $row['CategoryID']; ?>">Edit</a> - <a href="<?php echo $_SERVER['PHP_SELF']; ?>?cat_del=<?php echo $row['CategoryID']; ?>">Delete</a></td>
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
    // confirmation before delete

    document.querySelectorAll('a[href*="cat_del"]').forEach(function(element) {
        element.addEventListener('click', function(event) {
            if (!confirm('Are you sure you want to delete this category?')) {
                event.preventDefault();
            }
        });
    });
</script>

<?php
include '../inc/footer.php';
?>