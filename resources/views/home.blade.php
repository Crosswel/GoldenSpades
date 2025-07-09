@extends('layouts.app')

@section('title', 'GoldSpades - Home')

@section('content')
<div class="home-container">
    @php
        $produtosPorCategoria = $produtosPorCategoria ?? collect();
    @endphp

    @foreach($produtosPorCategoria as $categoria => $produtos)
        @php
            $produtos = $produtos->shuffle()->take(3);
        @endphp

        @if($produtos->count())
            <section style="margin-bottom:40px;">
                <div style="display:flex; justify-content:space-between; align-items:center;">
                    <h2 style="margin:0;">{{ $categoria }}</h2>
                    <a href="{{ route('categoria', ['categoria' => strtolower($categoria)]) }}"
                        style="color:#d4af37; font-weight:bold; text-decoration:none;">
                        Ver mais &raquo;
                    </a>
                </div>

                <div class="products-grid"
                    style="
                        display: grid;
                        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
                        gap: 20px;
                        justify-content: center;
                        align-items: stretch;
                        margin-top: 15px;
                        max-width: 1200px;
                        margin-left: auto;
                        margin-right: auto;
                    ">
                    @foreach($produtos as $produto)
                        <div class="product-card"
                            style="
                                background:#fff;
                                border:1px solid #ddd;
                                border-radius:8px;
                                overflow:hidden;
                                box-shadow:0 0 8px rgba(0,0,0,0.1);
                                text-align:center;
                                transition: transform 0.2s;
                                display: flex;
                                flex-direction: column;
                            ">
                            <a href="{{ route('produto', ['id' => $produto->id]) }}">
                                <img src="{{ asset($produto->imagem) }}"
                                    alt="{{ $produto->nome }}"
                                    style="width:100%; height:220px; object-fit:cover;">
                            </a>
                            <div style="padding:15px; flex-grow:1; display:flex; flex-direction:column; justify-content:space-between;">
                                <div>
                                    <h3 style="font-size:1rem; margin:0;">{{ $produto->nome }}</h3>
                                    <p style="margin:5px 0; color:#777;">
                                        {{ number_format($produto->preco, 2) }} €
                                    </p>
                                </div>
                                <a href="{{ route('produto', ['id' => $produto->id]) }}"
                                    style="
                                        margin-top:10px;
                                        background:#d4af37;
                                        color:#fff;
                                        padding:8px 15px;
                                        border-radius:4px;
                                        text-decoration:none;
                                    ">
                                    Ver detalhes
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif
    @endforeach
</div>
@endsection
