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
            if(sizeof($cate['subCate']) > 0){
                // childCate cap 1 --------------------------
                foreach($cate['subCate'] as $childCate){
                    $dataChildCate = $this->fetchPostSingleCate($childCate['href']);

                }
            }
        }
    }

    /**
     * @param $url - single cate url
     * return list posts belong this cate
     * @return array
     */
    protected function fetchPostSingleCate($url){
        $result = array();
        $dom = new DOMDocument('1.0');
        @$dom->loadHTMLFile($url);
        $finder = new DOMXPath($dom);

        $hostPost = $finder->query("//div[@id='box_news_top']//div[@class='block_news_big']//a[@class='txt_link']");
        $subHostPost = $finder->query("//div[@id='box_sub_hot_news']//div[@class='content_scoller width_common']//ul//li");
        if($hostPost != null){
            array_push($result['lstPostContent'], array(
                $this->fetchPost($hostPost[0]->nodeValue)
            ));
        }
        if($subHostPost != null && sizeof($subHostPost) > 0){
            foreach($subHostPost as $hostPost){
                array_push($result['lstPostContent'], array(
                    $this->fetchPost($hostPost->nodeValue)
                ));
            }
        }
        $secondPostLis = $finder->query("//div[@id='col_1']//ul[@id='news_home']//li//div[@class='title_news']//a[txt_link]");
        if($secondPostLis != null && sizeof($secondPostLis) > 0){
            foreach($secondPostLis as $post){
                array_push($result['lstPostContent'], array(
                    $this->fetchPost($post->getAttribute('href'))
                ));
            }
        }
    }

    /**
     * @param $url
     * get data content from 1 post
     */
    private function fetchPost($url){
        $result = array();
        $dom = new DOMDocument('1.0');
        @$dom->loadHTMLFile($url);
        $finder = new DOMXPath($dom);
        $contentNode = $finder->query("//div[@id='box_details_news']//div[@id='left_calculator']");

        // handle raw content for better
        $rawContent = $contentNode->item(0)->nodeValue;

        // find title
        $titleNode = $finder->query("//div[@id='box_details_news']//div[@id='left_calculator']//div[@class='title_news']")->item(0);
        $title = $titleNode->nodeValue;

        // remove relate posts zone
        // TODO : more code here


        // check time ís in a week ( is acceptable ?)
        // TODO :


        // remove post time
        // TODO: more code here


        // remove social plugin zone
        // TODO: more code here


        return array(
            'title' => $title,
            'href' => $url,
            'img' => 'img',
            'content' => 'content'
        );
    }

    private function isPostTimeAcceptable(){
        return true;
    }
}