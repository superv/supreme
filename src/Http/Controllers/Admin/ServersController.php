<?php namespace SuperV\Modules\Supreme\Http\Controllers\Admin;

use SuperV\Modules\Supreme\Domains\Server\Model\Servers;
use SuperV\Platform\Domains\Asset\Asset;
use SuperV\Platform\Domains\UI\Form\FormBuilder;
use SuperV\Platform\Domains\UI\Page\PageCollection;
use SuperV\Platform\Domains\View\ViewTemplate;
use SuperV\Platform\Http\Controllers\BasePlatformController;

class ServersController extends BasePlatformController
{
    public function edit(FormBuilder $builder, Servers $servers)
    {
        return $builder->render($servers->find($this->route->parameter('id')));
    }

    public function index(Asset $asset)
    {
        $asset->add('theme.css', 'droplets/superv/themes/spa/resources/scss/toastr.scss');
//        $asset->add('theme.css', 'droplets/superv/themes/spa/resources/scss/theme/theme.scss');

        $data['asset'] = $asset;
        $data['name'] ='alis';
        return view()->make('superv.modules.supreme::home', $data);
    }
}