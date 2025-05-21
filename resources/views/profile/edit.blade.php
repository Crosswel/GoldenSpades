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
        max-width: 700px;
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

    .btn-primary:hover {
        background-color: #bfa134;
    }

    .btn-logout {
        background-color: #dc3545;
        color: white;
        border: none;
        padding: 10px 20px;
        font-weight: bold;
        border-radius: 4px;
        cursor: pointer;
        float: right;
    }

    .btn-logout:hover {
        background-color: #c82333;
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
</style>

<script>
    function toggleTab(tab) {
        document.getElementById('profile-section').style.display = tab === 'profile' ? 'block' : 'none';
        document.getElementById('history-section').style.display = tab === 'history' ? 'block' : 'none';

        document.getElementById('btn-profile').classList.toggle('active', tab === 'profile');
        document.getElementById('btn-history').classList.toggle('active', tab === 'history');
    }

    document.addEventListener('DOMContentLoaded', () => toggleTab('profile'));
</script>

<div class="profile-page">
    <a href="/">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo-centered">
    </a>

    <!-- Botões de navegação -->
    <div class="tab-buttons">
        <button id="btn-profile" class="tab-button" onclick="toggleTab('profile')">Editar Perfil</button>
        <button id="btn-history" class="tab-button" onclick="toggleTab('history')">Histórico</button>
    </div>

    <!-- Secção: Editar Perfil -->
    <div id="profile-section" class="gold-border-box">
        <h3 class="mb-4">Editar Perfil</h3>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}">
            @csrf

            <label for="email" class="form-label">Email</label>
            <input type="email" id="email" name="email" class="form-control"
                   value="{{ old('email', $user->email) }}" required>

            <label for="address" class="form-label">Morada</label>
            <input type="text" id="address" name="address" class="form-control"
                   value="{{ old('address', $user->address) }}">

            <label for="phone" class="form-label">Telefone</label>
            <input type="text" id="phone" name="phone" class="form-control"
                   value="{{ old('phone', $user->phone) }}">

            <button type="submit" class="btn-primary">Guardar Alterações</button>
        </form>

        <form method="POST" action="{{ route('logout') }}" style="margin-top: 15px;">
            @csrf
            <button type="submit" class="btn-logout">Terminar Sessão</button>
        </form>
    </div>

    <!-- Secção: Histórico -->
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
</div>
@endsection
