<?php

namespace SuperV\Modules\Supreme\Domains\Drop;

use SuperV\Modules\Supreme\Domains\Drop\Model\DropModel;
use SuperV\Platform\Domains\Droplet\Agent\Agent;
use SuperV\Platform\Domains\Droplet\Droplet;

class Drop
{
    /** @var DropModel  */
    protected $model;

    public function __construct(DropModel $model)
    {
        $this->model = $model;
    }

    /** @return Agent */
    public function agent()
    {
        return Droplet::from($this->model->getAgent());
    }

    public function getId()
    {
        return $this->model->getId();
    }


}