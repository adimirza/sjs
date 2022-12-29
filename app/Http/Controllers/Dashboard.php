<?php

namespace App\Http\Controllers;

use App\Models\JabatanModel;
use Illuminate\Http\Request;

class Dashboard extends Controller
{
    public function index()
    {
        $data['title'] = 'Dashboard';
        return view('dashboard.index', $data);
    }
}
