<?php
require_once '../../init.php';
include '../../inc/header.php';

$rows = WeightUnits::getAll();

?>
<!-- need to get the type and the category -->
<div class="container">
    <div class="list-ams">
        <div class="top-btn d-flex justify-content-end mb-3 ">
            <a href="<?php echo URL_ROOT ?>/units/weight-unit/add-weight-unit.php" class="btn btn-dark d-inline-flex justify-content-end">Add Weight Units</a>
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
                            <td><?php echo $row['name']; ?> </td>
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

<?php
// include '../inc/footer.php';
?>