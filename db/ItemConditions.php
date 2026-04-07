<?php

class ItemConditions {
    public static function getAll() {
        global $conn;
        $sql = "SELECT * FROM item_conditions";
        $result = mysqli_query($conn, $sql);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public static function find($id) {
        global $conn;
        $id = mysqli_real_escape_string($conn, $id);
        $result = mysqli_query($conn, "SELECT * FROM item_conditions WHERE id = $id");
        return mysqli_fetch_assoc($result);
    }
}