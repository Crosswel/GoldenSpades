<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'GoldSpades')</title>
    <link rel="stylesheet" href="{{ asset('css/site.css') }}">
</head>
<body>

    <!-- Overlay -->
    <div class="menu-overlay" id="menuOverlay" onclick="closeMenu()"></div>
    <div id="overlay" class="login-overlay" onclick="closeLogin(); closeRegister(); closeCart();"></div>


    <!-- Menu Lateral -->
    <div class="side-menu" id="sideMenu">
        <span class="close-btn" onclick="closeMenu()">×</span>
        <h3>MENU</h3>
        <input type="text" class="search-bar" placeholder="🔍 Pesquisar">
        <ul>
            <li><a href="{{ route('categoria', ['categoria' => 'relógios']) }}">Relógios</a></li>
            <li><a href="{{ route('categoria', ['categoria' => 'pulseiras']) }}">Pulseiras</a></li>
            <li><a href="{{ route('categoria', ['categoria' => 'anéis']) }}">Anéis</a></li>
            <li><a href="{{ route('categoria', ['categoria' => 'medalhas']) }}">Medalhas</a></li>
            <li><a href="{{ route('novacolecao') }}">Nova coleção</a></li>
            <a href="{{ route('faqs') }}">FAQ</a>

        </ul>
        <div class="language">🌐 Português</div>
    </div>

    <!-- Cabeçalho -->
    <header>
        <div class="top-bar">Portes grátis em Encomendas acima de 75€</div>
        <div class="header-content">
            <!-- Botão menu -->
            <div class="menu-button" onclick="toggleMenu()">
                <img src="{{ asset('images/Menu.png') }}" alt="Menu" style="height: 24px;">
            </div>
            <!-- Logo -->
            <a href="{{ route('home') }}">
                <img src="{{ asset('images/Logo.png') }}" alt="GoldSpades" class="logo">
            </a>
            <!-- Icons -->
            <div class="header-icons">
                <!-- Pesquisa -->
                <div class="search-container" id="searchBox">
                    <form id="searchForm" action="{{ route('search') }}" method="GET">
                        <input type="text" name="q" placeholder="Procurar produto..." class="search-input" required>
                        <button type="submit" class="search-icon" id="toggleSearch">
                            <img src="{{ asset('images/Pesquisa.png') }}" alt="Pesquisar" style="height: 20px;">
                        </button>
                    </form>
                </div>
                @guest
                    <button onclick="openLogin()">
                        <img src="{{ asset('images/Profile.png') }}" alt="Login" style="height: 24px;">
                    </button>
                @else
                    <a href="{{ route('profile') }}">
                        <img src="{{ asset('images/Profile.png') }}" alt="Perfil" style="height: 24px;">
                    </a>
                @endguest
                <a href="{{ route('favoritos') }}">
                    <img src="{{ asset('images/Favorito.png') }}" alt="Favoritos" style="height: 24px;">
                </a>
                
                @php
                    $carrinho = session('carrinho', []);
                    $totalItens = array_sum($carrinho);
                @endphp
                <button onclick="openCart()" style="position:relative;">
                    <img src="{{ asset('images/Carrinho.png') }}" alt="Carrinho" style="height: 24px;">
                    @if($totalItens > 0)
                        <span style="
                            position: absolute;
                            top: -5px;
                            right: -5px;
                            background: #d4af37;
                            color: white;
                            border-radius: 50%;
                            padding: 2px 6px;
                            font-size: 12px;">
                            {{ $totalItens }}
                        </span>
                    @endif
                </button>

            </div>
        </div>
    </header>

    <!-- Conteúdo dinâmico -->
    <main class="home-container" style="padding: 20px;">
        @yield('content')
    </main>

    <!-- Painel de Login -->
    <div class="login-panel" id="loginPanel">
        <div class="login-header">
            <span>LOGIN</span>
            <span class="close-login" onclick="closeLogin()">×</span>
        </div>
        <div class="login-content">
            <h2>JÁ TENHO UMA CONTA</h2>
            <form action="{{ route('login') }}" method="POST">
                @csrf
                <input type="email" name="email" placeholder="E-mail" required>
                <input type="password" name="password" placeholder="Palavra-passe" required>
                <button type="submit">Iniciar Sessão</button>
            </form>
            <div class="new-user">
                Novo cliente? <a href="#" onclick="switchToRegister()"><strong>Crie a sua conta</strong></a>
            </div>
        </div>
    </div>

    <!-- Painel de Registo -->
    <div class="register-panel" id="registerPanel">
        <div class="login-header">
            <span>REGISTAR</span>
            <span class="close-login" onclick="closeRegister()">×</span>
        </div>
        <div class="login-content">
            <h2>CRIAR UMA CONTA</h2>
            <form action="{{ route('register') }}" method="POST">
                @csrf
                <input type="text" name="name" placeholder="Nome" required>
                <input type="email" name="email" placeholder="E-mail" required>
                <input type="password" name="password" placeholder="Palavra-passe" required>
                <input type="password" name="password_confirmation" placeholder="Confirmar palavra-passe" required>
                <button type="submit">Registar</button>
            </form>
            <div class="new-user">
                Já tem uma conta? <a href="#" onclick="switchToLogin()"><strong>Faça o login</strong></a>
            </div>
        </div>
    </div>

    <!-- Carrinho (podes manter se quiseres ou adaptar) -->

