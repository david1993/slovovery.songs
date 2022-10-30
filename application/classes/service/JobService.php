<?php

class JobService
{
    private static $jobModel = 'job';

    public static function getJob($name)
    {
        $job = ORM::factory(self::$jobModel)->where('name', '=', $name)->limit(1)->order_by('id')->find();
        /** @var Model_Job $job */
        if (!$job) {
            return null;
        }
        $result = $job->getParams();
        $job->delete();
        return $result;
    }

    public static function putJob($name, $params)
    {
        $job = ORM::factory(self::$jobModel);
        $job->name = $name;
        $job->setParams($params);
        $job->create();
    }
}