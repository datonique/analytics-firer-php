<?php

namespace datonique\Analytic;
use datonique\Analytic\Analytic;

abstract class Inquisition extends PageAnalytic {
    

    // ...DATONIQUE.page_info,
    // ...DATONIQUE.episode_info,
    // ...DATONIQUE.chapter_info,
    private $inquisition_id;
    private $inquisition_question_id;
    private $inquisition_question_bodytext;
    private $inquisition_response_id;
    private $inquisition_response_value;
    private $inquisition_correct_option;
    private $inquisition_grade;

    /**
     * Constructor
     *
     * @param string                $event_name
     */
    public function __construct(string $event_name, array $inquisition_info, array $episode_info, array $page_info)
    {
        parent::__construct($event_name, $page_info);
         $this->inquisition_id = isset($inquisition_info['inquisition_id']) ? $inquisition_info['inquisition_id'] : null;
         $this->inquisition_question_id = isset($inquisition_info['inquisition_question_id']) ? $inquisition_info['inquisition_question_id'] : null;
         $this->inquisition_question_bodytext = isset($inquisition_info['inquisition_question_bodytext']) ? $inquisition_info['inquisition_question_bodytext'] : null;
         $this->inquisition_response_id = isset($inquisition_info['inquisition_response_id']) ? $inquisition_info['inquisition_response_id'] : null;
         $this->inquisition_response_value = isset($inquisition_info['inquisition_response_value']) ? $inquisition_info['inquisition_response_value'] : null;
         $this->inquisition_grade = isset($inquisition_info['inquisition_grade']) ? $inquisition_info['inquisition_grade'] : null;
         $this->inquisition_correct_option = isset($inquisition_info['inquisition_correct_option']) ? $inquisition_info['inquisition_correct_option'] : null;
    }

    public function toOutArray()
    {
        return array_merge(parent::toOutArray(), array(
            'inquisition_id' => $this->inquisition_id,
            'inquisition_question_id' => $this->inquisition_question_id,
            'inquisition_question_bodytext' => $this->inquisition_question_bodytext,
            'inquisition_response_id' => $this->inquisition_response_id,
            'inquisition_response_value' => $this->inquisition_response_value,
            'inquisition_grade' => $this->inquisition_grade,
            'inquisition_correct_option' => $this->inquisition_correct_option,
        ));
    }
}