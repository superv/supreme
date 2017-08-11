<?php namespace SuperV\Modules\Supreme\Domains\Server\Manifests;

use SuperV\Modules\Supreme\Domains\Server\Model\ServerModel;
use SuperV\Modules\Supreme\Domains\Server\Model\Servers;
use SuperV\Modules\Supreme\Domains\Server\Table\ServerTableBuilder;
use SuperV\Modules\Supreme\Http\Controllers\Admin\ServersController;
use SuperV\Platform\Domains\Entry\EntryManifest;
use SuperV\Platform\Domains\UI\Form\FormBuilder;

class ServerManifest extends EntryManifest
{
    protected $model = ServerModel::class;

    public function getPages()
      {
          return [
              'index'  => [
                  'page_title' => 'Servers Index',
                  'route'      => 'acp@servers::servers.index',
                  'url'        => 'servers',
                  'handler'    => function (ServerTableBuilder $builder) {
                      return $builder->render();
                  },
              ],
              'edit'   => [
                  'page_title'  => 'Edit Server',
                  'route'       => 'acp@servers::servers.edit',
                  'url'         => 'servers/{id}/edit',
                  'handler'     => function(FormBuilder $builder, Servers $servers, $id)
                      {
                          return $builder->render($servers->find($id));
                      }
              ],
          ];
      }
}