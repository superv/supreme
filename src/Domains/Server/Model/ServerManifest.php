<?php namespace SuperV\Modules\Supreme\Domains\Server\Model;

use SuperV\Platform\Domains\UI\Table\TableBuilder;

class ServerManifest
{
    public function handle()
    {
        return [
            'port'  => 'acp',
            'pages' => [
                'index' => [
                    'navigation' => true,
                    'icon'       => 'server',
                    'title'      => 'Servers',
                    'route'      => 'supreme::servers.index2',
                    'url'        => 'supreme/servers2',
                    'handler'    => function (TableBuilder $builder) {
                        return $builder->setModel(ServerModel::class)
                                       ->setButtons([
                                           'delete',
                                           'manage' => ['route' => 'supreme::server.manage'],
                                       ])
                                       ->noWrapper()
                                       ->render();
                    },
                    'buttons'    => [
                        'create',
                    ],
                ],
//                'create'        => [
//                    'title'   => 'New Server',
//                    'route'   => 'supreme::servers.create',
//                    'url'     => 'supreme/servers/create',
//                    'handler' => function (FormBuilder $builder, ServerModel $entry) {
//                        return $builder->render($entry);
//                    },
//                    'buttons' => [
//                        'index',
//                    ],
//                ],
//                'edit'          => [
//                    'title'   => 'Update Server Details',
//                    'route'   => 'supreme::servers.edit',
//                    'url'     => 'supreme/servers/{server}',
//                    'tabs'    => [
//                        'edit-details'  => [
//                            'title' => 'Server Details',
//                            'url'   => 'supreme/servers/{entry.id}/edit',
//                        ],
//                        'edit-services' => [
//                            'title' => 'Services',
//                            'url'   => 'supreme/servers/{entry.id}/services',
//                        ],
//                    ],
//                    'buttons' => [
//                        'index',
//                        'add_service',
//                    ],
//                ],
//                'edit-details'  => [
//                    'ajax'    => true,
//                    'title'   => 'Server Details',
//                    'route'   => 'supreme::servers.edit.details',
//                    'url'     => 'supreme/servers/{server}/edit',
//                    'handler' => function (FormBuilder $builder, ServerModel $entry) {
//                        return $builder->setAjax(true)->render($entry);
//                    },
//                    'buttons' => [
//                        'delete',
//                    ],
//                ],
//                'edit-services' => [
//                    'ajax'    => true,
//                    'title'   => 'Services',
//                    'route'   => 'supreme::servers.edit.services',
//                    'url'     => 'supreme/servers/{server}/services',
//                    'handler' => function (TableBuilder $builder, ServerModel $entry) {
//                        $builder->setModel(ServiceModel::class)
//                                ->setColumns([
//                                        'delete',
//                                        'edit',
//                                    ])
//                                ->setButtons([
//                                    'delete',
//                                    'edit',
//                                ])
//                                ->before(function (Builder $query) use ($entry) {
//                                    $query->where('server_id', $entry->getId());
//                                });
//
//                        return $builder->render();
//                    },
//                    'buttons' => [
//                        'index',
//                        'create' => [
//                            'route'       => 'supreme::services.create',
//                            'data-toggle' => 'modal',
//                            'data-target' => '#modal',
//                        ],
//                    ],
//                ],
            ],
        ];
    }
}