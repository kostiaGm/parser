<?php
define('PATH', dirname(__FILE__));
define('MAIN_PAGE', 'MAIN_PAGE');

include 'autoloader.php';
$saver = \src\saver\SaverFabric::get("file");
$saver->setName("list-data-new12");


try {

    $taskManager = new \src\tasks\TaskManager("+7 day", [],  $saver);
} catch (Exception $e) {
    echo $e->getMessage();
}

$data = $taskManager->get();
//var_dump($data);
if (!empty($data)) {

    foreach ($data as $time_=>$data_) {

        if ($data_['status'] == 'run') {
            if ($time_ <= time()) {
                echo "run: ".$time_ ."\n url: $data_[url]";

                $dateTime = new DateTime();
                $dateTime->setTimestamp($time_);
                echo $dateTime->format("Y-m-d H:i:s")."\n";
            }
        }




    }

    try {
        $taskManager->update($data);
    } catch (Exception $e) {
        echo "Error: ".$e->getMessage();
    }

}