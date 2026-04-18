<?php

class Assets {
    public static function getAll( $limit = 100, $offset = 0) {
        global $conn;
        $limit = (int)$limit;
        $offset = (int)$offset;
        $sql = "SELECT * FROM Assets where status = 1 order by AssetsID desc LIMIT $limit OFFSET $offset";
        $result = mysqli_query($conn, $sql);
         if (!$result) {
            die("Query Failed: " . mysqli_error($conn));
        }
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public static function find($id) {
        global $conn;
        $id = mysqli_real_escape_string($conn, $id);
        $result = mysqli_query($conn, "SELECT * FROM Assets WHERE AssetsID = $id");
         if (!$result) {
            die("Query Failed: " . mysqli_error($conn));
        }
        return mysqli_fetch_assoc($result);
    }
    public static function asset_delete($id){
        global $conn;
        $id = mysqli_real_escape_string($conn, $id);
        $delete_sql = 'Update Assets set status = 0 where AssetsID = ' . $id;
         if (!$result) {
            die("Query Failed: " . mysqli_error($conn));
        }
        return mysqli_query($conn, $delete_sql);
    }
}