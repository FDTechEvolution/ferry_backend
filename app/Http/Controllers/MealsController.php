<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\Addon;

class MealsController extends Controller
{
    protected $Type = 'MEAL';
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        $meals = Addon::where('type', $this->Type)->where('isactive', true)->get();

        return view('pages.meals.index', ['meals' => $meals]);
    }
}
