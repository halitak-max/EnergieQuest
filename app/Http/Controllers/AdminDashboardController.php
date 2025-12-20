<?php

namespace App\Http\Controllers;

use App\Models\Upload;
use App\Models\User;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $uploads = Upload::with('user')->latest()->paginate(10);
        $pendingUploads = Upload::where('status', 'pending')->count();
        $totalUsers = User::count();

        return view('admin.dashboard', compact('uploads', 'pendingUploads', 'totalUsers'));
    }
}
