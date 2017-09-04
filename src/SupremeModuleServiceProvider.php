<?php namespace SuperV\Modules\Supreme;

use SuperV\Modules\Supreme\Console\MakeService;
use SuperV\Modules\Supreme\Domains\Server\Model\Accounts;
use SuperV\Modules\Supreme\Domains\Server\Model\Servers;
use SuperV\Modules\Supreme\Domains\Server\Process;
use SuperV\Modules\Supreme\Domains\Server\SymfonyProcess;
use SuperV\Modules\Supreme\Domains\Service\Model\Services;
use SuperV\Modules\Supreme\Feature\InstallService;
use SuperV\Platform\Domains\Droplet\DropletServiceProvider;

class SupremeModuleServiceProvider extends DropletServiceProvider
{
    protected $commands = [
        MakeService::class,
    ];

    protected $features = [
        InstallService::class,
        'SuperV\Modules\Supreme\Feature\CreateServer',
        'SuperV\Modules\Supreme\Feature\CreateService',
        'SuperV\Modules\Supreme\Feature\CreateAccount',
    ];

    protected $singletons = [
        'services' =>Services::class,
        'servers'      => Servers::class,
        Accounts::class,
    ];

    protected $bindings = [
        Process::class => SymfonyProcess::class,
    ];

}