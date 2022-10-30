<?php

namespace Helper;

class SongsMatchingHelper
{
    public function matchAllSongs()
    {
        $provider = new SongsNameMatchingProvider();
        foreach ($provider->getMatchedData() as $row) {
            $this->matchSong($row['old'], $row['new']);
        }
    }

    public function matchSong($oldSong, $newSong)
    {
        $slidesOld = $oldSong->slides->find_all()->as_array();
        foreach ($slidesOld as $slideOld) {
            \ORM::factory('slide', $slideOld->id)->delete();
        }
        $newSong->created_time = $oldSong->created_time;
        $oldId = $oldSong->id;
        $oldSong->delete();

        $slidesNew = $newSong->slides->find_all()->as_array();
        foreach ($slidesNew as $slideNew) {
            $slideNew->id_song = $oldId;
            $slideNew->save();
        }
        $newSong->id = $oldId;
        $newSong->active = 1;
        //$newSong->updated=1;
        $newSong->status_id = \Model_Song::STATUS_NEW;
        $newSong->save();
    }
}