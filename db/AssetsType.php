<?php

class AssetsType {
    public static function getAll() {
        global $conn;
     
        $sql = "SELECT * FROM AssetsType where status = 1 order by AssetsTypeID desc";
        $result = mysqli_query($conn, $sql);
         if (!$result) {
            die("Query Failed: " . mysqli_error($conn));
        }
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public static function find($id) {
        global $conn;
        $id = mysqli_real_escape_string($conn, $id);
        $result = mysqli_query($conn, "SELECT * FROM AssetsType WHERE AssetsTypeID = $id");
         if (!$result) {
            die("Query Failed: " . mysqli_error($conn));
        }
        return mysqli_fetch_assoc($result);
    }
    public static function asset_delete($id){
        global $conn;
        $id = mysqli_real_escape_string($conn, $id);
        $delete_sql = 'Update AssetsType set status = 0 where AssetsTypeID = ' . $id;
         if (!$delete_sql) {
            die("Query Failed: " . mysqli_error($conn));
        }
        return mysqli_query($conn, $delete_sql);
    }
}