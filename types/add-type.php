<?php
include '../db/connection.php';
include '../inc/header.php';

$get_cats = 'SELECT * FROM categories';
$query_run = mysqli_query($conn, $get_cats);
$rows = mysqli_fetch_all($query_run, MYSQLI_ASSOC);

$success_mess = '';
$error_mess = '';
if (isset($_POST['submit_type_form'])) {
    $name = $_POST['type_name'];
    $type_description = $_POST['type_description'];
    $cat_id = $_POST['cat_id'];

    $insert_query = $conn->prepare('INSERT INTO types (name, type_description, cat_id) values (?,?,?)');
    $insert_query->bind_param('ssi', $name, $type_description, $cat_id);
    if ($insert_query->execute()) {
        $success_mess = 'Category Inserted';
    } else {
        $error_mess = 'Error:' . $insert_query->error;
    }
}

?>


<div class="container">
    <div class="cat-add-form">

        <form method="POST" action="">
            <div class="form-group">
                <label for="item_name">Type Category</label>
                <select class="form-select form-select-sm" name="cat_id" id="cat_id">
                    <option value="">___Select Category___</option>
                    <?php
                    if (!empty($rows)) {
                        $count = 0;
                        foreach ($rows as $row) {
                            $id = $row['id'];
                            $name = $row['name'];
                    ?>
                            <option value="<?php echo $id; ?>"><?php echo $name; ?></option>
                    <?php
                        }
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="type_name">Type Name</label>
                <input type="text" class="form-control" id="type_name" name="type_name" placeholder="Enter Type name">
            </div>
            <div class="form-group">
                <label for="type_description">Type Description</label>
                <input type="text" class="form-control" id="type_description" name="type_description" placeholder="Enter Type desc">
            </div>



            <button type="submit" name="submit_type_form" class="btn btn-primary mt-4">Submit</button>

            <?php if (!empty($success_mess)): ?>
                <span class="alert alert-success d-block"><?php echo $success_mess; ?></span>
            <?php endif; ?>

            <?php if (!empty($error_mess)): ?>
                <span class="alert alert-danger d-block"><?php echo $error_mess; ?></span>
            <?php endif; ?>
        </form>
    </div>
</div>