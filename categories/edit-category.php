<?php
require_once '../init.php';
include '../inc/header.php';

$success_mess = '';
$error_mess = '';
$cat_data = [];
if(isset($_GET['id'])){
    $cat_id = $_GET['id'];

    $get_by_id = Categories::find($cat_id);
    if(!$get_by_id){
        die('Category not found');
    }else{
        $cat_data = $get_by_id;
    }
}
if(isset($_POST['update_cat_form'])){
    $cat_name = mysqli_real_escape_string($conn, $_POST['cat_name'] ?? '');
    $cat_desc = mysqli_real_escape_string($conn, $_POST['cat_desc'] ?? '');

    if(empty($cat_name) || empty($cat_desc)){
        $error_mess = 'All fields are required';
    }else{
        $update_sql = "UPDATE categories SET name='$cat_name', description='$cat_desc' WHERE id = {$cat_data['id']}";
        if(mysqli_query($conn, $update_sql)){
            $success_mess = 'Category updated successfully';
            // Refresh the category data
            $cat_data = Categories::find($cat_data['id']);
        }else{
            $error_mess = 'Error updating category: ' . mysqli_error($conn);
        }
    }
}
?>


<div class="container">
    <div class="cat-add-form">
    <form method="POST" action="">
    <div class="form-group">
        <label for="cat_name">Category Name</label>
        <input type="text" class="form-control" id="cat_name" name="cat_name" value="<?= htmlspecialchars($cat_data['name'] ?? '') ?>" placeholder="Enter Category name">
    </div>
    <div class="form-group">
        <label for="cat_desc">Category Description</label>
        <input type="text" class="form-control" id="cat_desc" name="cat_desc" value="<?= htmlspecialchars($cat_data['description'] ?? '') ?>" placeholder="Enter Category description">
    </div>

    <button type="submit" name="update_cat_form" class="btn btn-primary mt-4">Submit</button>
   
  <?php if(!empty($success_mess)): ?>
    <span class="alert alert-success d-block"><?php echo $success_mess; ?></span>
<?php endif; ?>

<?php if(!empty($error_mess)): ?>
    <span class="alert alert-danger d-block"><?php echo $error_mess; ?></span>
<?php endif; ?>
</form>
    </div>
</div>