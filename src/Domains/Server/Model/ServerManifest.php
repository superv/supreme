<?php namespace SuperV\Modules\Supreme\Domains\Server\Model;

use SuperV\Platform\Domains\Manifest\ModelManifest;
use SuperV\Platform\Domains\UI\Form\FormBuilder;
use SuperV\Platform\Domains\UI\Table\TableBuilder;

class ServerManifest extends ModelManifest
{
//    protected $model = ServerModel::class;

    protected $port = 'acp';

    public function getPages()
    {
        return [
            'index'  => [
                'navigation' => true,
                'icon'       => 'server',
                'title'      => 'Servers',
                'route'      => 'supreme::servers.index',
                'url'        => 'supreme/servers',
                'handler'    => function (TableBuilder $builder) {

                    return $builder->setModel(ServerModel::class)
                                   ->setButtons(['delete', 'edit'])
                                   ->render();
                },
                'buttons'    => [
                    'create',
                ],
            ],
            'create' => [
                'title'   => 'New Server',
                'route'   => 'supreme::servers.create',
                'url'     => 'supreme/servers/create',
                'handler' => function (FormBuilder $builder, ServerModel $server) {
                    return $builder->render($server);
                },
                'buttons' => [
                    'index',
                ],
            ],
            'edit'   => [
                'title'   => 'Update Server Details',
                'route'   => 'supreme::servers.edit',
                'url'     => 'supreme/servers/{server}/edit',
                'handler' => function (FormBuilder $builder, ServerModel $server) {
                    return $builder->render($server);
                },
                'buttons' => [
                    'index',
                    'add_service',
                ],
            ],
        ];
    }
}