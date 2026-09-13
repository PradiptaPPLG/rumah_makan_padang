<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MenuItem;
use App\Models\Branch;

class KasirController extends Controller
{
    /**
     * Menampilkan antarmuka POS (Kasir)
     */
    public function index()
    {
        $branches = Branch::where('is_active', true)->get();
        // Mengambil semua menu yang aktif untuk ditampilkan di grid kasir
        $menuItems = MenuItem::where('is_active', true)->orderBy('category')->orderBy('name')->get();

        return view('kasir.index', compact('branches', 'menuItems'));
    }
}
