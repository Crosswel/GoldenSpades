<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GoldSpades - Home</title>
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
            <li><a href="#">Relógios</a></li>
            <li><a href="#">Pulseiras</a></li>
            <li><a href="#">Anéis</a></li>
            <li><a href="#">Medalhas</a></li>
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
                <!-- Pesquisa -->
                <div class="search-container" id="searchBox">
                    <form id="searchForm" action="{{ route('search') }}" method="GET">
                        <input type="text" name="q" placeholder="Procurar produto..." class="search-input" required>
                        <button type="submit" class="search-icon" id="toggleSearch">
                            <img src="{{ asset('images/Pesquisa.png') }}" alt="Pesquisar" style="height: 20px;">
                        </button>
                    </form>
                </div>

                <!-- Login / Perfil -->
                @guest
                    <button onclick="openLogin()">
                        <img src="{{ asset('images/Profile.png') }}" alt="Login" style="height: 24px;">
                    </button>
                @else
                    <a href="{{ route('profile') }}">
                        <img src="{{ asset('images/Profile.png') }}" alt="Perfil" style="height: 24px;">
                    </a>
                @endguest

                <!-- Favoritos -->
                <a href="{{ route('favoritos') }}">
                    <img src="{{ asset('images/Favorito.png') }}" alt="Favoritos" style="height: 24px;">
                </a>

                <!-- Carrinho -->
                <button onclick="openCart()">
                    <img src="{{ asset('images/Carrinho.png') }}" alt="Carrinho" style="height: 24px;">
                </button>
            </div>
        </div>
    </header>

    <!-- Conteúdo principal -->
    <div class="home-container">
        <div class="gallery">
            <h2>Relógios</h2>
            <div class="products-grid">
                @foreach($produtos as $produto)
                    <div class="product-card">
                        <a href="{{ route('produto', ['id' => $produto->id]) }}">
                            <img src="{{ asset('storage/' . $produto->imagem) }}" alt="{{ $produto->nome }}">
                        </a>
                        <p>{{ $produto->nome }}</p>
                    </div>
                @endforeach
            </div>
        </div>
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
                <div style="
                    background-color: #ffe5e5;
                    border: 1px solid #ff4d4d;
                    color: #b30000;
                    padding: 10px;
                    border-radius: 5px;
                    margin-bottom: 15px;
                    font-size: 14px;
                ">
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

        function switchToRegister() {
            closeLogin();
            setTimeout(() => openRegister(), 300);
        }

        function switchToLogin() {
            closeRegister();
            setTimeout(() => openLogin(), 300);
        }

        function openCart() {
            alert("Abrir carrinho (Funcionalidade futura)");
        }

        // 🔍 Toggle da barra de busca
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

@if ($errors->any())
<script>
    window.addEventListener('DOMContentLoaded', () => {
        document.getElementById('loginPanel').classList.add('show');
        document.getElementById('overlay').classList.add('visible');
    });
</script>
@endif

</body>
</html>
