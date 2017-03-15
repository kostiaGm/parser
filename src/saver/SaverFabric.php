<?php

namespace src\saver;


class SaverFabric
{
    public static function get($name)
    {
        switch($name) {
            case "file": {
                return new SaverFile();
            }
        }
    }

}
