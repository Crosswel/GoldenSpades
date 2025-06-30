<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;

class CarrinhoController extends Controller
{
    /**
     * Adiciona produto ao carrinho
     */
    public function add(Request $request)
    {
        $id = $request->input('id');
        $quantity = $request->input('quantity', 1);

        $produto = Produto::findOrFail($id);

        $cart = session()->get('carrinho', []);

        if (isset($cart[$id])) {
            $cart[$id] += $quantity;
        } else {
            $cart[$id] = $quantity;
        }

        // valida stock
        if ($cart[$id] > $produto->quantidade) {
            $cart[$id] = $produto->quantidade;
        }

        session(['carrinho' => $cart]);

        $subtotal = 0;
        foreach ($cart as $pid => $qtd) {
            $produto = Produto::find($pid);
            if ($produto) {
                $subtotal += $produto->preco * $qtd;
            }
        }

        // portes
        $shipping = $subtotal < 75 ? 7.50 : 0;

        // total
        $total = $subtotal + $shipping;

        // guardar na session
        session([
            'carrinho_subtotal' => $subtotal,
            'carrinho_shipping' => $shipping,
            'carrinho_total' => $total,
        ]);

        return redirect()->back()->with('success', 'Produto adicionado ao carrinho!');
    }

    /**
     * Atualiza quantidade de produto no carrinho
     */
    public function update(Request $request)
    {
        $id = $request->input('id');
        $action = $request->input('action');
        $carrinho = session('carrinho', []);

        if (isset($carrinho[$id])) {
            if ($action === 'decrement') {
                $carrinho[$id]--;
                if ($carrinho[$id] <= 0) {
                    unset($carrinho[$id]);
                }
            } elseif ($action === 'increment') {
                $produto = Produto::find($id);
                if ($produto && $carrinho[$id] < $produto->quantidade) {
                    $carrinho[$id]++;
                }
            }
        }

        session(['carrinho' => $carrinho]);

        $subtotal = 0;
        foreach ($carrinho as $pid => $qtd) {
            $produto = Produto::find($pid);
            if ($produto) {
                $subtotal += $produto->preco * $qtd;
            }
        }

        $shipping = $subtotal < 75 ? 7.50 : 0;
        $total = $subtotal + $shipping;

        session([
            'carrinho_subtotal' => $subtotal,
            'carrinho_shipping' => $shipping,
            'carrinho_total' => $total,
        ]);

        return response()->json(['success' => true]);
    }


    /**
     * Remove item do carrinho
     */
    public function remove($id)
    {
        $cart = session()->get('carrinho', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session(['carrinho' => $cart]);

            $subtotal = 0;
            foreach ($cart as $pid => $qtd) {
                $produto = Produto::find($pid);
                if ($produto) {
                    $subtotal += $produto->preco * $qtd;
                }
            }

            $shipping = $subtotal < 75 ? 7.50 : 0;
            $total = $subtotal + $shipping;

            session([
                'carrinho_subtotal' => $subtotal,
                'carrinho_shipping' => $shipping,
                'carrinho_total' => $total,
            ]);

        }

        return back()->with('success', 'Produto removido do carrinho!');
    }

    /**
     * Limpa todo o carrinho
     */
        public function clear()
        {
            session()->forget('carrinho');
            return back()->with('success', 'Carrinho limpo!');
        }

    /**
     * Exibe tela de checkout
     */
    public function checkout()
    {
        return view('checkout');
    }

    public function processarEndereco(Request $request)
    {
        $request->validate([
            'address' => 'required|string|max:255',
        ]);

        if ($request->has('guardar_endereco') && auth()->check()) {
            $user = auth()->user();
            $user->address = $request->address;
            $user->save();
        }

        session(['checkout_endereco' => $request->address]);

        return redirect()->route('checkout.pagamento');
    }

    public function pagamento()
    {
        return view('pagamento');
    }


    public function finalizar(Request $request)
    {
        $metodo = $request->metodo;

        $cart = session('carrinho', []);  // <-- buscar carrinho ANTES
        if (empty($cart)) {
            return redirect()->route('home')->with('error', 'O carrinho está vazio!');
        }

        $order = \App\Models\Order::create([
            'user_id' => auth()->id(),
            'metodo' => $metodo,
            'estado' => 'Pendente',
            'endereco' => session('checkout_endereco')
        ]);

        foreach ($cart as $produtoId => $qtd) {
            $produto = \App\Models\Produto::find($produtoId);
            if ($produto) {
                \App\Models\OrderItem::create([
                    'order_id' => $order->id,
                    'produto_id' => $produtoId,
                    'quantidade' => $qtd,
                    'preco' => $produto->preco
                ]);
            }
        }


        session()->forget('carrinho');

        if ($metodo === 'paypal') {
            return view('pagamentos.paypal', ['pedido' => $order]);
        } elseif ($metodo === 'mbway') {
            return view('pagamentos.mbway', ['pedido' => $order]);
        } else {
            return view('pagamentos.transferencia', ['pedido' => $order]);
        }
    }




}
