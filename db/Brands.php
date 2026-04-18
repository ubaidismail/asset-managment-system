<?php

class Brands {
    public static function getAll() {
        global $conn;
        $sql = "SELECT * FROM Brands where status = 1 order by BrandID desc";
        $result = mysqli_query($conn, $sql);
         if (!$result) {
            die("Query Failed: " . mysqli_error($conn));
        }
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public static function find($id) {
        global $conn;
        $id = mysqli_real_escape_string($conn, $id);
        $result = mysqli_query($conn, "SELECT * FROM Brands WHERE BrandID = $id");
         if (!$result) {
            die("Query Failed: " . mysqli_error($conn));
        }
        return mysqli_fetch_assoc($result);
    }
    public static function brand_delete($id){
        global $conn;
        $id = mysqli_real_escape_string($conn, $id);
        $delete_sql = 'Update Brands set status = 0 where BrandID = ' . $id;
         if (!$result) {
            die("Query Failed: " . mysqli_error($conn));
        }
        return mysqli_query($conn, $delete_sql);
    }
}