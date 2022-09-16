<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AlgoritmoRegLinealController extends Controller
{
    public function AlgoritmoRegLineal()
    {
        return view('analisis-datos/reglineal');
    }
}
