<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tariff;
use Illuminate\Http\Request;

class TariffController extends Controller
{
    public function index()
    {
        return Tariff::all();
    }

    public function show(Tariff $tariff)
    {
        return $tariff;
    }
}