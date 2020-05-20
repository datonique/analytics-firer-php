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
    public function __construct(string $button_name, string $page_name)
    {
        parent::__construct('BUTTON CLICK');
        $this->button_name = $button_name;
        $this->page_name = $page_name;
    }

    public function toOutArray() 
    {
        return array_merge(parent::toOutArray(), array(
            'button_name' => $this->button_name,
            'page_name' => $this->page_name
        ));
    }
}