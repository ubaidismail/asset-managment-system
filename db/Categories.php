<?php

class Categories {
    public static function getAll() {
        global $conn;
        $sql = "SELECT * FROM categories where status = 1 order by id desc";
        $result = mysqli_query($conn, $sql);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public static function find($id) {
        global $conn;
        $id = mysqli_real_escape_string($conn, $id);
        $result = mysqli_query($conn, "SELECT * FROM categories WHERE id = $id");
        return mysqli_fetch_assoc($result);
    }
    public static function category_delete($id){
        global $conn;
        $id = mysqli_real_escape_string($conn, $id);
        $delete_sql = 'Update categories set status = 0 where id = ' . $id;
        return mysqli_query($conn, $delete_sql);
    }
}