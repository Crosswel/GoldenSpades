@extends('layouts.app')

@section('content')
<style>
    body {
        background-color: white;
    }

    .profile-page {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding-top: 60px;
    }

    .logo-centered {
        position: fixed;
        top: 10px;
        left: 50%;
        transform: translateX(-50%);
        height: 40px;
    }

    .gold-border-box {
        border: 2px solid gold;
        border-radius: 10px;
        padding: 30px;
        width: 100%;
        max-width: 600px;
        background-color: #fff;
        margin-bottom: 40px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
    }

    .btn-primary {
        background-color: #d4af37;
        border-color: #d4af37;
        color: white;
    }

    .btn-primary:hover {
        background-color: #bfa134;
        border-color: #bfa134;
    }

    .form-label {
        font-weight: bold;
    }
</style>

<!-- Logotipo centrado -->
<a href="/">
    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo-centered">
</a>

<div class="profile-page">
    <!-- Formulário de edição de perfil -->
    <div class="gold-border-box">
        <h3 class="mb-4">Editar Perfil</h3>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" name="email" class="form-control"
                       value="{{ old('email', $user->email) }}" required>
            </div>

            <div class="mb-3">
                <label for="address" class="form-label">Morada</label>
                <input type="text" id="address" name="address" class="form-control"
                       value="{{ old('address', $profile->address ?? '') }}">
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label">Telefone</label>
                <input type="text" id="phone" name="phone" class="form-control"
                       value="{{ old('phone', $profile->phone ?? '') }}">
            </div>

            <button type="submit" class="btn btn-primary">Guardar Alterações</button>
        </form>
    </div>

    <!-- Histórico de compras -->
    @if($orders && count($orders))
        <div class="gold-border-box">
            <h4>Histórico de Compras</h4>
            <ul class="list-group">
                @foreach($orders as $order)
                    <li class="list-group-item">
                        Compra #{{ $order->id }} — {{ $order->created_at->format('d/m/Y') }} — Total: {{ number_format($order->total, 2) }}€
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
@endsection
