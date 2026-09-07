<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\BranchMenuPrice;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['items.menuItem', 'branch']);

        if ($request->has('branch_id')) {
            $query->where('branch_id', $request->branch_id);
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->orderByDesc('created_at')->paginate(15);

        return response()->json([
            'success' => true,
            'data' => $orders,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'method' => 'required|in:dine-in,online,delivery',
            'customer_name' => 'nullable|string|max:255',
            'customer_phone' => 'nullable|string|max:20',
            'notes' => 'nullable|string',
            'items' => 'required|array',
            'items.*.menu_item_id' => 'required|exists:menu_items,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.notes' => 'nullable|string',
        ]);

        // Get menu prices for validation
        foreach ($validated['items'] as $item) {
            $price = BranchMenuPrice::where('branch_id', $validated['branch_id'])
                ->where('menu_item_id', $item['menu_item_id'])
                ->first();

            if (!$price || !$price->is_available) {
                return response()->json([
                    'success' => false,
                    'message' => "Menu item {$item['menu_item_id']} is not available at this branch",
                ], 422);
            }

            $item['price'] = (int) $price->harga;
        }

        // Calculate total
        $total = collect($validated['items'])->sum(fn($item) => $item['quantity'] * $item['price']);

        // Create order
        $order = Order::create([
            'branch_id' => $validated['branch_id'],
            'method' => $validated['method'],
            'customer_name' => $validated['customer_name'] ?? null,
            'customer_phone' => $validated['customer_phone'] ?? null,
            'notes' => $validated['notes'] ?? null,
            'total' => $total,
            'status' => 'pending',
        ]);

        // Create order items
        foreach ($validated['items'] as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'menu_item_id' => $item['menu_item_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'notes' => $item['notes'] ?? null,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Order created successfully',
            'data' => $order->load(['items.menuItem']),
        ], 201);
    }

    public function show(string $id)
    {
        $order = Order::with(['items.menuItem', 'branch'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $order,
        ]);
    }

    public function updateStatus(Request $request, string $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,cooking,ready,completed,cancelled',
        ]);

        $order = Order::findOrFail($id);
        $order->update(['status' => $validated['status']]);

        return response()->json([
            'success' => true,
            'message' => 'Order status updated',
            'data' => $order,
        ]);
    }
}
