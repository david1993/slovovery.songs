<?php

namespace Helper;

use Model_Song;
use ORM;

class SongsNameMatchingProvider
{
    public function getNotMatchedSongs()
    {
        return ORM::factory('song')
            ->where('active', '=', 0)
            ->where('status_id', '=', Model_Song::STATUS_MAYBEDUBLICATE)
            ->order_by('name')
            ->find_all();
    }

    public function getMatchedData()
    {
        return $this->getPairs($this->getNotMatchedSongs());
    }


    private function getPairs($imported)
    {
        $result = new \ArrayObject();
        foreach ($imported as $song) {
            $notUpdated = ORM::factory('song')
                ->where('updated', '=', 0)
                ->where('name', '=', $song->name)
                ->find_all();
            if (count($notUpdated) === 1) {
                $result->append(['old' => $notUpdated[0], 'new' => $song]);
            }
        }
        return $result;
    }
}