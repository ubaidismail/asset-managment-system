<?php

class Item
{
    public static function getAll($limit = 100, $offset = 0)
    {
        global $conn;
        if($limit == -1){
            $sql = "SELECT * FROM DigiInventoryItems where status = 1 order by ItemID desc";
        } else {
            $limit = (int)$limit;
            $offset = (int)$offset;
            $sql = "SELECT * FROM DigiInventoryItems where status = 1 order by ItemID desc LIMIT $limit OFFSET $offset";
        }
         $result = mysqli_query($conn, $sql);
         if (!$result) {
            die("Query Failed: " . mysqli_error($conn));
        }
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
   
    public static function getBrandNames()
    {
        global $conn;
        $sql = "SELECT DISTINCT brand FROM DigiInventoryItems where status = 1";
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            die("Query Failed: " . mysqli_error($conn));
        }
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    public static function getItemLocation()
    {
        global $conn;
        $sql = "SELECT DISTINCT item_location FROM DigiInventoryItems where status = 1";
        $result = mysqli_query($conn, $sql);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
        if (!$result) {
            die("Query Failed: " . mysqli_error($conn));
        }
    }
    public static function filterByCategory($category_id)
    {
        global $conn;
        $category_id = (int)$category_id;
        $sql = "SELECT * FROM DigiInventoryItems WHERE CategoryID = $category_id AND status = 1";
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            die("Query Failed: " . mysqli_error($conn));
        }
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public static function filterByType($type_id)
    {
        global $conn;
        $type_id = (int)$type_id;
        $sql = "SELECT * FROM DigiInventoryItems WHERE TypeID = $type_id AND status = 1";
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            die("Query Failed: " . mysqli_error($conn));
        }
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public static function filterByBrand($brand_id)
    {
        global $conn;
        $brand_id = (int)$brand_id;
        $sql = "SELECT * FROM DigiInventoryItems WHERE BrandID = $brand_id AND status = 1";
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            die("Query Failed: " . mysqli_error($conn));
        }
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public static function filterByModel($model_name)
    {
        global $conn;
        $model_name = (int)$model_name;
        $sql = "SELECT * FROM DigiInventoryItems WHERE ModelNumber LIKE '%$model_name%' AND status = 1";
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            die("Query Failed: " . mysqli_error($conn));
        }
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public static function find($id)
    {
        global $conn;
        $id = mysqli_real_escape_string($conn, $id);
        $result = mysqli_query($conn, "SELECT * FROM DigiInventoryItems WHERE ItemID = $id");
        if (!$result) {
            die("Query Failed: " . mysqli_error($conn));
        }
        return mysqli_fetch_assoc($result);
    }

    public static function item_delete($id)
    { // soft delete
        global $conn;
        $id = mysqli_real_escape_string($conn, $id);
        $delete_sql = 'Update DigiInventoryItems set status = 0 where ItemID = ' . $id;
        if (!$result) {
            die("Query Failed: " . mysqli_error($conn));
        }
        return mysqli_query($conn, $delete_sql);
    }
    public static function item_restore($id)
    {
        global $conn;
        $id = mysqli_real_escape_string($conn, $id);
        $restore_sql = 'Update DigiInventoryItems set status = 1 where ItemID = ' . $id;
        if (!$result) {
            die("Query Failed: " . mysqli_error($conn));
        }
        return mysqli_query($conn, $restore_sql);
    }
}
