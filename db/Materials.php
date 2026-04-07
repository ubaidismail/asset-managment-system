<?php

class Materials {
    public static function getAll() {
        global $conn;
        $sql = "SELECT DISTINCT name FROM materials WHERE status = 1";
        $result = mysqli_query($conn, $sql);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public static function find($id) {
        global $conn;
        $id = mysqli_real_escape_string($conn, $id);
        $result = mysqli_query($conn, "SELECT * FROM materials WHERE id = $id");
        return mysqli_fetch_assoc($result);
    }
    public static function filterByMaterial($material_id)
    {
        global $conn;
        $material_id = (int)$material_id;
        $sql = "SELECT * FROM materials WHERE id = $material_id AND status = 1";
        $result = mysqli_query($conn, $sql);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
}