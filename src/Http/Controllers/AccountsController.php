<?php

namespace SuperV\Modules\Supreme\Http\Controllers;

use SuperV\Modules\Supreme\Domains\Account\Account;
use SuperV\Modules\Ui\Domains\Form\FormFactory;
use SuperV\Modules\Ui\Domains\Form\Jobs\MakeFormInstance;
use SuperV\Modules\Ui\Domains\Form\Jobs\MapForm;
use SuperV\Modules\Ui\Domains\Table\TableFactory;
use SuperV\Platform\Http\Controllers\BasePlatformController;

class AccountsController extends BasePlatformController
{
    public function create(FormFactory $factory)
    {
        $form = $factory->fromJson('account.json');

        $this->dispatch(new MakeFormInstance($form));

        $data = [
            'block' => [
                'component' => 'sv-form',
                'props'     => [
                    'fields' => $form->getFields()->values()->toArray(),
                    'config' => $form->getConfig(),
                ],
            ],
            'page'  => [
                'title'   => 'Account Create',
                'buttons' => [
                    [
                        'title'      => 'Accounts',
                        'button'     => 'index',
                        'type'       => 'sueccess',
                        'attributes' => [
                            'href' => '/acp/supreme/accounts/index',
                        ],
                    ],
                ],
            ],
        ];

        if ($this->request->wantsJson()) {
            return response(['data' => $data]);
        }

        return $this->view->make('ui::container', ['page' => $data]);
    }

    public function edit($id, FormFactory $factory)
    {
        $user = Account::find($id);
        $form = $factory->fromJson('account.json');

        $this->dispatch(new MapForm($form, $user));
        $this->dispatch(new MakeFormInstance($form));

        $data = [
            'block' => [
                'component' => 'sv-form',
                'props'     => [
                    'fields' => $form->getFields()->values()->toArray(),
                    'config' => $form->getConfig(),
                ],
            ],
            'page'  => [
                'title'   => 'Account Edit',
                'buttons' => [
                    [
                        'title'      => 'Accounts',
                        'button'     => 'index',
                        'type'       => 'success',
                        'attributes' => [
                            'href' => '/acp/supreme/accounts/index',
                        ],
                    ],
                    [
                        'title'      => 'New Account',
                        'button'     => 'create',
                        'type'       => 'success',
                        'attributes' => [
                            'href' => '/acp/supreme/accounts/create',
                        ],
                    ],
                ],
            ],
        ];

        if ($this->request->wantsJson()) {
            return response(['data' => $data]);
        }

        return $this->view->make('ui::container', ['page' => $data]);
    }

    public function index(TableFactory $factory)
    {
        $builder = $factory->fromJson('accounts.json');
        $table = $builder->build()->getTable();

        $data = [
            'block' => [
                'component' => 'sv-table',
                'props'     => [
                    'columns' => $table->getColumns(),
                    'rows'    => $table->getRows(),
                ],
            ],
            'page'  => [
                'title'   => 'Accounts Index',
                'buttons' => [
                    [
                        'title'      => 'New Account',
                        'button'     => 'create',
                        'type'       => 'success',
                        'attributes' => [
                            'href' => '/acp/supreme/accounts/create',
                        ],
                    ],
                ],
            ],
        ];

        if ($this->request->wantsJson()) {
            return response(['data' => $data]);
        }

        return $this->view->make('ui::container', ['page' => $data]);
    }
}