<?php

namespace datonique\Analytic;
use datonique\Analytic\Analytic;

class PageView extends Analytic {
    
    private $page_name;

    /**
     * Constructor
     *
     * @param string                $button_name
     */
    public function __construct(string $page_name)
    {
        parent::__construct('PAGE VIEW');
        $this->page_name = $page_name;
    }

    public function toOutArray() 
    {
        return array_merge(parent::toOutArray(), array(
            'page_name' => $this->page_name
        ));
    }
}