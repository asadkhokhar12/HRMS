<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class TestController extends Controller
{
    public function test()
    {
        $currentDbName = DB::connection()->getDatabaseName();

        echo "Current database name: " . $currentDbName;
    }
}
