<?php

namespace src\tasks;
use DateTime;

class TaskManager
{
    private $interval;
    private $data;
    private $saver;

    public function __construct($interval, array $data = [], $saver = null)
    {
        $this->interval = $interval;

        $this->setSaver($saver);

        if ($data) {
            try {
                $this->run($data);
            } catch (\Exception $e) {
                throw $e;
            }
        }
    }

    protected function setSaver($saver)
    {
        $this->saver = $saver;
    }

    public function run(array $data)
    {
        $datetime = new DateTime();
        $datetimeEnd = new DateTime();
        $datetimeEnd->modify($this->interval);

        $this->data[$datetime->getTimestamp()] = [
            'url' => $data[0],
            'status' => 'new',
            'code' => '-',
             'time' => $datetime->getTimestamp()
        ];

        array_shift($data);

        foreach ($data as $item) {
            $time = rand($datetime->getTimestamp(), $datetimeEnd->getTimestamp());

            while(!isset($this->data[$time])) {
                $this->data[$time] = [
                    'url' => $item,
                    'status' => 'new',
                    'code' => '-',
                    'time'=>$time
                ] ;
            }
        }

        if ($this->saver) {
            try {
                $this->save();
            } catch (\Exception $e) {
                throw $e;
            }
        }
    }

    public function save()
    {
        if (!empty($this->data)) {
            try {
                $this->saver->save($this->data);
            } catch (\Exception $e) {
                throw $e;
            }
        }
    }

    public function update(array $data)
    {
        try {
            $this->saver->update($data);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function get()
    {
        return $this->saver->get();
    }


}
