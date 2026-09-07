<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use App\Models\Branch;
use App\Models\BranchMenuPrice;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $query = MenuItem::with('branchPrices')->latest();

        if ($request->filled('kategori') && $request->kategori !== 'all') {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('nama', 'like', "%{$request->search}%")
                  ->orWhere('deskripsi', 'like', "%{$request->search}%");
            });
        }

        $menuItems = $query->paginate(12)->withQueryString();
        
        $categories = [
            'daging' => 'Lauk Daging',
            'ayam' => 'Lauk Ayam',
            'ikan' => 'Lauk Ikan',
            'sayur' => 'Sayur & Sambal',
            'minuman' => 'Minuman Tradisional',
        ];

        return view('admin.menu.index', compact('menuItems', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kategori' => 'required|in:daging,ayam,ikan,sayur,minuman,nasi-padang',
            'deskripsi' => 'nullable|string',
            'foto' => 'nullable|url',
            'badge' => 'nullable|in:Signature,Favorit,Baru',
            'rating' => 'nullable|numeric|min:0|max:5',
            'harga' => 'required|numeric|min:0',
        ]);

        $defaultFoto = 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=700&auto=format&fit=crop&q=80';

        $menuItem = MenuItem::create([
            'nama' => $validated['nama'],
            'kategori' => $validated['kategori'],
            'deskripsi' => $validated['deskripsi'] ?? null,
            'foto' => $validated['foto'] ?: $defaultFoto,
            'badge' => $validated['badge'] ?: null,
            'rating' => $validated['rating'] ?? 5.0,
            'is_active' => true,
        ]);

        // Seed prices for all branches
        $branches = Branch::all();
        foreach ($branches as $branch) {
            BranchMenuPrice::create([
                'branch_id' => $branch->id,
                'menu_item_id' => $menuItem->id,
                'harga' => $validated['harga'],
                'is_available' => true,
            ]);
        }

        return redirect()->route('admin.menu.index')->with('success', "Hidangan '{$menuItem->nama}' berhasil ditambahkan ke menu!");
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kategori' => 'required|in:daging,ayam,ikan,sayur,minuman,nasi-padang',
            'deskripsi' => 'nullable|string',
            'foto' => 'nullable|url',
            'badge' => 'nullable|in:Signature,Favorit,Baru',
            'rating' => 'nullable|numeric|min:0|max:5',
            'harga' => 'required|numeric|min:0',
        ]);

        $menuItem = MenuItem::findOrFail($id);
        $menuItem->update([
            'nama' => $validated['nama'],
            'kategori' => $validated['kategori'],
            'deskripsi' => $validated['deskripsi'] ?? null,
            'foto' => $validated['foto'] ?: $menuItem->foto,
            'badge' => $validated['badge'] ?: null,
            'rating' => $validated['rating'] ?? $menuItem->rating,
        ]);

        // Update branch menu prices base
        BranchMenuPrice::where('menu_item_id', $menuItem->id)->update([
            'harga' => $validated['harga']
        ]);

        return redirect()->route('admin.menu.index')->with('success', "Menu '{$menuItem->nama}' berhasil diperbarui!");
    }

    public function toggleActive($id)
    {
        $menuItem = MenuItem::findOrFail($id);
        $menuItem->update(['is_active' => !$menuItem->is_active]);

        $statusText = $menuItem->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->back()->with('success', "Status menu '{$menuItem->nama}' berhasil {$statusText}.");
    }

    public function destroy($id)
    {
        $menuItem = MenuItem::findOrFail($id);
        $name = $menuItem->nama;
        $menuItem->delete();

        return redirect()->route('admin.menu.index')->with('success', "Menu '{$name}' berhasil dihapus.");
    }
}
