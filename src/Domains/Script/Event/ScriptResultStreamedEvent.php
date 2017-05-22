<?php namespace SuperV\Modules\Supreme\Domains\Script\Event;

use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Vizra\SupervModule\DropperCommand\DropperCommandModel;

class ScriptResultStreamedEvent implements  ShouldBroadcast
{
    /**
     * @var DropperCommandModel
     */
    private $model;
    private $buffer;

    public function __construct(DropperCommandModel $model, $buffer)
    {
        $this->model = $model;
        $this->buffer = $buffer;
    }

    /**
     * @return DropperCommandModel
     */
    public function getModel(): DropperCommandModel
    {
        return $this->model;
    }

    /**
     * @return mixed
     */
    public function getBuffer()
    {
        return $this->buffer;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        // TODO: Implement broadcastOn() method.
    }
}