<?php


namespace BeetleCore;


class FileArray
{
    static function save($fileName, $array)
    {
        $file = fopen($fileName, "w");
        $text = "<?php return " . var_export($array, true) . ";";
        fwrite($file, $text);
    }

    static function load($fileName)
    {
        if (file_exists($fileName)) {
            return include $fileName;
        } else {
            return [];
        }
    }
}
