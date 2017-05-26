<?php namespace SuperV\Modules\Supreme\Http\Controllers\Admin;

class ServersController
{
    public function index()
    {
        return view()->make('superv.modules.supreme::home');
    }
}