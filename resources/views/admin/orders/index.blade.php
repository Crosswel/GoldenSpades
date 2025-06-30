@extends('layouts.profile')

@section('title', 'Gestão de Pedidos')

@section('content')
<div class="container" style="max-width:900px; margin:50px auto;">
    <h2>📦 Gestão de Pedidos</h2>

    @if(session('success'))
        <div style="background:#d4edda;color:#155724;padding:10px;border:1px solid #c3e6cb;margin-top:10px;">
            {{ session('success') }}
        </div>
    @endif

    @if($orders->count())
        @foreach($orders as $order)
            <div style="border:1px solid #ddd;padding:15px;margin-top:20px;border-radius:5px;">
                <strong>Pedido #{{ $order->id }}</strong> <br>
                <strong>Utilizador:</strong> {{ $order->user->name }} ({{ $order->user->email }}) <br>
                <strong>Data:</strong> {{ $order->created_at->format('d/m/Y H:i') }} <br>
                <strong>Método:</strong> {{ ucfirst($order->metodo) }} <br>
                <strong>Endereço:</strong> {{ $order->endereco }} <br>
                <strong>Estado:</strong> 
                @if($order->estado === 'Pendente')
                    <form method="POST" action="{{ route('admin.orders.update', $order->id) }}" style="display:inline;">
                        @csrf
                        @method('PATCH')
                        <button type="submit" style="background:#d4af37;color:white;border:none;padding:5px 10px;border-radius:4px;cursor:pointer;">
                            Marcar como Enviado
                        </button>
                    </form>
                @else
                    <span style="color:green;">{{ $order->estado }}</span>
                @endif

                <div style="margin-top:10px;">
                    <strong>Itens:</strong>
                    <ul style="list-style:none;padding:0;margin:0;">
                        @foreach($order->items as $item)
                            <li style="margin-top:5px;">
                                <img src="{{ asset($item->produto->imagem) }}" style="width:50px;vertical-align:middle;margin-right:10px;">
                                {{ $item->produto->nome }} (x {{ $item->quantidade }}) — 
                                {{ number_format($item->preco, 2) }} €
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div style="font-weight:bold;margin-top:10px;">
                    Total: 
                    {{
                        number_format(
                            $order->items->sum(fn($i) => $i->preco * $i->quantidade) + 
                            ($order->items->sum(fn($i) => $i->preco * $i->quantidade) < 75 ? 7.5 : 0),
                        2)
                    }} €
                </div>
            </div>
        @endforeach
    @else
        <p>Sem pedidos registados.</p>
    @endif
</div>
@endsection