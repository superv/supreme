<?php namespace SuperV\Modules\Supreme\Http\Controllers\Admin;

use SuperV\Platform\Domains\Asset\Asset;

class ServersController
{
    public function index(Asset $asset)
    {
        $asset->add('theme.css', 'droplets/superv/themes/spa/resources/scss/toastr.scss');
//        $asset->add('theme.css', 'droplets/superv/themes/spa/resources/scss/theme/theme.scss');

        $data['asset'] = $asset;
        $data['name'] ='alis';
        return view()->make('superv.modules.supreme::home', $data);
    }
}