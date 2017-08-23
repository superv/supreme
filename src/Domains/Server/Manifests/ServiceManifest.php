<?php namespace SuperV\Modules\Supreme\Domains\Server\Manifests;

use SuperV\Modules\Supreme\Domains\Service\Model\ServiceModel;
use SuperV\Modules\Supreme\Domains\Service\Model\Services;
use SuperV\Modules\Supreme\Feature\InstallService;
use SuperV\Platform\Domains\Manifest\ModelManifest;
use SuperV\Platform\Domains\UI\Form\FormBuilder;
use SuperV\Platform\Domains\UI\Table\TableBuilder;

class ServiceManifest extends ModelManifest
{
    protected $model = ServiceModel::class;

    protected $table = 'supreme_services';

    protected $relations = [];

    protected $fields = [];

    public function getPages()
    {
        return [
            'index'  => [
                'navigation' => true,
                'title'      => 'Services',
                'route'      => 'acp@supreme::services.index',
                'url'        => 'supreme/services',
                'handler'    => function (TableBuilder $builder) {
                    $builder->setModel(ServiceModel::class)
                            ->setButtons(['edit']);

                    return $builder->render();
                },
                'buttons'    => [
                    'create',
                ],
            ],
            'create' => [
                'navigation' => true,
                'title'      => 'Add New Service',
                'route'      => 'acp@supreme::services.create',
                'url'        => 'supreme/services/create',
                'handler'    => function (FormBuilder $builder, ServiceModel $service) {
                    return $builder->render($service);
                },
                'buttons'    => [
                    'index',
                ],
            ],
            'install' => [
                'url' => 'supreme/services/{id}/install',
                'handler' => InstallService::class ."@handle"
            ],
            'edit'   => [
                'title'   => 'Edit Service',
                'route'   => 'acp@supreme::service.edit',
                'url'     => 'supreme/services/{id}/edit',
                'handler' => function (FormBuilder $builder, Services $services, $id) {
                    return $builder->render($services->find($id));
                },
                'buttons' => [
                    'create',
                    'delete' => ['class' => 'remote', 'href' => '/Delete'],
                    'install_dns' => [
                        'text' => 'Install Server',
                        'href' => 'supreme/services/{entry.id}/install',
                        'class' => 'remote'
                    ],
                ],
                'tabs'    => [
                    'ajax'    => true,
                    'details' => [
                        'label'   => 'Service Details',
                        'handler' => function (FormBuilder $builder, Services $services, $id) {
                            return $builder->render($services->find($id));
                        },
                    ],
                ],
            ],
        ];
    }
}