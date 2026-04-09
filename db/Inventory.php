<?php

class Inventory
{
    public static function getAll($limit = 10, $offset = 0)
    {
        global $conn;
        $limit = (int)$limit;
        $offset = (int)$offset;

        $sql = "SELECT * FROM inventory where status = 1 LIMIT $limit OFFSET $offset";
        $result = mysqli_query($conn, $sql);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public static function find($id)
    {
        global $conn;
        $id = mysqli_real_escape_string($conn, $id);
        $result = mysqli_query($conn, "SELECT * FROM inventory WHERE id = $id");
        return mysqli_fetch_assoc($result);
    }


}
