@extends('layouts.app')

@section('title', 'GoldSpades - Nova Coleção')

@section('content')
<div class="home-container">
    <section style="margin-bottom:40px;">
        @forelse($produtosPorCategoria as $categoria => $produtos)
            <div style="margin-bottom:30px;">
                <div style="display:flex; justify-content:space-between; align-items:center;">
                    <h2 style="margin:0;">{{ $categoria }}</h2>
                </div>
                <div style="
                    display:flex;
                    gap:20px;
                    overflow-x:auto;
                    padding-bottom:10px;
                    margin-top:15px;">
                    @foreach($produtos as $produto)
                        <div style="
                            flex:0 0 auto;
                            width:250px;
                            background:#fff;
                            border:1px solid #ddd;
                            border-radius:8px;
                            overflow:hidden;
                            box-shadow:0 0 8px rgba(0,0,0,0.1);
                            text-align:center;
                            transition: transform 0.2s;">
                            <a href="{{ route('produto', ['id' => $produto->id]) }}">
                                <img src="{{ asset($produto->imagem) }}" alt="{{ $produto->nome }}" style="width:100%; height:220px; object-fit:cover;">
                            </a>
                            <div style="padding:15px;">
                                <h3 style="font-size:1rem; margin:0;">{{ $produto->nome }}</h3>
                                <p style="margin:5px 0; color:#777;">{{ number_format($produto->preco,2) }} €</p>
                                <a href="{{ route('produto', ['id' => $produto->id]) }}" style="display:inline-block;margin-top:10px;background:#d4af37;color:#fff;padding:8px 15px;border-radius:4px;text-decoration:none;">
                                    Ver detalhes
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @empty
            <p style="margin-top:20px;">Sem novos produtos este mês.</p>
        @endforelse
    </section>
</div>
@endsection
