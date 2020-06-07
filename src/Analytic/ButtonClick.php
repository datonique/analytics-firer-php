<?php

namespace datonique\Analytic;
use datonique\Analytic\Analytic;

class ButtonClick extends Analytic {
    
    private $button_name;
    private $page_name;

    /**
     * Constructor
     *
     * @param string                $button_name
     */
    public function __construct(
        string $button_name, 
        string $html_page_title, 
        string $page_php_class_name, 
        string $page_url)
    {
        parent::__construct('button_click');
        $this->button_name = $button_name;
        $this->html_page_title = $html_page_title;
        $this->page_php_class_name = $page_php_class_name;
        $this->page_url = $page_url;
    }

    public function toOutArray() 
    {
        return array_merge(parent::toOutArray(), array(
            'button_name' => $this->button_name,
            'html_page_title' => $this->html_page_title,
            'page_php_class_name' => $this->page_php_class_name,
            'page_url' => $this->page_url,
        ));
    }
}