<?php
include '../init.php';

// 1. Get parameters
$category_id = isset($_POST['category_id']) ? $_POST['category_id'] : '';
$type_id = isset($_POST['type_id']) ? $_POST['type_id'] : '';
$material_id = isset($_POST['material_id']) ? $_POST['material_id'] : '';
$brand = isset($_POST['brand']) ? $_POST['brand'] : '';
// $item_location = isset($_POST['item_location']) ? $_POST['item_location'] : '';
$draw = isset($_POST['draw']) ? intval($_POST['draw']) : 1;
$start = isset($_POST['start']) ? intval($_POST['start']) : 0;
$length = isset($_POST['length']) ? intval($_POST['length']) : 10;

// 2. Build the base query for counting total records
$sql_total = "SELECT COUNT(*) as total FROM items WHERE status = 1";
$where_conditions = [];
$params = [];
$types = "";

if (!empty($category_id)) {
    $where_conditions[] = "category_id = ?";
    $params[] = $category_id;
    $types .= "i";
}
if (!empty($type_id)) {
    $where_conditions[] = "type_id = ?";
    $params[] = $type_id;
    $types .= "i";
}
if (!empty($material_id)) {
    $where_conditions[] = "material_id = ?";
    $params[] = $material_id;
    $types .= "i";
}
if (!empty($brand)) {
    $where_conditions[] = "brand = ?";
    $params[] = $brand;
    $types .= "s";
}


if (!empty($where_conditions)) {
    $sql_total .= " AND " . implode(" AND ", $where_conditions);
}

$stmt_total = mysqli_prepare($conn, $sql_total);
if (!empty($params)) {
    mysqli_stmt_bind_param($stmt_total, $types, ...$params);
}
mysqli_stmt_execute($stmt_total);
$result_total = mysqli_stmt_get_result($stmt_total);
$row_total = mysqli_fetch_assoc($result_total);
$recordsTotal = $row_total['total'];
$recordsFiltered = $recordsTotal;

// 3. Build the main query with LIMIT for pagination

$sql = "SELECT
            items.*,
            categories.name AS category_name,
            types.name AS type_name
        FROM items
        LEFT JOIN categories ON items.category_id = categories.id
        LEFT JOIN types ON items.type_id = types.id
        WHERE items.status = 1";

if (!empty($where_conditions)) {
    $sql .= " AND " . implode(" AND ", $where_conditions);
}

$sql .= " ORDER BY items.id DESC LIMIT ?, ?";

$stmt = mysqli_prepare($conn, $sql);
if (!$stmt) {
    die(json_encode(["error" => "Prepare failed: " . mysqli_error($conn) . " SQL: " . $sql]));
}
$bind_params = $params;
$bind_params[] = $start;
$bind_params[] = $length;
$bind_types = $types . "ii";
if (!empty($bind_params)) {
    mysqli_stmt_bind_param($stmt, $bind_types, ...$bind_params);
}
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Handle SQL errors
if (!$result) {
    die(json_encode(["error" => mysqli_error($conn)]));
}

$data = [];
$count = $start + 1;
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = [
        "count"         => $count++,
        "asset_code"    => '<span class="bebas-neue-bold">' . $row['asset_code'] . '</span>',
        "name"          => $row['name'],
        "category_name" => $row['category_name'] ?? 'N/A',
        "type_name"     => $row['type_name'] ?? 'N/A',
        "image" => '<img src="uploads/'.$row['image'].'" width="100" height="100" style="object-fit:contain;">',
        "action" => '
            <a href="items/view-items.php?id='.$row['id'].'" class="btn btn-sm btn-dark">View</a>
            <a href="?item_del='.$row['id'].'" class="btn btn-sm btn-danger">Delete</a>
        '
    ];
}

// 4. Return the data
echo json_encode([
    "draw" => $draw,
    "recordsTotal" => $recordsTotal,
    "recordsFiltered" => $recordsFiltered,
    "data" => $data
]);