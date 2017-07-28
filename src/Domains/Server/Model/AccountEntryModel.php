<?php namespace SuperV\Modules\Supreme\Domains\Server\Model;

use SuperV\Platform\Domains\Entry\EntryModel;

class AccountEntryModel extends EntryModel
{
    protected $fields = [
        'name:text|required',
        'slug:text|required|unique',
        'user:text|required|alphanum',
        'private_key:textarea|required',
        'public_key:textarea|required',
    ];
}