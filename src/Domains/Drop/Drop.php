<?php

namespace SuperV\Modules\Supreme\Domains\Drop;

use SuperV\Modules\Supreme\Domains\Drop\Model\DropModel;
use SuperV\Platform\Domains\Droplet\Agent\Agent;
use SuperV\Platform\Domains\Droplet\Droplet;
use SuperV\Platform\Domains\Droplet\DropletFactory;

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
        return new Agent($this->model->getAgent()->toArray());
    }

    public function getId()
    {
        return $this->model->getId();
    }


}