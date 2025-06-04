<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $response = Http::get('https://api.ipify.org/?format=json');

        if ($response->successful())
        {
            $data = $response->json();

            // dd($data);

            // dd($data['ip']);

            return view("home",$data);
        }
        else {
            # code...
        }
    }
}
