<?php

namespace OpenWallet\Shared\Interface\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use OpenWallet\Shared\Infrastructure\Laravel\Traits\DispatchesCommand;
use OpenWallet\Shared\Infrastructure\Laravel\Traits\GeneratesUuid;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesCommand, DispatchesJobs, GeneratesUuid, ValidatesRequests;
}
