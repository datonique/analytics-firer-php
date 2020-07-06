<?php

namespace datonique\Analytic;
use datonique\Analytic\Analytic;

class InquisitionEnd extends Inquisition {
    /**
     * Constructor
     *
     * @param array                $inquisition_info
     * @param array                $episode_info
     */
    public function __construct(array $inquisition_info, array $episode_info, array $page_info)
    {
        parent::__construct('inquisition_end', $inquisition_info, $episode_info, $page_info);
    }
}