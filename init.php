<?php

/**
 * Программа парсит данные с сайта file-extensions.org
 * Вытаскивается информация о типах файлов.
 * По условиям сайта, данные не должны парсится и где-то публиковаться поэтому, нам нужно обмануть логи сервера, чтобы
 * не было очевидное присутствие парсинга. Для этого, сайт будет парсится в течении определенного количества времени
 * (скажем, в течении недели).
 *
 * Время запуска парсинга определяется случайно, хедеры тоже передаются из массива выбранные случайным образом.
 * 1. Определяется дата старта и дата окончания (период, за который должен распарсится сайт). Период не должен быть меньше
 *     указанного срока
 * 2. После первого запуска, считываются ссылки вертикального меню, определяется период, за который программа должна
 *    обойти страницы из этого меню.
 * 3. После захода по ссылке, данные логируются (сохраняется код статуса), определяется наличие кнопок постраничной навигации
 *    устанавливается задержка (занчение задержки устанавливается случайным образом) для перехода по ссылкам в постраничном
 *    навигаторе
 */

define('PATH', dirname(__FILE__));
define('MAIN_PAGE', 'MAIN_PAGE');

use src\spider\Spider;

include 'autoloader.php';

$parserMenu = new \src\parser\ParseMenu("http://parser-file-types/filetype/extension/name/document-files/");

$dataArray = $parserMenu->get();
//var_dump($dataArray); die;
$saver = \src\saver\SaverFabric::get("file");
$saver->setName("list-data-new12");

try {

    $taskManager = new \src\tasks\TaskManager("+7 day", $dataArray,  $saver);
} catch (Exception $e) {
    echo $e->getMessage();
}



$data = $taskManager->get();

if (!empty($data)) {

    foreach ($data as $time_=>$data_) {

        if ($data_['status'] == 'new') {
            if ($time_ <= time()) {
                echo "run: ".$time_;
                $data[$time_]['status'] = 'run';
            }
        }





        $dateTime = new DateTime();
        $dateTime->setTimestamp($time_);
        echo $dateTime->format("Y-m-d H:i:s")."\n";
    }

    try {
        $taskManager->update($data);
    } catch (Exception $e) {
        echo "Error: ".$e->getMessage();
    }

}




/*
echo $datetime->getTimestamp().": ". $datetime->format("Y-m-d H:i:s")."\n";
echo $datetimeEnd->getTimestamp().": ". $datetimeEnd->format("Y-m-d H:i:s")."\n";
echo ($datetimeEnd->getTimestamp() - $datetime->getTimestamp())."\n";

$data_ = [];

foreach ($dataArray as $item) {
    $time = rand($datetime->getTimestamp(), $datetimeEnd->getTimestamp());

    while(!isset($data_[$time])) {
        $data_[$time] = $item;
    }
}

foreach ($data_ as $d=>$val) {
    $data = new DateTime();
    $data->setTimestamp($d);
    echo $data->format("Y-m-d H:i:s")."\n";
}

$saver = \src\saver\SaverFabric::get("file");
$saver->setName("t1.txt");
$saver->save(["name"=>"Name", "sname"=>"SName"]);*/

/*define('PATH', dirname(__FILE__));

require "src/ParsePage.php";
require "src/SaverFabric.php";

$page = new ParsePage("http://file-extensions/filetype/extension/name/document-files/");

$menu = $page->getMenu();
var_dump($menu); die;
$paggnUrl = $page->getPagginationUrls();
$data = $page->get();

$sleepArray = [
    1, 2, 3, 4, 5, 6, 7, 8, 9, 10
];

if (!empty($paggnUrl)) {
    foreach ($paggnUrl as $url) {
        $sleep = array_rand($sleepArray);
        echo "sleep: $sleep";
        //sleep($sleep);
        $p = new ParsePage($url);
        array_merge($data, $p->get());
    }
}


if (!empty($data)) {
    $saver = SaverFabric::get('xml');
    $saver->save($data);
}


*/
