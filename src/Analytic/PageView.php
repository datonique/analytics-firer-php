<?php

namespace datonique\Analytic;
use datonique\Analytic\PageAnalytic;

class PageView extends PageAnalytic {
    
    /**
     * Constructor
     *
     * @param string                $button_name
     */
    public function __construct($page_info)
    {
        parent::__construct('pageview', $page_info);
    }

    public function toOutArray() 
    {
        return array_merge(parent::toOutArray(), array());
    }
}