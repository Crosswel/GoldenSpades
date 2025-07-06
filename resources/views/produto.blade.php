@extends('layouts.app')

@section('title', $produto->nome)

@section('content')

<!-- Overlay e menu lateral -->
<div class="menu-overlay" id="menuOverlay" onclick="closeMenu()"></div>
<div id="overlay" class="login-overlay" onclick="closeLogin(); closeRegister();"></div>

<div class="side-menu" id="sideMenu">
    <span class="close-btn" onclick="closeMenu()">×</span>
    <h3>MENU</h3>
    <ul>
            <li><a href="{{ route('categoria', ['categoria' => 'relógios']) }}">Relógios</a></li>
            <li><a href="{{ route('categoria', ['categoria' => 'pulseiras']) }}">Pulseiras</a></li>
            <li><a href="{{ route('categoria', ['categoria' => 'anéis']) }}">Anéis</a></li>
            <li><a href="{{ route('categoria', ['categoria' => 'medalhas']) }}">Medalhas</a></li>
            <li><a href="{{ route('novacolecao') }}">Nova coleção</a></li>
            <li><a href="{{ route('faqs') }}">Faq’s</a></li>
    </ul>
</div>

<!-- Conteúdo do produto -->
<div class="home-container">
    <section style="margin-bottom:40px;">
        <div style="display:flex; justify-content:space-between; align-items:center;">
            <h2 style="margin:0;">{{ $produto->nome }}</h2>
            <a href="{{ route('home') }}" style="color:#d4af37;">&laquo; Voltar</a>
        </div>
        <div style="display: flex; gap: 30px; justify-content: center; align-items: flex-start; margin-top: 30px;">
            <div style="flex:1; max-width:400px;">
                <img src="{{ asset($produto->imagem) }}" alt="{{ $produto->nome }}" style="width:100%; border-radius:8px;">
            </div>
            <div style="flex:1; max-width:400px;">
                <h3 style="margin-top:0;">{{ $produto->nome }}</h3>
                <p style="color:#777;">{{ $produto->descricao }}</p>
                <p style="font-size:1.4rem; font-weight:bold; color:#d4af37;">{{ number_format($produto->preco,2) }} €</p>

                <!-- FORM de adicionar ao carrinho -->
                @auth
                <form method="POST" action="{{ route('cart.add') }}">
                    @csrf
                    <input type="hidden" name="id" value="{{ $produto->id }}">
                    <div style="display:flex; align-items:center; gap:10px; margin:20px 0;">
                        <button type="button" onclick="updateQtd(-1)" style="background:#ddd; border:none; padding:5px 10px;">-</button>
                        <input type="number" name="quantity" id="qtd" value="1" min="1" max="{{ $produto->quantidade }}" style="width:50px; text-align:center;">
                        <button type="button" onclick="updateQtd(1)" style="background:#ddd; border:none; padding:5px 10px;">+</button>
                    </div>
                    <button 
                    type="submit"
                    style="background:#d4af37; color:#fff; border:none; padding:10px 20px; border-radius:4px;"
                    {{ session('carrinho') && isset(session('carrinho')[$produto->id]) && session('carrinho')[$produto->id] >= $produto->quantidade ? 'disabled' : '' }}>
                    Adicionar ao Carrinho
                </button>
                </form>
                @else
                <p style="color:#d4af37; font-weight:bold; margin-top:20px;">
                    É necessário iniciar sessão para comprar.
                </p>
                @endauth
            </div>
        </div>
    </section>
</div>

@include('auth.login-register-panels')

<script>
    function updateQtd(delta) {
        let qtd = document.getElementById('qtd');
        let current = parseInt(qtd.value);
        let max = parseInt(qtd.max);
        let min = parseInt(qtd.min);

        let next = current + delta;
        if (next >= min && next <= max) {
            qtd.value = next;
        }
    }
</script>

@endsection
