<?php

namespace App;

use Illuminate\Support\Facades\Config;

class LocationAdditions
{
    private static $types = null;
    private static $fields = null;

    private static function load($force = false)
    {
        if (self::$types !== null && self::$fields !== null && !$force) {
            return;
        }
        self::$types = Config::get('location.types');
        self::$fields = Config::get('location.fields');
    }

    public static function getTypes()
    {
        self::load();
        return self::$types;
    }

    public static function getTypeName($type)
    {
        self::load();
        if (!array_key_exists($type, self::$types)) {
            return [];
        }
        return self::$types[$type];
    }

    public static function getFields($type)
    {
        self::load();
        if (!array_key_exists($type, self::$fields)) {
            return [];
        }
        return self::$fields[$type];
    }

    public static function getGeneralFields()
    {
        self::load();
        if (!array_key_exists('general', self::$fields)) {
            return [];
        }
        return self::$fields['general'];
    }

    public static function allFieldKeys()
    {
        self::load();

        $fields = [];
        foreach (self::getGeneralFields() as $id => $name) {
            $fields[] = $id;
        }
        foreach (self::$types as $typeId => $typeName) {
            foreach (self::getFields($typeId) as $id => $name) {
                $fields[] = $id;
            }
        }
        return $fields;
    }
}
