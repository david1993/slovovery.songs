<?php
defined('SYSPATH') or die ('No direct script access.');

class Model_Import extends ORM
{
    protected $_has_many = array(
        'files' => array(
            'model' => 'importFile',
            'foreign_key' => 'import_id',
        ),
        'songs' => array(
            'model' => 'importSong',
            'foreign_key' => 'import_id',
        ),
    );
}

?>