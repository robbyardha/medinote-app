<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {

        $data = [
            'title' => 'Dashboard',
            'draftCount' => 40,
            'publishedCount' => 40,
        ];

        return view('dashboard.index', $data);
    }
}
