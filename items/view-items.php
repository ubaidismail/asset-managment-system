<?php
require_once '../init.php';
include '../inc/header.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    die('No item specified.');
}

$sql = "SELECT i.*, 
        c.name AS category_name, 
        t.name AS type_name,
        m.name AS material_name,
        ic.name AS condition_name,
        su.symbol AS size_unit,
        wu.symbol AS weight_unit
        FROM inventory_items i
        LEFT JOIN inventory_categories c ON i.category_id = c.id
        LEFT JOIN inventory_types t ON i.type_id = t.id
        LEFT JOIN inventory_materials m ON i.material_id = m.id
        LEFT JOIN inventory_item_conditions ic ON i.item_condition = ic.id
        LEFT JOIN size_units su ON i.size_unit = su.id
        LEFT JOIN weight_units wu ON i.weight_unit = wu.id
        WHERE i.id = ?";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    die('Prepare failed: ' . $conn->error);
}
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
$item = $result->fetch_assoc();

if (!$item) {
    die('Item not found.');
}
?>

<div class="main-content">
    <div class="container py-4">

        <!-- Image -->


        <!-- Basic Info -->
        <h6 class="text-muted fw-semibold mb-3 border-bottom pb-2">Basic Information</h6>
        <div class="row align-items-center">
            <div class="col-md-4">
                <div class="row g-3 mb-4 ">
                    <div class="col-md-6">
                        <small class="text-muted d-block">Item Name</small>
                        <span><?= htmlspecialchars($item['name']) ?></span>
                    </div>
                    <div class="col-md-6">
                        <small class="text-muted d-block">Description</small>
                        <span><?= htmlspecialchars($item['item_description'] ?? '—') ?></span>
                    </div>
                    <div class="col-md-6">
                        <small class="text-muted d-block">Category</small>
                        <span><?= htmlspecialchars($item['category_name'] ?? '—') ?></span>
                    </div>
                    <div class="col-md-6">
                        <small class="text-muted d-block">Type</small>
                        <span><?= htmlspecialchars($item['type_name'] ?? '—') ?></span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="row g-3 mb-4">


                    <div class="col-md-6">
                        <small class="text-muted d-block">Serial Number</small>
                        <span><?= htmlspecialchars($item['serial_number'] ?? '—') ?></span>
                    </div>
                    <div class="col-md-6">
                        <small class="text-muted d-block">Brand</small>
                        <span><?= htmlspecialchars($item['brand'] ?? '—') ?></span>
                    </div>
                    <div class="col-md-6">
                        <small class="text-muted d-block">Model</small>
                        <span><?= htmlspecialchars($item['model'] ?? '—') ?></span>
                    </div>
                    <div class="col-md-6">
                        <small class="text-muted d-block">Condition</small>
                        <span><?= htmlspecialchars($item['condition_name'] ?? '—') ?></span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-6">
                        <?php if (!empty($item['image'])): ?>
                            <div class="text-center mb-4">
                                <img src="/AMS/uploads/<?= htmlspecialchars($item['image']) ?>"
                                    class="img-fluid rounded" id="asset_img" style="max-height: 250px;"">
                            </div>
                            <div id="myModal" class="asset_image_modal">

                                <!-- The Close Button -->
                                <span class="close">&times;</span>

                                <!-- Modal Content (The Image) -->
                                <img class="asset-image-modal-content" id="img01">

                                <!-- Modal Caption (Image Text) -->
                                <div id="caption"></div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>


        <!-- Physical Properties -->
        <h6 class="text-muted fw-semibold mb-3 border-bottom pb-2">Physical Properties</h6>
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <small class="text-muted d-block">Material</small>
                <span><?= htmlspecialchars($item['material_name'] ?? '—') ?></span>
            </div>
            <div class="col-md-6">
                <small class="text-muted d-block">Color</small>
                <span><?= htmlspecialchars($item['color'] ?? '—') ?></span>
            </div>
            <div class="col-md-6">
                <small class="text-muted d-block">Dimensions</small>
                <span>
                    <?php if (!empty($item['size_width'])): ?>
                        <?= $item['size_width'] ?> x
                        <?= $item['size_height'] ?> x
                        <?= $item['size_depth'] ?>
                        <?= $item['size_unit'] ?>
                    <?php else: ?>
                        —
                    <?php endif; ?>
                </span>
            </div>
            <div class="col-md-6">
                <small class="text-muted d-block">Weight</small>
                <span>
                    <?= !empty($item['item_weight'])
                        ? $item['item_weight'] . ' ' . $item['weight_unit']
                        : '—' ?>
                </span>
            </div>
            <div class="col-md-6">
                <small class="text-muted d-block">Adjustable</small>
                <span>
                    <?php if ($item['is_adjustable'] === null): ?>
                        —
                    <?php elseif ($item['is_adjustable'] == 1): ?>
                        <span class="badge bg-success">Yes</span>
                    <?php else: ?>
                        <span class="badge bg-secondary">No</span>
                    <?php endif; ?>
                </span>
            </div>
        </div>

        <!-- Purchase Info -->
        <!-- <h6 class="text-muted fw-semibold mb-3 border-bottom pb-2">Purchase Information</h6> -->
        <div class="row g-3 mb-4">
            <!-- <div class="col-md-6">
                <small class="text-muted d-block">Purchase Date</small>
                <span><?= !empty($item['purchase_date']) ? date('d M Y', strtotime($item['purchase_date'])) : '—' ?></span>
            </div> -->
            <!-- <div class="col-md-6">
                <small class="text-muted d-block">Purchase Price</small>
                <span><?= !empty($item['purchase_price']) ?  'QAR ' . number_format($item['purchase_price'], 2) : '—' ?></span>
            </div> -->
            <!-- <div class="col-md-6">
                <small class="text-muted d-block">Warranty Expiry</small>
                <span><?= !empty($item['warranty_expiry']) ? date('d M Y', strtotime($item['warranty_expiry'])) : '—' ?></span>
            </div> -->
        </div>

        <!-- Maintenance -->
        <!-- <h6 class="text-muted fw-semibold mb-3 border-bottom pb-2">Maintenance</h6> -->
        <div class="row g-3 mb-4">
            <!-- <div class="col-md-6">
                <small class="text-muted d-block">Last Maintenance</small>
                <span><?= !empty($item['last_maintenance_date']) ? date('d M Y', strtotime($item['last_maintenance_date'])) : '—' ?></span>
            </div>
            <div class="col-md-6">
                <small class="text-muted d-block">Next Maintenance</small>
                <span><?= !empty($item['next_maintenance_date']) ? date('d M Y', strtotime($item['next_maintenance_date'])) : '—' ?></span>
            </div> -->
        </div>

        <!-- Status & Location -->
        <h6 class="text-muted fw-semibold mb-3 border-bottom pb-2">Comments & Location</h6>
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <small class="text-muted d-block">Location</small>
                <span><?= htmlspecialchars($item['item_location'] ?? '—') ?></span>
            </div>
            <!-- <div class="col-md-6">
                <small class="text-muted d-block">Lifecycle Status</small>
                <?php
                $status_colors = [
                    'active'          => 'success',
                    'in-repair'       => 'warning',
                    'in-storage'      => 'info',
                    'decommissioned'  => 'danger',
                ];
                $status = $item['life_cycle_status'] ?? '';
                $badge  = $status_colors[$status] ?? 'secondary';
                ?>
                <span class="badge bg-<?= $badge ?>"><?= ucfirst($status) ?: '—' ?></span>
            </div> -->
            <div class="col-md-12">
                <small class="text-muted d-block">Notes</small>
                <span><?= htmlspecialchars($item['notes'] ?? '—') ?></span>
            </div>
        </div>

        <!-- Timestamps -->
        <div class="row g-3">
            <div class="col-md-6">
                <small class="text-muted d-block">Created At</small>
                <span class="text-muted" style="font-size:0.85rem;">
                    <?= !empty($item['created_at']) ? date('d M Y, h:i A', strtotime($item['created_at'])) : '—' ?>
                </span>
            </div>
            <div class="col-md-6">
                <small class="text-muted d-block">Updated At</small>
                <span class="text-muted" style="font-size:0.85rem;">
                    <?= !empty($item['updated_at']) ? date('d M Y, h:i A', strtotime($item['updated_at'])) : '—' ?>
                </span>
            </div>
        </div>

    </div>
</div>

<script>
    var modal = document.getElementById("myModal");

    // Get the image and insert it inside the modal - use its "alt" text as a caption
    var img = document.getElementById("asset_img");
    var modalImg = document.getElementById("img01");
    img.onclick = function() {
        modal.style.display = "block";
        modalImg.src = this.src;
    }

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    }
</script>

<?php
include '../inc/footer.php';
?>