<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class AlgoritmoKmeansController extends Controller
{
    public function AlgoritmoKmeans()
    {
        return view('analisis-datos/kmeans');
    }
}
