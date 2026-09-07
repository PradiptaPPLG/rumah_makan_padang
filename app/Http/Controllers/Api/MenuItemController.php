<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use App\Models\BranchMenuPrice;
use Illuminate\Http\Request;

class MenuItemController extends Controller
{
    public function index(Request $request)
    {
        $query = MenuItem::query()->where('is_active', true);

        if ($request->has('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->has('branch_id')) {
            // Get menu with prices for specific branch
            $menuItems = $query->with(['branchPrices' => function ($q) use ($request) {
                $q->where('branch_id', $request->branch_id)->where('is_available', true);
            }])->get();

            return response()->json([
                'success' => true,
                'data' => $menuItems->map(function ($item) use ($request) {
                    $price = $item->branch_prices->first();
                    return [
                        'id' => $item->id,
                        'nama' => $item->nama,
                        'kategori' => $item->kategori,
                        'deskripsi' => $item->deskripsi,
                        'foto' => $item->foto,
                        'badge' => $item->badge,
                        'rating' => (float) $item->rating,
                        'harga' => $price ? (int) $price->harga : null,
                        'harga_display' => $price ? "Rp " . number_format((int) $price->harga, 0, ',', '.') : null,
                    ];
                }),
            ]);
        }

        // Without price info
        $menuItems = $query->get();

        return response()->json([
            'success' => true,
            'data' => $menuItems->map(fn($item) => [
                'id' => $item->id,
                'nama' => $item->nama,
                'kategori' => $item->kategori,
                'deskripsi' => $item->deskripsi,
                'foto' => $item->foto,
                'badge' => $item->badge,
                'rating' => (float) $item->rating,
            ]),
        ]);
    }

    public function show(string $id)
    {
        $menuItem = MenuItem::with('branchPrices.branch')->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $menuItem,
        ]);
    }
}
