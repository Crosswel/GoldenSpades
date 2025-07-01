<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GoldSpades - Nova Coleção</title>
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
            <li><a href="{{ route('faqs') }}">Faq’s</a></li>
        </ul>
        <div class="language">🌐 Português</div>
    </div>

    <!-- Cabeçalho -->
    <header>
        <div class="top-bar">Portes grátis em Encomendas acima de 75€</div>

        <div class="header-content">
            <div class="menu-button" onclick="toggleMenu()">
                <img src="{{ asset('images/Menu.png') }}" alt="Menu" style="height: 24px;">
            </div>
            <a href="{{ route('home') }}">
                <img src="{{ asset('images/Logo.png') }}" alt="GoldSpades" class="logo">
            </a>
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
                <button onclick="openCart()">
                    <img src="{{ asset('images/Carrinho.png') }}" alt="Carrinho" style="height: 24px;">
                </button>
            </div>
        </div>
    </header>

    <!-- Conteúdo principal -->
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

    <!-- Painéis de login iguais ao home -->
    @include('auth.login-register-panels')

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
