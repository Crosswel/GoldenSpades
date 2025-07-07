<div id="cartPanel" class="cart-panel">
    <div class="cart-header">
        <strong>CARRINHO</strong>
        <button onclick="closeCart()">×</button>
    </div>

    <div class="cart-content">
        @php
            $carrinho = session('carrinho', []);
            $totalItens = array_sum($carrinho);
            $subtotal = 0;
            foreach($carrinho as $id => $qtd){
                $p = \App\Models\Produto::find($id);
                if($p) $subtotal += $p->preco * $qtd;
            }
        @endphp

        @if($totalItens > 0)
            <div class="cart-items">
                @foreach($carrinho as $id => $qtd)
                    @php $p = \App\Models\Produto::find($id); @endphp
                    @if($p)
                    <div class="cart-item">
                        <img src="{{ asset($p->imagem) }}" alt="{{ $p->nome }}">
                        <div class="cart-item-details">
                            <div class="cart-item-name">
                                {{ $p->nome }} <span>{{ number_format($p->preco,2) }} €</span>
                            </div>
                            <div class="cart-item-controls">
                                <button onclick="updateCart({{ $p->id }}, 'decrement')" {{ $qtd==1?'disabled':'' }}>−</button>
                                <span>{{ $qtd }}</span>
                                <button onclick="updateCart({{ $p->id }}, 'increment')">+</button>
                            </div>
                        </div>
                        <button class="remove" onclick="removeCart({{ $p->id }})">×</button>
                    </div>
                    @endif
                @endforeach
            </div>
            <div class="cart-footer">
                <div class="cart-summary">
                    <strong>Subtotal: {{ number_format($subtotal,2) }} €</strong>
                </div>
                <a href="{{ route('checkout') }}" class="btn-primary">Finalizar Compra</a>
            </div>
        @else
            <p style="text-align:center;">O carrinho está vazio.</p>
        @endif
    </div>
</div>

<style>
.cart-panel {
    position: fixed;
    top: 0;
    right: -400px;
    width: 400px;
    height: 100%;
    background: white;
    box-shadow: -2px 0 5px rgba(0,0,0,0.2);
    transition: right 0.3s ease;
    z-index: 9999;
    overflow-y: auto;
    display: flex;
    flex-direction: column;
}
.cart-panel.show { right: 0; }
.cart-header {
    background: #d4af37;
    color: white;
    padding: 15px;
    font-weight: bold;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.cart-header button {
    background: none;
    border: none;
    color: white;
    font-size: 20px;
    cursor: pointer;
}
.cart-content {
    flex: 1;
    display: flex;
    flex-direction: column;
    padding: 20px;
}
.cart-items {
    flex-grow: 1;
}
.cart-footer {
    position: sticky;
    bottom: 0;
    background: white;
    padding-top: 10px;
    border-top: 1px solid #ddd;
}
.cart-summary {
    text-align: left;
    margin-bottom: 10px;
}
.cart-item {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 15px;
}
.cart-item img {
    width: 50px;
    height: 50px;
    object-fit: cover;
    border-radius: 4px;
}
.cart-item-details {
    flex: 1;
}
.cart-item-name {
    display: flex;
    justify-content: space-between;
    font-weight: bold;
}
.cart-item-controls {
    margin-top: 5px;
    display: flex;
    gap: 5px;
    align-items: center;
}
.cart-item-controls button {
    background: #d4af37;
    color: white;
    border: none;
    padding: 5px 8px;
    border-radius: 4px;
    cursor: pointer;
}
.cart-item .remove {
    background: none;
    border: none;
    font-size: 18px;
    cursor: pointer;
}
.btn-primary {
    display: block;
    width: 100%;
    background: #d4af37;
    color: white;
    border: none;
    padding: 10px;
    text-align: center;
    border-radius: 4px;
    cursor: pointer;
}
</style>
