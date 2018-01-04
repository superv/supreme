<?php

namespace SuperV\Modules\Supreme\Http\Controllers;

use SuperV\Modules\Nucleo\Domains\Struct\StructTableBuilder;
use SuperV\Modules\Supreme\Domains\Server\Server;
use SuperV\Modules\Ui\Domains\Form\FormFactory;
use SuperV\Modules\Ui\Domains\Form\Jobs\MakeFormInstance;
use SuperV\Modules\Ui\Domains\Form\Jobs\MapForm;
use SuperV\Modules\Ui\Domains\Page\Page;
use SuperV\Platform\Http\Controllers\BasePlatformController;

class ServersController extends BasePlatformController
{
    /**
     * @var Page
     */
    protected $page;

    public function __construct(Page $page)
    {
        parent::__construct();

        $this->page = $page;
    }

    public function create(FormFactory $factory)
    {
        $form = $factory->fromJson('server.json');

        $this->dispatch(new MakeFormInstance($form));

        $this->page->setTitle('Create Server')
                   ->setButtons([
                       'index' => [
                           'text'  => 'Servers',
                           'route' => 'supreme::servers.index',
                       ],
                   ])
                   ->addBlock($form->toBlock())
                   ->make();

        return $this->page->render();
    }

    public function edit(Server $server, FormFactory $factory)
    {
        $form = $factory->fromJson('server.json');

        $this->dispatch(new MapForm($form, $server));
        $this->dispatch(new MakeFormInstance($form));

        $this->page->setTitle('Edit Server')
                   ->setButtons([
                       'index'  => [
                           'text'  => 'Servers',
                           'route' => 'supreme::servers.index',
                       ],
                       'create' => [
                           'text'  => 'New Server',
                           'route' => 'supreme::servers.create',
                       ],
                   ])
                   ->addBlock($form->toBlock())
                   ->make();

        return $this->page->render();
    }

    public function index(StructTableBuilder $builder)
    {
        $builder->setModel(Server::class)
              ->setButtons([
                  "edit" => [
                      "href" => "supreme/servers/{entry.id}/edit",
                  ],
              ])
              ->build();

        $this->page->setTitle('Servers Index')
             ->setButtons([
                 'create' => [
                     'text'  => 'New Server',
                     'route' => 'supreme::servers.create',
                 ],
             ])
             ->addBlock($builder->getTable()->toBlock())
             ->make();

        return $this->page->render();
    }
}