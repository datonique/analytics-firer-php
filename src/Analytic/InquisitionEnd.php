<?php

namespace datonique\Analytic;
use datonique\Analytic\Analytic;

class InquisitionEnd extends Inquisition {
    /**
     * Constructor
     *
     * @param array                $inquisition_info
     */
    public function __construct(array $inquisition_info)
    {
        parent::__construct('inquisition_end', $inquisition_info);
    }
}