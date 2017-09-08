<?php namespace SuperV\Modules\Supreme\Domains\Server\Model;

use SuperV\Platform\Domains\Manifest\ModelManifest;
use SuperV\Platform\Domains\UI\Form\FormBuilder;
use SuperV\Platform\Domains\UI\Table\TableBuilder;

class ServerManifest
{
    public function handle()
    {
        return [
            'port' => 'acp',
            'pages' => [
                'index'  => [
                    'navigation' => true,
                    'icon'       => 'server',
                    'title'      => 'Servers',
                    'route'      => 'supreme::servers.index',
                    'url'        => 'supreme/servers',
                    'handler'    => function (TableBuilder $builder) {
                        return $builder->setModel(ServerModel::class)
                                       ->setButtons(['delete', 'edit'])
                                       ->noWrapper()
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
                    'handler' => function (FormBuilder $builder, ServerModel $entry) {
                        return $builder->render($entry);
                    },
                    'buttons' => [
                        'index',
                    ],
                ],
                'edit'   => [
                    'title'   => 'Update Server Details',
                    'route'   => 'supreme::servers.edit',
                    'url'     => 'supreme/servers/{server}/edit',
                    'handler' => function (FormBuilder $builder, ServerModel $entry) {
                        return $builder->render($entry);
                    },
                    'buttons' => [
                        'index',
                        'add_service',
                    ],
                ],
            ],
        ];
    }
}