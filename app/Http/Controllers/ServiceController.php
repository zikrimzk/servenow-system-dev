<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function createServiceType(Request $req)
    {
        try
        {
            $data = $req->validate([

            ]);
            
        }
        catch(Exception $e)
        {

        }
    }
}
