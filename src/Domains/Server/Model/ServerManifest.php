<?php namespace SuperV\Modules\Supreme\Domains\Server\Model;

use SuperV\Platform\Domains\Manifest\ModelManifest;
use SuperV\Platform\Domains\UI\Form\FormBuilder;
use SuperV\Platform\Domains\UI\Table\TableBuilder;

class ServerManifest extends ModelManifest
{
//    protected $model = ServerModel::class;

    public function getPages()
    {
        return [
            'index'  => [
                'navigation' => true,
                'title'      => 'Servers',
                'route'      => 'acp@supreme::servers.index',
                'url'        => 'supreme/servers',
                'handler'    => function (TableBuilder $builder) {

                    return $builder->setModel(ServerModel::class)
                                   ->setButtons(['edit', 'delete'])
                                   ->render();
                },
                'buttons'    => [
                    'create',
                ],
            ],
            'create' => [
                'navigation' => true,
                'icon'       => 'plus',
                'title'      => 'New Server',
                'route'      => 'acp@supreme::servers.create',
                'url'        => 'supreme/servers/create',
                'handler'    => function (FormBuilder $builder, ServerModel $server) {
                    return $builder->render($server);
                },
                'buttons'    => [
                    'index',
                ],
            ],
            'edit'   => [
                'title'   => 'Update Server Details',
                'route'   => 'acp@supreme::servers.edit',
                'url'     => 'supreme/servers/{server}/edit',
                'handler' => function (FormBuilder $builder, ServerModel $server) {
                    return $builder->render($server);
                },
                'buttons' => [
                    'add_service'
                ]
            ],
        ];
    }
}