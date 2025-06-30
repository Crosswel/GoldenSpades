<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class AdminOrderController extends Controller
{
    /**
     * Listar todos os pedidos (só admin)
     */
    public function index()
    {
        $orders = Order::with(['user', 'items.produto'])->orderBy('created_at', 'desc')->get();

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Marcar o pedido como enviado
     */
    public function update($id)
    {
        $order = Order::findOrFail($id);
        $order->estado = 'Enviado';
        $order->save();

        return redirect()->back()->with('success', 'Pedido marcado como enviado!');
    }
}
