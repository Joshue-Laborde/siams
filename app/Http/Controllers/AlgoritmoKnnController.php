<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AlgoritmoKnnController extends Controller
{
    public function AlgoritmoKnn()
    {
        return view('analisis-datos/knn');
    }
}
