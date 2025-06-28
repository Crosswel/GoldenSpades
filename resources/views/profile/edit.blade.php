@extends('layouts.app')

@section('title', 'Perfil')

@section('content')
<style>
    html, body {
        height: 100%;
        margin: 0;
        padding: 0;
        background-color: #f7f8fc;
    }

    body {
        display: flex;
        justify-content: center;
        align-items: center;
        font-family: 'Figtree', sans-serif;
    }

    .profile-page {
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 100%;
        max-width: 900px;
    }

    .logo-centered {
        display: block;
        margin-bottom: 40px;
        height: 100px;
    }

    .tab-buttons {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
        flex-wrap: wrap;
        justify-content: center;
    }

    .tab-button {
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        background-color: #d4af37;
        color: white;
        font-weight: bold;
        cursor: pointer;
    }

    .tab-button.active {
        background-color: #bfa134;
    }

    .gold-border-box {
        border: 2px solid gold;
        border-radius: 10px;
        padding: 30px;
        width: 100%;
        background-color: #fff;
        margin-bottom: 30px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
        position: relative;
    }

    .btn-primary {
        background-color: #d4af37;
        border: none;
        color: white;
        padding: 10px 20px;
        font-weight: bold;
        cursor: pointer;
        border-radius: 4px;
    }

    .btn-logout {
        background-color: #dc3545;
        color: white;
        border: none;
        padding: 10px 20px;
        font-weight: bold;
        border-radius: 4px;
        cursor: pointer;
    }

    .form-label {
        font-weight: bold;
        display: block;
        margin-bottom: 5px;
    }

    .form-control {
        width: 100%;
        padding: 8px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .list-group {
        list-style: none;
        padding: 0;
        margin-top: 15px;
    }

    .list-group-item {
        padding: 10px;
        border: 1px solid #ddd;
        margin-bottom: 5px;
        border-radius: 4px;
        background-color: #f9f9f9;
    }

    .top-right-button {
        position: absolute;
        top: 30px;
        right: 30px;
    }
</style>

<script>
    function toggleTab(tab) {
        document.getElementById('profile-section').style.display = tab === 'profile' ? 'block' : 'none';
        document.getElementById('history-section').style.display = tab === 'history' ? 'block' : 'none';
        @if($user->usertype == 0)
        document.getElementById('product-section').style.display = tab === 'products' ? 'block' : 'none';
        @endif

        document.getElementById('btn-profile').classList.toggle('active', tab === 'profile');
        document.getElementById('btn-history').classList.toggle('active', tab === 'history');
        @if($user->usertype == 0)
        document.getElementById('btn-products').classList.toggle('active', tab === 'products');
        @endif
    }

    function toggleNewProductForm() {
        const form = document.getElementById('new-product-form');
        form.style.display = form.style.display === 'none' ? 'block' : 'none';
    }

    document.addEventListener('DOMContentLoaded', () => toggleTab('profile'));
</script>

<div class="profile-page">
    <a href="/">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo-centered">
    </a>

    <div class="tab-buttons">
        <button id="btn-profile" class="tab-button" onclick="toggleTab('profile')">Editar Perfil</button>
        <button id="btn-history" class="tab-button" onclick="toggleTab('history')">Histórico</button>
        @if($user->usertype == 0)
        <button id="btn-products" class="tab-button" onclick="toggleTab('products')">Produto</button>
        @endif
    </div>

    <!-- Editar Perfil -->
    <div id="profile-section" class="gold-border-box">
        <h3 class="mb-4">Editar Perfil</h3>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}">
            @csrf

            <label for="email" class="form-label">Email</label>
            <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>

            <label for="address" class="form-label">Morada</label>
            <input type="text" id="address" name="address" class="form-control" value="{{ old('address', $user->address) }}">

            <label for="phone" class="form-label">Telefone</label>
            <input type="text" id="phone" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">

            <button type="submit" class="btn-primary">Guardar Alterações</button>
        </form>

        <form method="POST" action="{{ route('logout') }}" style="margin-top: 15px;">
            @csrf
            <button type="submit" class="btn-logout">Terminar Sessão</button>
        </form>
    </div>

    <!-- Histórico -->
    <div id="history-section" class="gold-border-box" style="display: none;">
        <h4>Histórico de Compras</h4>
        @if($orders && count($orders))
            <ul class="list-group">
                @foreach($orders as $order)
                    <li class="list-group-item">
                        Compra #{{ $order->id }} — {{ $order->created_at->format('d/m/Y') }} — Total: {{ number_format($order->total, 2) }}€
                    </li>
                @endforeach
            </ul>
        @else
            <p>Sem compras registadas.</p>
        @endif
    </div>

    <!-- Produtos (Admin Only) -->
    @if($user->usertype == 0)
    <div id="product-section" class="gold-border-box" style="display: none;">
        <h4>Gestão de Produtos</h4>

        <button onclick="toggleNewProductForm()" class="btn-primary top-right-button">+ Novo Produto</button>

        <div id="new-product-form" style="display: none; margin-top: 20px;">
            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <label class="form-label">Nome</label>
                <input type="text" name="nome" class="form-control" required>

                <label class="form-label">Imagem</label>
                <input type="file" name="imagem" class="form-control" required>

                <label class="form-label">Categoria</label>
                <input type="text" name="categoria" class="form-control" required>

                <label class="form-label">Descrição</label>
                <textarea name="descricao" class="form-control" required></textarea>

                <label class="form-label">Preço (€)</label>
                <input type="number" step="0.01" name="preco" class="form-control" required>

                <label class="form-label">Quantidade</label>
                <input type="number" name="quantidade" class="form-control" min="0" required>

                <button type="submit" class="btn-primary" style="margin-top: 10px;">Inserir</button>
            </form>
        </div>

        @if(isset($products) && count($products))
            <ul class="list-group mt-4">
                @foreach($products as $product)
    <li class="list-group-item" style="display: flex; align-items: center; justify-content: space-between; gap: 20px; padding: 15px;">
        
        <div style="flex: 0 0 120px;">
            @if($product->imagem)
                <img src="{{ asset('storage/' . $product->imagem) }}"
                     alt="{{ $product->nome }}"
                     style="width: 120px; height: 120px; object-fit: cover; border-radius: 8px; border: 1px solid #ccc;">
            @else
                <div style="width: 120px; height: 120px; background-color: #eee; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                    <span>Sem imagem</span>
                </div>
            @endif
        </div>

        <div style="flex: 1;">
            <h4 style="margin: 0 0 5px 0;">{{ $product->nome }}</h4>
            <p style="margin: 0 0 5px 0;">{{ $product->descricao }}</p>
            <p style="margin: 0 0 5px 0;"><strong>Categoria:</strong> {{ $product->categoria }}</p>
            <p style="margin: 0 0 5px 0;"><strong>Preço:</strong> {{ number_format($product->preco, 2) }} €</p>
            <p style="margin: 0;"><strong>Quantidade:</strong> {{ $product->quantidade }}</p>
        </div>

        <div style="display: flex; flex-direction: column; gap: 8px;">
            <a href="{{ route('products.edit', $product->id) }}" class="btn-primary">Editar</a>
            <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline-block;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-logout" onclick="return confirm('Eliminar este produto?')">Eliminar</button>
            </form>
        </div>
    </li>
@endforeach

            </ul>


        @else
            <p>Sem produtos registados.</p>
        @endif
    </div>
    @endif
</div>
@endsection
