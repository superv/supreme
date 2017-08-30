<?php namespace SuperV\Modules\Supreme\Model\Entry;

use SuperV\Platform\Domains\Entry\EntryModel;

class DropEntryModel extends EntryModel
{
    protected $titleColumn = 'name';

    protected $table = 'supreme_drops';
}