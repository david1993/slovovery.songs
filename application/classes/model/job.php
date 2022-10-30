<?php
defined('SYSPATH') or die ('No direct script access.');

class Model_Job extends ORM
{

    public function getParams()
    {
        return (array)json_decode($this->params);
    }

    public function setParams($params)
    {
        $this->params = json_encode($params);
    }

}

?>