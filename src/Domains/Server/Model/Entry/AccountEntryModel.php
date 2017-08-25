<?php namespace SuperV\Modules\Supreme\Domains\Server\Model\Entry;

use SuperV\Platform\Domains\Entry\EntryModel;

class AccountEntryModel extends EntryModel
{
    protected $table = 'supreme_server_accounts';

    protected $fields = [
        'name:text|required',
        'slug:text|required|unique',
        'user:text|required|alphanum',
        'private_key:textarea|required',
        'public_key:textarea|required',
    ];
}