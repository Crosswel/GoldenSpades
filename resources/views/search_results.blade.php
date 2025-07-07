@extends('layouts.app')

@section('content')
    <h2>Resultados da pesquisa</h2>
    <div id="productContainer">
        @if($produtos->count())
            @foreach($produtos as $product)
                <div class="product-card">
                    <img src="{{ asset($product->imagem) }}" alt="{{ $product->nome }}">
                    <h4>{{ $product->nome }}</h4>
                    <p>{{ number_format($product->preco,2) }} €</p>
                    <a href="{{ route('produto', $product->id) }}" class="btn">Ver mais</a>
                </div>
            @endforeach
        @else
            <p>Sem resultados.</p>
        @endif
    </div>
@endsection
