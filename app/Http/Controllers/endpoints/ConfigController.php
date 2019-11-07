<?php

namespace App\Http\Controllers\endpoints;

use App\Http\Controllers\Controller;
use App\Models\Config;
use App\Http\Resources\config\ConfigResource;

class ConfigController extends Controller
{
    public function index()
    {
        return new ConfigResource(Config::all());
    }
}
