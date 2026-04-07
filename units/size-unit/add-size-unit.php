<?php
require_once '../init.php';
include '../inc/header.php';

$success_mess = '';
$error_mess = '';
if (isset($_POST['submit_unit_form'])) {
    $name = $_POST['unit_name'];
    $symbol = $_POST['unit_symbol'];

    // condition check for duplicate unit name or symbol
    $select = $conn->prepare('SELECT id FROM size_units where name = ? or symbol = ?');
    $select->bind_param('ss', $name, $symbol);
    $select->execute();
    $select->store_result();
    if ($select->num_rows > 0) {
        $error_mess = 'Unit Name or Symbol already exists';
    } else {

        $insert_query = $conn->prepare('INSERT INTO size_units (name, symbol) values (?, ?)');
        $insert_query->bind_param('ss', $name, $symbol);
        if ($insert_query->execute()) {
            $success_mess = 'Size Unit Inserted';
        } else {
            $error_mess = 'Error:' . $insert_query->error;
        }
    }
}

?>

<div class="container">
    <div class="cat-add-form">

        <form method="POST" action="">
            <div class="form-group">
                <label for="unit_name">Unit Name</label>
                <input type="text" class="form-control" id="unit_name" name="unit_name" placeholder="Centimeter, Inch, Feet etc." required>
            </div>

            <div class="form-group">
                <label for="unit_symbol">Unit Symbol</label>
                <input type="text" class="form-control" id="unit_symbol" name="unit_symbol" placeholder="cm, in, ft etc." required>
            </div>

            <button type="submit" name="submit_unit_form" class="btn btn-primary mt-4">Submit</button>

            <?php if (!empty($success_mess)): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php echo $success_mess; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if (!empty($error_mess)): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?php echo $error_mess; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
        </form>
    </div>
</div>