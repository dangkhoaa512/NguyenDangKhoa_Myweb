<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('items');

        // Tìm kiếm
        if ($request->keyword) {
            $query->where(function($q) use ($request) {
                $q->where('order_code', 'like', '%' . $request->keyword . '%')
                  ->orWhere('customer_name', 'like', '%' . $request->keyword . '%')
                  ->orWhere('phone', 'like', '%' . $request->keyword . '%');
            });
        }

        // Lọc theo trạng thái
        if ($request->status != '') {
            $query->where('status', $request->status);
        }

        $list = $query->orderBy('created_at', 'desc')->paginate(10);

        // Thống kê
        $totalOrders = Order::count();
        $totalRevenue = Order::sum('total_amount');

        return view('admin.orders.index', compact('list', 'totalOrders', 'totalRevenue'));
    }

    public function show($id)
    {
        $order = Order::with('items.product')->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->update(['status' => $request->status]);

        return back()->with('success', 'Cập nhật trạng thái thành công!');
    }
}