<?php namespace SuperV\Modules\Supreme;

use SuperV\Modules\Supreme\Domains\Server\Model\ServerManifest;
use SuperV\Modules\Supreme\Domains\Service\Model\ServiceManifest;
use SuperV\Platform\Domains\Manifest\DropletManifest;

class SupremeManifest extends DropletManifest
{
    protected $title = 'Supreme Module';

    protected $link  = '/supreme';

    protected $navigation = true;

    protected $manifests = [
        ServerManifest::class,
        ServiceManifest::class,
    ];
}