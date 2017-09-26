<?php

namespace SuperV\Modules\Supreme\Domains\Server\Table;

use Illuminate\Database\Eloquent\Builder;
use SuperV\Modules\Supreme\Domains\Service\Model\ServiceModel;
use SuperV\Platform\Domains\UI\Table\TableBuilder;

class ServicesTableBuilder extends TableBuilder
{
    protected $model = ServiceModel::class;

    protected $columns = [
        'id',
        'entry.agent.name',
        'entry.server.name',
        'name',
        'slug',
        'type',
    ];

    protected $buttons = [
        'delete',
        'edit',
    ];

    protected $server;

    public function onQuerying(Builder $query)
    {
        $query->where('server_id', $this->server->getId());
    }

    /**
     * @param mixed $server
     *
     * @return ServicesTableBuilder
     */
    public function setEntry($server)
    {
        $this->server = $server;

        return $this;
    }

}