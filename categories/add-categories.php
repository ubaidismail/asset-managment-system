<?php
require_once '../init.php';
include '../inc/header.php';

$success_mess = '';
$error_mess = '';
if(isset($_POST['submit_cat_form'])){
    $name = $_POST['cat_name'];
    
    $insert_query = $conn->prepare("INSERT INTO categories (name) values (?)");
    $insert_query->bind_param('s', $name);
    if($insert_query->execute()){
        $success_mess = 'Category Inserted';
    }else{
        $error_mess = 'Error:' . $insert_query->error;
    }
}

?>


<div class="container">
    <div class="cat-add-form">
    <form method="POST" action="">
    <div class="form-group">
        <label for="cat_name">Category Name</label>
        <input type="text" class="form-control" id="cat_name" name="cat_name" placeholder="Enter Category name">
    </div>

    <button type="submit" name="submit_cat_form" class="btn btn-primary mt-4">Submit</button>
   
  <?php if(!empty($success_mess)): ?>
    <span class="alert alert-success d-block"><?php echo $success_mess; ?></span>
<?php endif; ?>

<?php if(!empty($error_mess)): ?>
    <span class="alert alert-danger d-block"><?php echo $error_mess; ?></span>
<?php endif; ?>
</form>
    </div>
</div>