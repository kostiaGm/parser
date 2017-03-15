<?php
/**
 * Created by PhpStorm.
 * User: kot
 * Date: 14.03.17
 * Time: 15:16
 */

namespace src\saver;
define('DATA_PATH', dirname(__FILE__).'/data');

class SaverFile implements ISaver
{
    private $name;

    public function setName($name)
    {
        $this->name = $name;
    }

    public function save(array $data, $allowRewrite = false)
    {

        try {
            $this->isWriteAllow(DATA_PATH);
        } catch (\Exception $e) {
            throw $e;
        }

        $content = [];

        if (is_file(DATA_PATH.'/'.$this->name)) {

            if (!$allowRewrite) {
                return;
            }

            try {
                $this->isWriteAllow(DATA_PATH.'/'.$this->name);
            } catch (\Exception $e) {
                throw $e;
            }

        //    $content = $this->get();
        }

        //$content = array_merge_recursive($content, $data);

        file_put_contents(DATA_PATH.'/'.$this->name, serialize($data));
    }

    private function isWriteAllow($path)
    {
        if (!is_writable($path)) {
            throw new \Exception("The path [$path] NOT WRITABLE!!!!");
        }
        return true;
    }

    public function get()
    {
        if (is_file(DATA_PATH.'/'.$this->name)) {
            $content = file_get_contents(DATA_PATH.'/'.$this->name);
            if (!empty($content)) {
                return unserialize($content);
            }
        }
    }

    public function getAll()
    {
        if (is_dir(DATA_PATH)) {
            return scandir(DATA_PATH);
        }
    }

    public function delete()
    {
        if (is_file(DATA_PATH.'/'.$this->name)) {
            if (!unlink(DATA_PATH.'/'.$this->name)) {
                throw new \Exception("Can`t delete file: ".DATA_PATH.'/'.$this->name);
            }
        }
    }

    public function update(array $data)
    {
        try {
            $this->save($data, true);
        } catch (\Exception $e) {
            throw $e;
        }
    }


}
