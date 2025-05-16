<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Detalhe do Produto - GoldSpades</title>
    <link rel="stylesheet" href="{{ asset('css/site.css') }}">
</head>
<body>

    <div class="top-bar">
        Portes grátis em Encomendas acima de 75€
    </div>

    <div class="header">
        <div class="menu-icon" onclick="toggleMenu()">☰</div>
        <div class="logo">
            <a href="/">
                <img src="{{ asset('images/Logo.PNG') }}" alt="GoldSpades Logo" style="height: 80px;">
            </a>
        </div>
        <div class="icons">
            <div class="search-container">
                <input type="text" name="query" id="searchInput" class="search-input" placeholder="Procurar produto...">
                <button class="search-icon">🔍</button>
            </div>
            <span onclick="toggleLogin()">👤</span>
            <span onclick="window.location.href='/favoritos'">❤️</span>
            <span onclick="toggleCart()">🛒</span>
        </div>
    </div>

    <!-- Menu lateral -->
    <div class="side-menu" id="sideMenu">
        <span class="close-btn" onclick="toggleMenu()">✕</span>
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
    <div class="menu-overlay" id="menuOverlay" onclick="closeMenu()"></div>

    <!-- Produto -->
    <div class="product-page" style="padding: 40px; display: flex; gap: 40px;">
        <div class="product-image" style="flex: 1;">
            <img src="{{ asset('images/produto1.jpg') }}" alt="Produto" style="width:100%; border-radius:8px;">
        </div>
        <div class="product-info" style="flex: 1;">
            <h1 style="color: #7b5a16;">Nome do Produto</h1>
            <p style="margin-top: 20px;">Descrição breve e detalhada do produto, características, materiais usados, etc. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec feugiat libero id purus lacinia, ut gravida augue varius.</p>

            <div style="margin-top: 20px;">
                <label for="quantity">Quantidade:</label>
                <input type="number" id="quantity" name="quantity" min="1" value="1" style="padding: 8px; width: 80px; margin-left: 10px;">
            </div>

            <button style="margin-top: 30px; padding: 12px 20px; background-color: #dbb24a; color: white; border: none; border-radius: 6px; font-size: 16px; cursor: pointer;">
                Adicionar ao Carrinho
            </button>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        function toggleMenu() {
            const menu = document.getElementById('sideMenu');
            const overlay = document.getElementById('menuOverlay');
            menu.classList.toggle('open');
            overlay.classList.toggle('visible');
        }

        function closeMenu() {
            document.getElementById('sideMenu').classList.remove('open');
            document.getElementById('menuOverlay').classList.remove('visible');
        }

        function toggleLogin() {
            alert("Abrir painel de login");
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
