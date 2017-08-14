<?php namespace SuperV\Modules\Supreme\Domains\Server\Manifests;

use SuperV\Modules\Supreme\Domains\Server\Model\Servers;
use SuperV\Modules\Supreme\Domains\Server\Table\ServerTableBuilder;
use SuperV\Modules\Supreme\Domains\Service\Model\ServiceModel;
use SuperV\Modules\Supreme\Domains\Service\Model\Services;
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
            'index' => [
                'navigation' => true,
                'page_title' => 'Services Index',
                'route'      => 'acp@supreme::services.index',
                'url'        => 'supreme/services',
                'handler'    => function (TableBuilder $builder) {
                    $builder->setModel(ServiceModel::class)
                        ->setButtons(['edit']);

                    return $builder->render();
                },
            ],
            'edit'  => [
                'page_title' => 'Edit Service',
                'route'      => 'acp@supreme::service.edit',
                'url'        => 'supreme/services/{id}/edit',
                'handler'    => function (FormBuilder $builder, Services $services, $id) {
                    return $builder->render($services->find($id));
                },
            ],
        ];
    }
}