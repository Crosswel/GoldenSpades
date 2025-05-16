<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Nova Coleção - GoldSpades</title>
    <link rel="stylesheet" href="{{ asset('css/site.css') }}">
</head>
<body>

    <!-- Overlays -->
    <div class="menu-overlay" id="menuOverlay" onclick="closeMenu()"></div>
    <div id="overlay" class="login-overlay" onclick="closeLogin(); closeRegister();"></div>

    <!-- Top Bar -->
    <div class="top-bar">
        Portes grátis em Encomendas acima de 75€
    </div>

    <!-- Cabeçalho -->
    <div class="header">
        <div class="menu-icon" onclick="toggleMenu()">
            <img src="{{ asset('images/Menu.png') }}" alt="Menu" style="height: 24px;">
        </div>
        <div class="logo">
            <a href="/">
                <img src="{{ asset('images/Logo.png') }}" alt="GoldSpades Logo" style="height: 80px;">
            </a>
        </div>
        <div class="icons">
            <div class="search-container">
                <input type="text" name="query" id="searchInput" class="search-input" placeholder="Procurar produto...">
                <button class="search-icon">
                    <img src="{{ asset('images/Pesquisa.png') }}" alt="Pesquisar" style="height: 20px;">
                </button>
            </div>
            <span onclick="openLogin()">
                <img src="{{ asset('images/Profile.png') }}" alt="Perfil" style="height: 24px;">
            </span>
            <span onclick="window.location.href='/favoritos'">
                <img src="{{ asset('images/Favorito.png') }}" alt="Favoritos" style="height: 24px;">
            </span>
            <span onclick="toggleCart()">
                <img src="{{ asset('images/Carrinho.png') }}" alt="Carrinho" style="height: 24px;">
            </span>
        </div>
    </div>

    <!-- Menu Lateral -->
    <div class="side-menu" id="sideMenu">
        <span class="close-btn" onclick="closeMenu()">×</span>
        <h3>MENU</h3>
        <input class="search-bar" type="text" placeholder="🔍 Pesquisar">
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
        <div class="language">🌐 Português - Portugal</div>
    </div>

    <!-- Conteúdo Nova Coleção -->
    <div class="gallery">
        <div class="gallery-title" style="width: 100%; text-align: left; padding: 0 40px;">
            <h2 style="color: #7b5a16;">Nova Coleção</h2>
        </div>

        <div class="gallery" style="margin-top: 20px;">
            @foreach([
                'colecao1.jpg' => '',
                'pulseira1.jpg' => 'Pulseira',
                'pulseira2.jpg' => 'Pulseira',
                'colar.jpg'     => 'Colar',
                'brincos.jpg'   => 'Brincos'
            ] as $img => $label)
                <div>
                    <a href="{{ route('produto') }}">
                        <img src="{{ asset('images/' . $img) }}" alt="{{ $label }}">
                    </a>
                    @if($label)
                        <p style="text-align: center;">{{ $label }}</p>
                    @endif
                </div>
            @endforeach
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

        function toggleCart() {
            alert("Abrir carrinho");
        }

        document.querySelector('.search-icon').addEventListener('click', function (e) {
            const container = document.querySelector('.search-container');
            const input = document.querySelector('#searchInput');

            if (container.classList.contains('active') && input.value.trim() !== '') {
                const form = document.createElement('form');
                form.action = "{{ route('produtos.pesquisar') }}";
                form.method = 'GET';

                const inputHidden = document.createElement('input');
                inputHidden.type = 'hidden';
                inputHidden.name = 'query';
                inputHidden.value = input.value;

                form.appendChild(inputHidden);
                document.body.appendChild(form);
                form.submit();
            } else {
                container.classList.toggle('active');
                input.focus();
            }

            e.stopPropagation();
        });

        document.addEventListener('click', function (e) {
            const container = document.querySelector('.search-container');
            const input = document.querySelector('#searchInput');
            if (!container.contains(e.target)) {
                container.classList.remove('active');
                input.value = '';
            }
        });
    </script>

</body>
</html>
