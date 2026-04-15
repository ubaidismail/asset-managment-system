<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="/AMS/inc/assets/css/style.css">
  <title>EAM System</title>
  <link rel="stylesheet" href="//cdn.datatables.net/2.3.7/css/dataTables.dataTables.min.css">
  <script src="https://code.jquery.com/jquery-4.0.0.min.js"></script>
  <script src="//cdn.datatables.net/2.3.7/js/dataTables.min.js"></script>

  <!-- <script>
    document.querySelectorAll('.table').forEach(el => {
      new DataTable(el);
    });
  </script> -->
</head>
<!-- Mobile toggle button -->
<button class="btn btn-dark sidebar-toggler" id="sidebarToggler">
  <span class="navbar-toggler-icon"></span>
</button>
<nav class="sidebar" id="sidebar">

  <a href="http://localhost/AMS" class="sidebar-brand">EAM System</a>

  <div class="nav-group-label">Main</div>
  <ul class="nav flex-column">
    <li class="nav-item">
      <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : '' ?>" href="/AMS">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-seam" viewBox="0 0 16 16">
          <path d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5l2.404.961L10.404 2zm3.564 1.426L5.596 5 8 5.961 14.154 3.5zm3.25 1.7-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464z" />
        </svg>
        Items <?php echo '(' . count(Item::getAll()) . ')'; ?>
      </a>
    </li>
    <li class="nav-item dropdown inventory_dropdown">
      <a class="nav-link  <?= basename($_SERVER['PHP_SELF']) == 'list.php' && strpos($_SERVER['PHP_SELF'], 'inventory') ? 'active' : '' ?>  dropdown-toggle" href="javascript:void(0)" id="inventoryDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" href="/AMS/inventory/list.php">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-seam" viewBox="0 0 16 16">
          <path d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5l2.404.961L10.404 2zm3.564 1.426L5.596 5 8 5.961 14.154 3.5zm3.25 1.7-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464z" />
        </svg>
        Manage Inventory
      </a>
      <!-- sub items -->
       <ul class="dropdown-menu" aria-labelledby="inventoryDropdown">
        <li><a class="dropdown-item  ml-5" href="<?php echo URL_ROOT; ?>/inventory/list.php">Inventory</a></li>
        <li><a class="dropdown-item  ml-5" href="<?php echo URL_ROOT; ?>/inventory/stock/list.php">Assets </a></li>
      </ul>
    </li>
  </ul>

  <div class="nav-group-label">Settings</div>
  <ul class="nav flex-column">
    <li class="nav-item">
      <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'list.php' && strpos($_SERVER['PHP_SELF'], 'categories') ? 'active' : '' ?> " href="/AMS/categories/list.php">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-grid" viewBox="0 0 16 16">
          <path d="M1 2.5A1.5 1.5 0 0 1 2.5 1h3A1.5 1.5 0 0 1 7 2.5v3A1.5 1.5 0 0 1 5.5 7h-3A1.5 1.5 0 0 1 1 5.5zm8 0A1.5 1.5 0 0 1 10.5 1h3A1.5 1.5 0 0 1 15 2.5v3A1.5 1.5 0 0 1 13.5 7h-3A1.5 1.5 0 0 1 9 5.5zm-8 8A1.5 1.5 0 0 1 2.5 9h3A1.5 1.5 0 0 1 7 10.5v3A1.5 1.5 0 0 1 5.5 15h-3A1.5 1.5 0 0 1 1 13.5zm8 0A1.5 1.5 0 0 1 10.5 9h3A1.5 1.5 0 0 1 15 10.5v3A1.5 1.5 0 0 1 13.5 15h-3A1.5 1.5 0 0 1 9 13.5z" />
        </svg>
        Categories <?php echo '(' . count(Categories::getAll()) . ')'; ?>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link <?= strpos($_SERVER['PHP_SELF'], 'types') ? 'active' : '' ?>" href="/AMS/types/list.php">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-list-ul" viewBox="0 0 16 16">
          <path fill-rule="evenodd" d="M5 11.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m-3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2m0 4a1 1 0 1 0 0-2 1 1 0 0 0 0 2m0 4a1 1 0 1 0 0-2 1 1 0 0 0 0 2" />
        </svg>
        Types <?php echo '(' . count(Types::getAll()) . ')'; ?>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link <?= strpos($_SERVER['PHP_SELF'], 'materials') ? 'active' : '' ?>" href="/AMS/materials/list.php">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-list-ul" viewBox="0 0 16 16">
          <path fill-rule="evenodd" d="M5 11.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m-3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2m0 4a1 1 
          0 1 0 0-2 1 1 0 0 0 0 2m0 4a1 1 0 1 0 0-2 1 1 0 0 0 0 2" />
        </svg>
        Materials <?php echo '(' . count(Materials::getAll()) . ')'; ?>
      </a>
    </li>
   

    <li class="nav-item dropdown units_dropdown">
      <a class="nav-link dropdown-toggle" href="javascript:void(0)" id="unitsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-list-ul" viewBox="0 0 16 16">
          <path fill-rule="evenodd" d="M5 11.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m-3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2m0 4a1 1 0 1 0 0-2 1 1 0 0 0 0 2m0 4a1 1 0 1 0 0-2 1 1 0 0 0 0 2" />
        </svg>
        Units
      </a>
      <ul class="dropdown-menu" aria-labelledby="unitsDropdown">
        <li><a class="dropdown-item  ml-5" href="<?php echo URL_ROOT; ?>/units/size-unit/list.php">Size Units</a></li>
        <li><a class="dropdown-item  ml-5" href="<?php echo URL_ROOT; ?>/units/weight-unit/list.php">Weight Units</a></li>
      </ul>
    </li>


  </ul>

</nav>

<!-- Main content wrapper — wrap all your page content in this -->
<div class="main-content">
  <!-- your page content here -->
</div>


<body>