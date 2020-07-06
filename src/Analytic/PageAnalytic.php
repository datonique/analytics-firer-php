<?php

namespace datonique\Analytic;
use datonique\Analytic\Analytic;

class PageAnalytic extends Analytic {
    
    private $html_page_title;
    private $page_php_class_name;
    private $page_url;

    /**
     * Constructor
     *
     * @param string                $event_name
     */
    public function __construct($event_name, $page_info)
    {
        parent::__construct($event_name);
        $this->html_page_title = $page_info['html_page_title'];
        $this->page_php_class_name = $page_info['page_php_class_name'];
        $this->page_url = $page_info['page_url'];
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