<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Branch;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['branch', 'items.menuItem'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('branch_id')) {
            $query->where('branch_id', $request->branch_id);
        }

        if ($request->filled('method')) {
            $query->where('method', $request->method);
        }

        $orders = $query->paginate(10)->withQueryString();
        $branches = Branch::where('is_active', true)->get();

        return view('admin.orders.index', compact('orders', 'branches'));
    }

    public function show($id)
    {
        $order = Order::with(['branch', 'items.menuItem'])->findOrFail($id);
        return response()->json($order);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,cooking,ready,completed,cancelled'
        ]);

        $order = Order::findOrFail($id);
        $order->update(['status' => $request->status]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Status pesanan #{$order->id} berhasil diperbarui menjadi {$request->status}!"
            ]);
        }

        return redirect()->back()->with('success', "Status pesanan #{$order->id} berhasil diperbarui menjadi {$request->status}!");
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return redirect()->back()->with('success', "Pesanan #{$id} berhasil dihapus.");
    }
}
