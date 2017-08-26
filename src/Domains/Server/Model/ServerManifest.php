<?php namespace SuperV\Modules\Supreme\Domains\Server\Model;

use SuperV\Modules\Supreme\Domains\Server\Table\ServerTableBuilder;
use SuperV\Platform\Domains\Manifest\ModelManifest;
use SuperV\Platform\Domains\UI\Form\FormBuilder;

class ServerManifest extends ModelManifest
{
//    protected $model = ServerModel::class;

    public function getPages()
    {
        return [
            'index' => [
                'navigation' => true,
                'title' => 'Servers Index',
                'route'      => 'acp@supreme::servers.index',
                'url'        => 'supreme/servers',
                'handler'    => function (ServerTableBuilder $builder) {
                    return $builder->render();
                },
            ],
            'edit'  => [
                'title' => 'Edit Server',
                'route'      => 'acp@supreme::servers.edit',
                'url'        => 'supreme/servers/{id}/edit',
                'handler'    => function (FormBuilder $builder, Servers $servers, $id) {
                    return $builder->render($servers->find($id));
                },
            ],
        ];
    }
}