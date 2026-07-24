<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CartController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);
        return view('client.cart.index', compact('cart'));
    }

    /**
     * Thêm sản phẩm vào giỏ hàng — xử lý qua AJAX, trả về JSON
     */
    public function add(Request $request, $id)
    {
        $product = Product::where('id', $id)->where('status', 1)->first();

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Sản phẩm không tồn tại.',
            ], 404);
        }

        $cart = session('cart', []);

        $qty = (int) $request->input('qty', 1);
        if ($qty < 1) {
            $qty = 1;
        }

        $price = ($product->pricediscount > 0 && $product->pricediscount < $product->price)
            ? $product->pricediscount
            : $product->price;

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += $qty;
        } else {
            $cart[$id] = [
                'productid' => $product->id,
                'proname'   => $product->productname,
                'slug'      => $product->slug,
                'image'     => $product->image,
                'price'     => $price,
                'quantity'  => $qty,
            ];
        }

        session(['cart' => $cart]);

        $cartCount = collect($cart)->sum('quantity');
        $cartTotal = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

        return response()->json([
            'success'    => true,
            'message'    => 'Đã thêm "' . $product->productname . '" vào giỏ hàng.',
            'cartCount'  => $cartCount,
            'cartTotal'  => number_format($cartTotal) . 'đ',
        ]);
    }

    public function update(Request $request, $id)
    {
        $cart = session('cart', []);
        $qty = (int) $request->input('qty', 1);

        if (isset($cart[$id])) {
            if ($qty < 1) {
                unset($cart[$id]);
            } else {
                $cart[$id]['quantity'] = $qty;
            }
        }

        session(['cart' => $cart]);

        return redirect()
            ->route('cart.index')
            ->with('success', 'Đã cập nhật giỏ hàng.');
    }

    public function remove($id)
    {
        $cart = session('cart', []);
        unset($cart[$id]);
        session(['cart' => $cart]);

        return redirect()
            ->route('cart.index')
            ->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng.');
    }

    public function checkout()
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()
                ->route('cart.index')
                ->with('error', 'Giỏ hàng đang trống.');
        }

        return view('client.cart.checkout', compact('cart'));
    }

    public function placeOrder(Request $request)
{
    $cart = session('cart', []);

    if (empty($cart)) {
        return redirect()
            ->route('cart.index')
            ->with('error', 'Giỏ hàng đang trống.');
    }

    $request->validate([
        'fullname' => 'required|min:3|max:100',
        'phone'    => 'required|min:9|max:20',
        'email'    => 'nullable|email',
        'address'  => 'required|min:5|max:255',
        'note'     => 'nullable|max:500',
    ], [
        'required' => ':attribute không được để trống.',
        'min'      => ':attribute quá ngắn.',
        'email'    => ':attribute không đúng định dạng.',
    ], [
        'fullname' => 'Họ tên',
        'phone'    => 'Số điện thoại',
        'email'    => 'Email',
        'address'  => 'Địa chỉ',
    ]);

    try {
        $totalAmount = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

        // Lưu đơn hàng trực tiếp không qua bảng customers
        $order = Order::create([
            'order_code'    => 'DH' . strtoupper(Str::random(8)),
            'customer_name' => $request->fullname,
            'phone'         => $request->phone,
            'email'         => $request->email,
            'address'       => $request->address,
            'note'          => $request->note,
            'total_amount'  => $totalAmount,
            'status'        => 1,
        ]);

        // Lưu chi tiết đơn hàng
foreach ($cart as $item) {
    OrderItem::create([
        'order_id'     => $order->id,
        'product_id'   => $item['productid'],
        'product_name' => $item['proname'],
        'price'        => $item['price'],
        'quantity'     => $item['quantity'],
        'subtotal'     => $item['price'] * $item['quantity'],
    ]);
}

        // Xóa giỏ hàng
        session()->forget('cart');

        return redirect()
            ->route('cart.success', $order->order_code)
            ->with('success', 'Đặt hàng thành công!');

    } catch (\Exception $e) {
        return back()
            ->withInput()
            ->with('error', 'Đặt hàng thất bại: ' . $e->getMessage());
    }
}

   public function success($code)
{
    $order = Order::where('order_code', $code)->with(['items'])->firstOrFail();
    return view('client.cart.success', compact('order'));
}
}