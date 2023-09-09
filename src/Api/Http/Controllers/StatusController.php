<?php

namespace OpenWallet\Api\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class StatusController extends Controller
{
    public function __invoke(): Response
    {
        return response()->noContent();
    }
}
