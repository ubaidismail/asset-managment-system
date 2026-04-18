<?php
require_once '../../init.php';

$get_asset = Assets::getAll();


include '../../inc/modals/forms/inventory/asset/add-asset.php';
include '../../inc/header.php';

?>
<!-- need to get the type and the category -->
<div class="container">
    <div class="list-ams">
        <div class="top-btn d-flex justify-content-end mb-3 ">
            <button type="button" class="btn btn-dark " data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                Add Asset
            </button>
        </div>
        <table class="table" id="table_list">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Asset Name</th>
                    <th scope="col">Asset Image</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($get_asset)) {
                    $count = 0;
                    foreach ($get_asset as $row) {
                        $count++;
                ?>
                        <tr>
                            <td><?php echo $count; ?> </td>
                            <td><?php echo $row['AssetsName']; ?> </td>
                            <td><img src="https://pers.tngqatar.online/<?php echo $row['AssetImage'] ?>" alt="Image" width="100"></td>
                            <td>
                                <!-- <a href="edit-inventory.php?id=<?php echo $row['AssetsID']; ?>">Edit</a> - <a href="<?php echo $_SERVER['PHP_SELF'] ?>?inventory_del=<?php echo $row['AssetsID']; ?>">Delete</a> -->
                            </td>
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
    let table;

    $(document).ready(function() {

        // Initial (client-side)
        table = $('#table_list').DataTable({
            serverSide: false
        });


        ///////////////////////////////
        ///////////////////////////////

        $('#item_id').select2({
            //   theme: 'bootstrap-5',
    width: '100%',
            templateResult: formatOption,
            templateSelection: formatOption
            
        });

        function formatOption(option) {
            if (!option.id) {
                return option.text;
            }

            let img = $(option.element).data('img');

            if (!img) {
                return option.text;
            }

            return $(`
        <span>
            <img src="${img}" style="width:30px;height:30px;margin-right:10px;border-radius:4px;">
            ${option.text}
        </span>
    `);
        }
    });
</script>

<?php
include '../../inc/footer.php';
?>