@extends('layouts.profile')

@section('content')
<div class="container" style="max-width: 700px; margin: 50px auto;">
    <h1 style="margin-bottom: 30px;">O meu perfil</h1>

    <div style="border: 1px solid #ccc; padding: 20px; border-radius: 8px; margin-bottom: 30px;">
        <p><strong>Nome:</strong> {{ Auth::user()->name }}</p>
        <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
        <p><strong>Morada associada:</strong> {{ Auth::user()->address ?? 'Nenhuma registada' }}</p>

        <form method="POST" action="{{ route('logout') }}" style="margin-top: 20px;">
            @csrf
            <button type="submit" style="
                background-color: #c0392b;
                color: white;
                border: none;
                padding: 10px 20px;
                border-radius: 5px;
                cursor: pointer;
            ">
                Terminar Sessão
            </button>
        </form>
    </div>

<div style="border: 1px solid #d4af37; padding: 20px; border-radius: 8px;">
    <h2 style="margin-bottom: 15px;">🛒 Histórico de Compras</h2>

    @if($orders->count())
        @foreach($orders as $order)
            <div style="background:#f9f9f9; padding:10px; margin-bottom:10px; border-radius:5px;">
                <strong>Compra #{{ $order->id }}</strong> <br>
                <span><strong>Método:</strong> {{ ucfirst($order->metodo) }}</span> <br>
                <span><strong>Estado:</strong> {{ $order->estado }}</span> <br>
                <span><strong>Endereço:</strong> {{ $order->endereco }}</span> <br>
                <span style="font-size:12px; color:#777;">
                    {{ $order->created_at->format('d/m/Y H:i') }}
                </span>
                <div style="margin-top:10px;">
                    <strong>Itens:</strong>
                    @forelse($order->items as $item)
                        <div style="margin-top:5px;">
                            <img src="{{ asset($item->produto->imagem) }}" style="width:40px; vertical-align:middle;">
                            {{ $item->produto->nome }} x {{ $item->quantidade }} —
                            {{ number_format($item->preco * $item->quantidade,2) }} €
                        </div>
                    @empty
                        <div>Nenhum item registado.</div>
                    @endforelse
                </div>
                <div style="margin-top:5px;font-weight:bold;">
                    Total:
                    {{
                        number_format(
                            $order->items->sum(function($i){
                                return $i->preco * $i->quantidade;
                            }),
                            2
                        )
                    }} €
                </div>
            </div>
        @endforeach
    @else
        <p>Sem compras registadas.</p>
    @endif
</div>


</div>
@endsection
