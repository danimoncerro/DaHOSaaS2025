<?php

namespace app\models;

use core\Model;

class Module extends Model
{
    protected static $table = 'modules';

    public static function all()
    {
        $db = static::getConnection();
        $stmt = $db->query("SELECT * FROM " . static::$table);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}

