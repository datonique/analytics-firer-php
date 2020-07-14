<?php

namespace datonique\Firer;
use datonique\Analytic\Analytic;
class EmptyFirer {
    public function enqueue(Analytic $analytic)
    {
        return true;
    }
    public function flush()
    {
        return true;
    }
    public function getQueue()
    {
        return array();
    }
    public function getSuccessQueue()
    {
        return array();
    }
    public function getFailQueue()
    {
        return array();
    }
}