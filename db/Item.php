<?php

class Item
{
    public static function getAll($limit = 10, $offset = 0)
    {
        global $conn;
        $limit = (int)$limit;
        $offset = (int)$offset;

        $sql = "SELECT * FROM inventory_items where status = 1 LIMIT $limit OFFSET $offset";
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            die("Query Failed: " . mysqli_error($conn));
        }
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    public static function getBrandNames()
    {
        global $conn;
        $sql = "SELECT DISTINCT brand FROM inventory_items where status = 1";
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            die("Query Failed: " . mysqli_error($conn));
        }
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    public static function getItemLocation()
    {
        global $conn;
        $sql = "SELECT DISTINCT item_location FROM inventory_items where status = 1";
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
        $sql = "SELECT * FROM inventory_items WHERE category_id = $category_id AND status = 1";
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
        $sql = "SELECT * FROM inventory_items WHERE type_id = $type_id AND status = 1";
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            die("Query Failed: " . mysqli_error($conn));
        }
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public static function filterByBrand($brand_name)
    {
        global $conn;
        $brand_name = (int)$brand_name;
        $sql = "SELECT * FROM inventory_items WHERE brand LIKE '%$brand_name%' AND status = 1";
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
        $sql = "SELECT * FROM inventory_items WHERE brand LIKE '%$model_name%' AND status = 1";
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
        $result = mysqli_query($conn, "SELECT * FROM inventory_items WHERE id = $id");
        if (!$result) {
            die("Query Failed: " . mysqli_error($conn));
        }
        return mysqli_fetch_assoc($result);
    }

    public static function item_delete($id)
    { // soft delete
        global $conn;
        $id = mysqli_real_escape_string($conn, $id);
        $delete_sql = 'Update inventory_items set status = 0 where id = ' . $id;
        if (!$result) {
            die("Query Failed: " . mysqli_error($conn));
        }
        return mysqli_query($conn, $delete_sql);
    }
    public static function item_restore($id)
    {
        global $conn;
        $id = mysqli_real_escape_string($conn, $id);
        $restore_sql = 'Update inventory_items set status = 1 where id = ' . $id;
        if (!$result) {
            die("Query Failed: " . mysqli_error($conn));
        }
        return mysqli_query($conn, $restore_sql);
    }
}
