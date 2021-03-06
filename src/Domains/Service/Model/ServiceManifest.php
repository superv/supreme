<?php namespace SuperV\Modules\Supreme\Domains\Service\Model;

use SuperV\Modules\Supreme\Feature\InstallService;
use SuperV\Platform\Domains\UI\Form\FormBuilder;
use SuperV\Platform\Domains\UI\Table\TableBuilder;

class ServiceManifest
{
    public function handle()
    {
        return [
            'port'  => 'acp',
            'pages' => [
                'index'   => [
                    'navigation' => true,
                    'icon'       => 'cogs',
                    'title'      => 'Services',
                    'route'      => 'supreme::services.index',
                    'url'        => 'supreme/services',
                    'handler'    => function (TableBuilder $builder) {
                        $builder->setModel(ServiceModel::class)
                                ->setColumns([
                                    'id',
                                    'entry.agent.name',
                                    'entry.server.name',
                                    'name',
                                    'slug',
                                    'type',
                                ])
                                ->setButtons([
                                    'delete',
                                    'edit',
                                ]);

                        return $builder->render();
                    },
                    'buttons'    => [
                        'create',
                    ]
                ],
                'create'  => [
                    'ajax' => true,
                    'title'   => 'New Service',
                    'route'   => 'supreme::services.create',
                    'url'     => 'supreme/services/create',
                    'handler' => function (FormBuilder $builder, ServiceModel $entry) {
                        return $builder->render($entry);
                    },
                    'buttons' => [
                        'index',
                    ],
                ],
                'install' => [
                    'url'     => 'supreme/services/{id}/install',
                    'handler' => InstallService::class."@handle",
                ],
                'edit'    => [
                    'title'   => 'Edit Service',
                    'route'   => 'supreme::service.edit',
                    'url'     => 'supreme/services/{service}/edit',
                    'handler' => function (FormBuilder $builder, ServiceModel $entry) {
                        return $builder->render($entry);
                    },
                    'buttons' => [
                        'index',
                        'create',
                        'delete'      => ['confirm' => true],
                        'install_dns' => [
                            'text'  => 'Install Server',
                            'href'  => 'supreme/services/{entry.id}/install',
                            'class' => 'remote',
                        ],
                    ],
                ],
            ],
        ];
    }
}