<div id="cartPanel" style="
    position:fixed;
    top:0;
    right:-400px;
    width:400px;
    height:100%;
    background:white;
    box-shadow:-2px 0 5px rgba(0,0,0,0.2);
    padding:20px;
    transition:right 0.3s ease;
    z-index:9999;
    overflow-y:auto;
    display:none;
">
    <button onclick="closeCart()" style="float:right; font-size:20px;">&times;</button>
    <h2 style="margin-top:30px;">Carrinho</h2>
    <hr>
    @php
        $carrinho = session('carrinho', []);
        $totalItens = array_sum($carrinho);
        $subtotal = 0;
    @endphp
    @if($totalItens > 0)
        @foreach($carrinho as $id => $qtd)
            @php
                $produto = \App\Models\Produto::find($id);
                $subtotal += $produto->preco * $qtd;
            @endphp
            @if($produto)
                <div style="display:flex;align-items:center;gap:10px;margin-bottom:15px;">
                    <img src="{{ asset($produto->imagem) }}" style="width:60px;">
                    <div style="flex:1;">
                        <div>{{ $produto->nome }}</div>
                        <div>{{ number_format($produto->preco, 2) }} €</div>
                        <div style="margin-top:5px;">
                            <button onclick="updateCart({{ $produto->id }}, 'decrement')" {{ $qtd == 1 ? 'disabled' : '' }}>−</button>
                            <span>{{ $qtd }}</span>
                        </div>
                    </div>
                    <button onclick="removeCart({{ $produto->id }})" style="border:none;background:none;">
                        <img src="{{ asset('images/Lixo.PNG') }}" style="width:20px;">
                    </button>
                </div>
            @endif
        @endforeach
        <hr>
        <div style="font-weight:bold;">Subtotal: {{ number_format($subtotal, 2) }} €</div>
        <a href="{{ route('checkout') }}"
            style="display:block; background:#d4af37; color:white; padding:10px; text-align:center;
                   margin-top:20px; border-radius:4px;">
            Finalizar Compra
        </a>
    @else
        <p>O carrinho está vazio.</p>
    @endif
</div>




    <!-- Scripts -->
    <script>
        function toggleMenu() {
            document.getElementById('sideMenu').classList.toggle('open');
            document.getElementById('menuOverlay').classList.toggle('visible');
        }
        function closeMenu() {
            document.getElementById('sideMenu').classList.remove('open');
            document.getElementById('menuOverlay').classList.remove('visible');
        }
        function openLogin() {
            document.getElementById('loginPanel').classList.add('show');
            document.getElementById('overlay').classList.add('visible');
        }
        function closeLogin() {
            document.getElementById('loginPanel').classList.remove('show');
            document.getElementById('overlay').classList.remove('visible');
        }
        function openRegister() {
            document.getElementById('registerPanel').classList.add('show');
            document.getElementById('overlay').classList.add('visible');
        }
        function closeRegister() {
            document.getElementById('registerPanel').classList.remove('show');
            document.getElementById('overlay').classList.remove('visible');
        }


        function openCart() {
    const cart = document.getElementById("cartPanel");
    const overlay = document.getElementById("overlay");
    cart.style.display = "block"; 
    setTimeout(() => { cart.style.right = "0"; }, 10);
    overlay.classList.add('visible');
        }
        function closeCart() {
    const cart = document.getElementById("cartPanel");
    const overlay = document.getElementById("overlay");
    cart.style.right = "-400px";
    setTimeout(() => { cart.style.display = "none"; }, 300);
    overlay.classList.remove('visible');
        }

        // AJAX
        function updateCart(id, action) {
    fetch("{{ route('cart.update') }}", {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({id, action})
    }).then(() => location.reload());
}

        function removeCart(id) {
    fetch(`/cart/remove/${id}`, {
        method: 'GET'
    }).then(() => location.reload());
}



        // toggle pesquisa
        document.addEventListener('DOMContentLoaded', function () {
            const toggleBtn = document.getElementById('toggleSearch');
            const searchBox = document.getElementById('searchBox');
            toggleBtn.addEventListener('click', function (e) {
                e.preventDefault();
                searchBox.classList.toggle('active');
                const input = searchBox.querySelector('.search-input');
                if (searchBox.classList.contains('active')) {
                    input.focus();
                } else {
                    input.value = '';
                }
            });
        });
    </script>

</body>
</html>
