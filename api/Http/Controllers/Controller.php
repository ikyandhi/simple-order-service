<?php

namespace Api\Http\Controllers;

use App\Http\Controllers\Controller as BaseController;
use Dingo\Api\Routing\Helpers;

class Controller extends BaseController
{
    use Helpers;

    protected $repository;

}
