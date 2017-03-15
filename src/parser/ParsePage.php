<?php
namespace src\parser;

require(PATH.'/vendor/electrolinux/phpquery/phpQuery/phpQuery.php');

class ParsePage
{
    private $url;
    private $content;
    private $headers = [
        'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36',
        'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36',
        'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/32.0.1700.2 Safari/537.36',
        'Dalvik/2.1.0 (Linux; U; Android 5.1.1; KIW-L21 Build/HONORKIW-L21)'


    ];

    public function __construct($url)
    {
        $this->url = $url;
        $this->content = $this->getContent();
    }

    protected function getContent()
    {

        $ch = curl_init();
        $header = $this->headers[array_rand($this->headers)];
        curl_setopt($ch, CURLOPT_URL, $this->url); # URL to post to
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 ); # return into a variable
        curl_setopt($ch, CURLOPT_USERAGENT, $header ); # custom headers, see above
        $result = curl_exec( $ch ); # run!
        curl_close($ch);

        return $result;
        //return file_get_contents($this->url);
    }

    public function get()
    {
        if (!empty($this->content)) {
            $document = phpQuery::newDocument($this->content);
            $items = $document->find('table.extensiontable tr');
            $ret = [];
            foreach ($items as $i=>$item) {
                $pq = pq($item);
                $td = $pq->find('td');
                $key = '';
                $val = '';
                foreach ($td as $index=>$tdItem) {
                    $pq1 = pq($tdItem);
                    if ($index == 0) {
                        $key = $pq1->find("strong")->text();
                    } else {
                        $val = $pq1->text();
                    }
                }
                $ret[$key] = $val;
            }
            return $ret;
        }
    }

    public function getPagginationUrls()
    {
        //pagenumber
        if (!empty($this->content)) {
            $document = phpQuery::newDocument($this->content);
            $links = $document->find('.pagenumber:first a');
            $ret = [];

            foreach ($links as $link) {
                $l = pq($link);
                $ret[] = $l->attr('href');
            }

            return $ret;
        }
    }

    public function getMenu()
    {
        if (!empty($this->content)) {
            $document = phpQuery::newDocument($this->content);
            $links = $document->find('#submenu li a');
            $ret = [];

            foreach ($links as $link) {
                $l = pq($link);
                $ret[] = $l->attr('href');
            }

            return $ret;
        }
    }
}


