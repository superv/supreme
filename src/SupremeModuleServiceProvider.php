<?php namespace SuperV\Modules\Supreme;

use SuperV\Modules\Supreme\Console\MakeService;
use SuperV\Modules\Supreme\Domains\Server\Model\Contracts\AccountModelInterface;
use SuperV\Modules\Supreme\Domains\Server\Model\Contracts\Accounts;
use SuperV\Modules\Supreme\Domains\Server\Model\Contracts\Servers;
use SuperV\Modules\Supreme\Domains\Server\Model\Nucleus\AccountModel;
use SuperV\Modules\Supreme\Domains\Server\Model\Nucleus\Accounts as AccountsNucleus;
use SuperV\Modules\Supreme\Domains\Server\Model\Nucleus\Servers as ServersNucleus;
use SuperV\Modules\Supreme\Domains\Server\Process;
use SuperV\Modules\Supreme\Domains\Server\SymfonyProcess;
use SuperV\Platform\Domains\Droplet\DropletServiceProvider;

class SupremeModuleServiceProvider extends DropletServiceProvider
{
    protected $commands = [
        MakeService::class,
    ];

    protected $features = [
        'SuperV\Modules\Supreme\Feature\InstallService',
        'SuperV\Modules\Supreme\Feature\CreateServer',
        'SuperV\Modules\Supreme\Feature\CreateService',
        'SuperV\Modules\Supreme\Feature\CreateAccount',
    ];

    protected $singletons = [
        'SuperV\Modules\Services\Domains\Service\Model\Services',
    ];

    protected $bindings = [
        Process::class               => SymfonyProcess::class,
        Servers::class               => ServersNucleus::class,
        Accounts::class              => AccountsNucleus::class,
        AccountModelInterface::class => AccountModel::class,
    ];
}