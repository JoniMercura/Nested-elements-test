<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assembly;

class AssemblyController extends Controller
{
    public function show(Assembly $assembly)
    {
        return $assembly->descendantsAndSelf()->get();
    }
}
