<?php
/**
 * Created by PhpStorm.
 * User: kot
 * Date: 14.03.17
 * Time: 20:41
 */

namespace src\parser;
use phpQuery;


class ParseMenu extends AbstractParserPage
{
    public  function getSelector()
    {
        return '#submenu li a';
    }

    public function get()
    {
        if (!empty($this->content)) {
            $document = phpQuery::newDocument($this->content);
            $items = $document->find($this->getSelector());
            $ret = [];
            foreach ($items as $i=>$item) {
                $pq = pq($item);
                $td = $pq->attr("href");

                $ret[] = $td;
            }
            return $ret;
        }
    }
}