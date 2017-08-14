<?php namespace SuperV\Modules\Supreme;

use SuperV\Modules\Supreme\Domains\Server\Manifests\ServerManifest;
use SuperV\Modules\Supreme\Domains\Server\Manifests\ServiceManifest;
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