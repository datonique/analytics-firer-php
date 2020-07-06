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

    private $episode_id;
    private $episode_title;
    private $episode_publish_date;
    private $episode_createdate;
    private $episode_description;

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

        $this->episode_id = isset($episode_info['episode_id']) ? $episode_info['episode_id'] : null;
        $this->episode_title = isset($episode_info['episode_title']) ? $episode_info['episode_title'] : null;
        $this->episode_publish_date = isset($episode_info['episode_publish_date']) ? $episode_info['episode_publish_date'] : null;
        $this->episode_createdate = isset($episode_info['episode_createdate']) ? $episode_info['episode_createdate'] : null;
        $this->episode_description = isset($episode_info['episode_description']) ? $episode_info['episode_description'] : null;
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

            'episode_id' => $this->episode_id,
            'episode_title' => $this->episode_title,
            'episode_publish_date' => $this->episode_publish_date,
            'episode_createdate' => $this->episode_createdate,
            'episode_description' => $this->episode_description,
        ));
    }
}