<?php

namespace datonique\Analytic;
use datonique\Analytic\Analytic;

class PageView extends Analytic {
    
    private $html_page_title;
    private $page_php_class_name;
    private $page_url;
    /**
     * Constructor
     *
     * @param string                $button_name
     */
    public function __construct(
        string $html_page_title, 
        string $page_php_class_name, 
        string $page_url)
    {
        parent::__construct('pageview');
        $this->html_page_title = $html_page_title;
        $this->page_php_class_name = $page_php_class_name;
        $this->page_url = $page_url;
    }

    public function toOutArray() 
    {
        return array_merge(parent::toOutArray(), array(
            'html_page_title' => $this->html_page_title,
            'page_php_class_name' => $this->page_php_class_name,
            'page_url' => $this->page_url,
        ));
    }
}