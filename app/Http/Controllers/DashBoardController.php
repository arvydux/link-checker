<?php

namespace App\Http\Controllers;

use App\Services\LinkCheckService;

class DashBoardController extends Controller
{
    //
    public function index(LinkCheckService $headersCheckService): void
    {
        $headersCheckService->getAllHeaders();
        echo 789;
    }
}
