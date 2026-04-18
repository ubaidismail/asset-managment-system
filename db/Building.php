<?php

class Building {
    public static function getAll() {
        global $conn;
        $sql = "SELECT * FROM Building where status = 1 order by BuildingID desc";
        $result = mysqli_query($conn, $sql);
         if (!$result) {
            die("Query Failed: " . mysqli_error($conn));
        }
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public static function find($id) {
        global $conn;
        $id = mysqli_real_escape_string($conn, $id);
        $result = mysqli_query($conn, "SELECT * FROM Building WHERE BuildingID = $id");
         if (!$result) {
            die("Query Failed: " . mysqli_error($conn));
        }
        return mysqli_fetch_assoc($result);
    }
   
}