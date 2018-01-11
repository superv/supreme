<?php

namespace SuperV\Modules\Supreme\Http\Controllers;

use SuperV\Modules\Nucleo\Domains\Struct\StructTableBuilder;
use SuperV\Modules\Supreme\Domains\Account\Account;
use SuperV\Modules\Ui\Domains\Form\FormFactory;
use SuperV\Modules\Ui\Domains\Form\Jobs\MakeFormInstance;
use SuperV\Modules\Ui\Domains\Form\Jobs\MapForm;
use SuperV\Modules\Ui\Domains\Page\Page;
use SuperV\Platform\Http\Controllers\BasePlatformController;

class AccountsController extends BasePlatformController
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
        $form = $factory->fromJson('account.json');
        $this->dispatch(new MakeFormInstance($form));

        $this->page->setTitle('Create Account')
                   ->setButtons([
                       'index' => [
                           'text'  => 'Accounts',
                           'route' => 'supreme::accounts.index',
                       ],
                   ])
                   ->addBlock($form->toBlock())
                   ->make();

        return $this->page->render();
    }

    public function edit(Account $account, FormFactory $factory)
    {
        $form = $factory->fromJson('account.json');

        $this->dispatch(new MapForm($form, $account));
        $this->dispatch(new MakeFormInstance($form));

        $this->page->setTitle('Edit Account')
                   ->setButtons([
                       'index'  => [
                           'text'  => 'Accounts',
                           'route' => 'supreme::accounts.index',
                       ],
                       'create' => [
                           'text'  => 'New Account',
                           'route' => 'supreme::accounts.create',
                       ],
                   ])
                   ->addBlock($form->toBlock())
                   ->make();

        return $this->page->render();
    }

    public function index(StructTableBuilder $builder)
    {
        $builder->setModel(Account::class)
                ->setButtons([
                    "edit" => [
                        "href" => "supreme/accounts/{entry.id}/edit",
                    ],
                ])
                ->build();

        $this->page->setTitle('Accounts Index')
                   ->setButtons([
                       'create' => [
                           'title' => 'New Account',
                           'route' => 'supreme::accounts.create',
                       ],
                   ])
                   ->addBlock($builder->getTable()->toBlock())
                   ->make();

        return $this->page->render();
    }
}