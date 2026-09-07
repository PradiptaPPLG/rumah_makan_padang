<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\MenuItem;
use App\Models\Review;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the home page with branches, menu items, and reviews.
     */
    public function index(Request $request)
    {
        $branches = Branch::where('is_active', true)->get();
        
        $menuItems = MenuItem::where('is_active', true)
            ->with(['branchPrices'])
            ->get()
            ->map(function ($item) {
                // Determine a display price (from first branch price or default)
                $firstPrice = $item->branchPrices->first();
                $item->display_price = $firstPrice ? (float) $firstPrice->harga : 25000;
                return $item;
            });

        $reviews = Review::where('is_approved', true)
            ->with('branch')
            ->latest()
            ->take(6)
            ->get();

        $categories = [
            ['id' => 'all', 'name' => 'Semua Hidangan'],
            ['id' => 'daging', 'name' => 'Lauk Daging'],
            ['id' => 'ayam', 'name' => 'Lauk Ayam'],
            ['id' => 'ikan', 'name' => 'Lauk Ikan'],
            ['id' => 'sayur', 'name' => 'Sayur & Sambal'],
            ['id' => 'minuman', 'name' => 'Minuman Tradisional'],
        ];

        return view('pages.home', compact('branches', 'menuItems', 'reviews', 'categories'));
    }
}
