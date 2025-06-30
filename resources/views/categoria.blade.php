<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GoldSpades - {{ ucfirst($categoria) }}</title>
    <link rel="stylesheet" href="{{ asset('css/site.css') }}">
</head>
<body>

    <!-- Overlay -->
    <div class="menu-overlay" id="menuOverlay" onclick="closeMenu()"></div>
    <div id="overlay" class="login-overlay" onclick="closeLogin(); closeRegister();"></div>

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
            <li class="highlight"><a href="#">Promoções</a></li>
            <li><a href="#">Contactos</a></li>
            <li><a href="#">Faq’s</a></li>
        </ul>
        <div class="language">🌐 Português</div>
    </div>

    <!-- Cabeçalho -->
    <header>
        <div class="top-bar">Portes grátis em Encomendas acima de 75€</div>

        <div class="header-content">
            <!-- Menu -->
            <div class="menu-button" onclick="toggleMenu()">
                <img src="{{ asset('images/Menu.png') }}" alt="Menu" style="height: 24px;">
            </div>

            <!-- Logo -->
            <a href="{{ route('home') }}">
                <img src="{{ asset('images/Logo.png') }}" alt="GoldSpades" class="logo">
            </a>
            <!-- Ícones -->
            <div class="header-icons">
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

                @auth
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
                            font-size: 12px;
                        ">
                            {{ $totalItens }}
                        </span>
                    @endif
                </button>
                @endauth
            </div>
        </div>
    </header>

    <!-- Conteúdo principal -->
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


    <!-- Painel de Login -->
    <div class="login-panel" id="loginPanel">
        <div class="login-header">
            <span>LOGIN</span>
            <span class="close-login" onclick="closeLogin()">×</span>
        </div>
        <div class="login-content">
            <h2>JÁ TENHO UMA CONTA</h2>
            @if ($errors->any())
                <div style="background-color:#ffe5e5; border:1px solid #ff4d4d; color:#b30000; padding:10px; border-radius:5px; margin-bottom:15px; font-size:14px;">
                    {{ $errors->first() }}
                </div>
            @endif
            <form action="{{ route('login') }}" method="POST">
                @csrf
                <input type="email" name="email" placeholder="E-mail" required>
                <input type="password" name="password" placeholder="Palavra-passe" required>
                <a href="#">Esqueceu a palavra-passe?</a>
                <button type="submit">Iniciar Sessão</button>
            </form>
            <div class="new-user">Novo cliente? <a href="#" onclick="switchToRegister()"><strong>Crie a sua conta</strong></a></div>
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
            <div class="new-user">Já tem uma conta? <a href="#" onclick="switchToLogin()"><strong>Faça o login</strong></a></div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        function toggleMenu() { document.getElementById('sideMenu').classList.toggle('open'); document.getElementById('menuOverlay').classList.toggle('visible'); }
        function closeMenu() { document.getElementById('sideMenu').classList.remove('open'); document.getElementById('menuOverlay').classList.remove('visible'); }
        function openLogin() { document.getElementById('loginPanel').classList.add('show'); document.getElementById('overlay').classList.add('visible'); }
        function closeLogin() { document.getElementById('loginPanel').classList.remove('show'); document.getElementById('overlay').classList.remove('visible'); }
        function openRegister() { document.getElementById('registerPanel').classList.add('show'); document.getElementById('overlay').classList.add('visible'); }
        function closeRegister() { document.getElementById('registerPanel').classList.remove('show'); document.getElementById('overlay').classList.remove('visible'); }
        function switchToRegister() { closeLogin(); setTimeout(() => openRegister(), 300); }
        function switchToLogin() { closeRegister(); setTimeout(() => openLogin(), 300); }
        document.addEventListener('DOMContentLoaded', function () {
            const toggleBtn = document.getElementById('toggleSearch');
            const searchBox = document.getElementById('searchBox');
            toggleBtn.addEventListener('click', function (e) {
                e.preventDefault();
                searchBox.classList.toggle('active');
                const input = searchBox.querySelector('.search-input');
                if (searchBox.classList.contains('active')) { input.focus(); } else { input.value = ''; }
            });
        });
    </script>

@if ($errors->any())
<script>
    window.addEventListener('DOMContentLoaded', () => {
        document.getElementById('loginPanel').classList.add('show');
        document.getElementById('overlay').classList.add('visible');
    });
</script>
@endif



<!-- Painel do Carrinho (copiado do app.blade.php) -->
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
    <button onclick="closeCart()" style="float:right; font-size:20px;">×</button>
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
                            <button onclick="updateCart({{ $produto->id }}, {{ $qtd - 1 }})"
                                {{ $qtd == 1 ? 'disabled' : '' }}>−</button>
                            <span>{{ $qtd }}</span>
                            <!-- retirar botão de adicionar -->
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



<script>

        function openCart() {
            const cart = document.getElementById("cartPanel");
            cart.style.display = "block"; 
            setTimeout(() => { cart.style.right = "0"; }, 10);

            // fecha ao clicar fora
            document.getElementById("menuOverlay").classList.add("visible");
            document.getElementById("menuOverlay").onclick = closeCart;
        }

        function closeCart() {
            const cart = document.getElementById("cartPanel");
            cart.style.right = "-400px";
            setTimeout(() => { cart.style.display = "none"; }, 300);
            document.getElementById("menuOverlay").classList.remove("visible");
        }

    function updateCart(id, quantidade) {
        fetch("{{ route('cart.update') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({id, quantidade})
        }).then(() => location.reload());
    }

    function removeCart(id) {
        fetch(`/cart/remove/${id}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({id})
        }).then(() => location.reload());
    }
</script>




</body>
</html>
