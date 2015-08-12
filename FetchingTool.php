<?php

class FetchingTool {
    private $host = 'http://vnexpress.net/';
    private $keyDom = '';
    private $dayRange = 7;

    public function fetchCate($url){
        $rootUrl = $url;
        if(strpos($url, '/') >  0){
            $rootUrl = substr($url, 0, strpos($url, '/'));
        }
        $result = array();
        static $seen = array();
        if (isset($seen[$url])) {
            return;
        }
        $seen[$url] = true;
        $dom = new DOMDocument('1.0');
        @$dom->loadHTMLFile($url);
        $finder = new DomXPath($dom);

        $liNodes = $finder->query("//div[@id='header_web']//ul[@id='breakumb_web']//li");
        if($liNodes != null && sizeof($liNodes) > 0 ){
            foreach($liNodes as $liNode){
                $tempDom =  new DOMDocument('1.0');
                $href = $liNode->getAttribute('href');
                @$tempDom->loadHTMLFile($rootUrl . $href);
                $tempFinder = new DOMXPath($tempDom);
                $subCateLis = $tempFinder->query("//div[@clas='block_breakumb_left']//ul[@class='sub_breakumn']//li");
                $lstSubCate = array();
                if($subCateLis != null && sizeof($subCateLis) > 0){
                    foreach($subCateLis as $subCate){
                        $lstSubCate[] = array(
                            'href' => $subCate->getAttribute('href'),
                            'title' => $subCate->nodeValue,
                            'subCate' => array()
                        );
                    }
                }
                $result['listSubCate'][] = array(
                    'href' => $href,
                    'title' => $liNode->nodeValue,
                    'subCate' => $lstSubCate
                );
            }
        }

        foreach($result['listSubCate'] as $cate){

        }
    }

    protected function fecthPostSingleCate($url){
        $result = array();
        $dom = new DOMDocument('1.0');
        @$dom->loadHTMLFile($url);
        $finder = new DOMXPath($dom);

        $hostPost = $finder->query("//div[@id='box_news_top']//div[@class='block_news_big']//a[@class='txt_link']");
        $subHostPost = $finder->query("//div[@id='box_sub_hot_news']//div[@class='content_scoller width_common']//ul//li");
        $secondPostLis = $finder->query("//div[@id='col_1']//ul[@id='news_home']//li");

    }

    private function fetchSingleCate($url){

    }

    private function isPostTimeAcceptable(){
        return true;
    }
}