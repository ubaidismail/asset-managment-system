<div class="filters bg-light p-3 rounded">
    <h5 class="mb-3 d-flex align-items-center"><svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M3 4H21L14 12V20L10 22V12L3 4Z" stroke="#333333" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>Filters</h5>
    <div class="form-group">
        <label for="filter_by_cat">Filter by Category</label>
        <select class="form-select" name="filter_by_cat" id="filter_by_cat">
            <option value="">___Select Category___</option>
            <?php
            if (!empty($rows_cat)) {
                $count = 0;
                foreach ($rows_cat as $row) {
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
    <div class="form-group mt-2 mb-2">
        <label for="filter_by_type">Filter by Types</label>
        <select class="form-select" name="filter_by_type" id="filter_by_type">
            <option value="">___Select Type___</option>
            <?php
            if (!empty($rows_type)) {
                $count = 0;
                foreach ($rows_type as $row) {
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
    <div class="form-group mt-2 mb-2">
        <label for="filter_by_material">Filter by Material</label>
        <select class="form-select" name="filter_by_material" id="filter_by_material">
            <option value="">___Select Material___</option>
            <?php
            if (!empty($rows_materials)) {
                foreach ($rows_materials as $row) {
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
    <div class="form-group mt-2 mb-2">
        <label for="filter_by_brand">Filter by Brand</label>
        <select class="form-select" name="filter_by_brand" id="filter_by_brand">
            <option value="">___Select Brand___</option>
            <?php
            if (!empty(Item::getBrandNames())) {
                $count = 0;
                foreach (Item::getBrandNames() as $row) {
                    $name = $row['brand'];
            ?>
                    <option value="<?php echo $name; ?>"><?php echo $name; ?></option>
            <?php
                }
            }
            ?>
        </select>
    </div>

    <div class="form-group mt-2 mb-2">
        <label for="filter_by_location">Filter by Item Location</label>
        <select class="form-select" name="filter_by_location" id="filter_by_location">
            <option value="">___Select Location___</option>
            <?php
            if (!empty(Item::getItemLocation())) {
                $count = 0;
                foreach (Item::getItemLocation() as $row) {
                    $name = $row['item_location'];
            ?>
                    <option value="<?php echo $name; ?>"><?php echo $name; ?></option>
            <?php
                }
            }
            ?>
        </select>
    </div>

</div>