<?php namespace SuperV\Modules\Supreme;

use SuperV\Modules\Supreme\Console\MakeService;
use SuperV\Modules\Supreme\Domains\Server\Model\Contracts\AccountModel;
use SuperV\Modules\Supreme\Domains\Server\Model\Contracts\Accounts;
use SuperV\Modules\Supreme\Domains\Server\Model\Contracts\ServerModelInterface;
use SuperV\Modules\Supreme\Domains\Server\Model\Contracts\Servers;
use SuperV\Modules\Supreme\Domains\Server\Model\Nucleus\AccountModel as AccountModelNucleus;
use SuperV\Modules\Supreme\Domains\Server\Model\Nucleus\Accounts as AccountsNucleus;
use SuperV\Modules\Supreme\Domains\Server\Model\Nucleus\ServerModel;
use SuperV\Modules\Supreme\Domains\Server\Model\Nucleus\Servers as ServersNucleus;
use SuperV\Modules\Supreme\Domains\Server\Process;
use SuperV\Modules\Supreme\Domains\Server\SymfonyProcess;
use SuperV\Modules\Supreme\Domains\Service\Model\ServiceModel;
use SuperV\Modules\Supreme\Domains\Service\Model\ServiceModelInterface;
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
        AccountModel::class          => AccountModelNucleus::class,
        ServiceModelInterface::class => ServiceModel::class,
        ServerModelInterface::class  => ServerModel::class,
    ];
}