<?php

class Types {
    public static function getAll() {
        global $conn;
        $sql = "SELECT * FROM DigiInventoryTypes order by TypeID desc";
        $result = mysqli_query($conn, $sql);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public static function find($id) {
        global $conn;
        $id = mysqli_real_escape_string($conn, $id);
        $result = mysqli_query($conn, "SELECT * FROM DigiInventoryTypes WHERE TypeID = $id");
        return mysqli_fetch_assoc($result);
    }
}