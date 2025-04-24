<?php

namespace app\models;

use core\Model;
use PDO;

class Product extends Model
{
    public static function getAllForStore($store_slug)
    {
        $db = self::getConnection();

        $sql = "SELECT * FROM produse WHERE activ = 1 ORDER BY cod_afisare ASC";
        $stmt = $db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
