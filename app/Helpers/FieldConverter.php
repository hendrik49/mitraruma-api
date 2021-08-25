<?php


namespace App\Helpers;


class FieldConverter
{
    public static function keysToUnderscore($array)
    {
        self::transformKeys(['self', 'toUnderscore'], $array);
        return $array;
    }

     
    public static function keysToCamelCase($array)
    {
        self::transformKeys(['self', 'toCamelCase'], $array);
        return $array;
    } 

    public static function transformKeys($transform, &$array)
    {
        foreach (array_keys($array) as $key) :
            # Working with references here to avoid copying the value,
            # since you said your data is quite large.
            $value = &$array[$key];
            unset($array[$key]);
            # This is what you actually want to do with your keys:
            #  - remove exclamation marks at the front
            #  - camelCase to snake_case
            $transformedKey = call_user_func($transform, $key);
            # Work recursively
            if (is_array($value)) self::transformKeys($transform, $value);
            # Store with new key
            $array[$transformedKey] = $value;
            # Do not forget to unset references!
            unset($value);
        endforeach;
    }

    public static function toCamelCase($string)
    {
        $string_ = str_replace(' ', '', ucwords(str_replace('_', ' ', $string)));
        return lcfirst($string_);
    }

    public static function toUnderscore($string)
    {
        return strtolower(preg_replace('/([^A-Z])([A-Z])/', "$1_$2", $string));
    }
   
}
