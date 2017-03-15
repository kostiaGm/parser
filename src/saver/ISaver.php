<?php
namespace src\saver;

define('I_SAVER', 'I_SAVER');


interface ISaver
{
    public function save(array $data, $allowRewrite = false);
    public function setName($name);
    public function get();
    public function getAll();
    public function delete();
    public function update(array $data);
}
