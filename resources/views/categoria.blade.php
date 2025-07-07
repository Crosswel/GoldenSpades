@extends('layouts.app')

@section('title', 'GoldSpades - ' . ucfirst($categoria))

@section('content')
<div class="home-container">
    <section style="margin-bottom:40px;">
        <div style="margin-bottom: 15px;">
            <h2 style="margin:0;">{{ ucfirst($categoria) }}</h2>
        </div>

        <div class="products-grid"
             style="
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
                gap: 20px;
                justify-content: center;
                align-items: start;
                margin-top: 15px;
                max-width: 1200px;
                margin-left: auto;
                margin-right: auto;
             ">
            @forelse($produtos as $produto)
                <div class="product-card"
                     style="
                        background:#fff;
                        border:1px solid #ddd;
                        border-radius:8px;
                        overflow:hidden;
                        box-shadow:0 0 8px rgba(0,0,0,0.1);
                        text-align:center;
                        transition: transform 0.2s;
                        width: 100%;
                        max-width: 300px;
                     ">
                    <a href="{{ route('produto', ['id' => $produto->id]) }}">
                        <img src="{{ asset($produto->imagem) }}"
                             alt="{{ $produto->nome }}"
                             style="width:100%; height:220px; object-fit:cover;">
                    </a>
                    <div style="padding:15px;">
                        <h3 style="font-size:1rem; margin:0;">{{ $produto->nome }}</h3>
                        <p style="margin:5px 0; color:#777;">{{ number_format($produto->preco,2) }} €</p>
                        <a href="{{ route('produto', ['id' => $produto->id]) }}"
                           style="display:inline-block;margin-top:10px;background:#d4af37;color:#fff;
                           padding:8px 15px;border-radius:4px;text-decoration:none;">
                           Ver detalhes
                        </a>
                    </div>
                </div>
            @empty
                <p>Sem produtos nesta categoria.</p>
            @endforelse
        </div>

        <div style="margin-top:20px;">
            {{ $produtos->links() }}
        </div>
    </section>
</div>
@endsection
