<?php namespace SuperV\Modules\Supreme;

use SuperV\Modules\Supreme\Domains\Server\Model\ServerManifest;
use SuperV\Modules\Supreme\Domains\Service\Model\ServiceManifest;
use SuperV\Platform\Domains\Droplet\Module\Module;

class SupremeModule extends Module
{
    protected $title = 'Supreme Module';

    protected $link  = '/supreme';

    protected $navigation = true;

    protected $icon = 'superpowers';

    protected $manifests = [
        ServerManifest::class,
        ServiceManifest::class,
    ];
}