<?php

namespace datonique\Analytic;
use datonique\Analytic\Analytic;

class ButtonClick extends PageAnalytic {
    
    private $button_name;
    private $page_name;

    /**
     * Constructor
     *
     * @param string                $button_name
     */
    public function __construct(
        string $button_name, 
        array $page_info)
    {
        parent::__construct('button_click', $page_info);
        $this->button_name = $button_name;
    }

    public function toOutArray() 
    {
        return array_merge(parent::toOutArray(), array(
            'button_name' => $this->button_name,
        ));
    }
}