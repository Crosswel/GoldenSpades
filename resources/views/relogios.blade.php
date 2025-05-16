<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Relógios - GoldSpades</title>
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
    @include('partials.menu') <!-- Se quiseres podes incluir o menu lateral aqui também -->

    <div class="gallery">
        <h2 style="width: 100%; padding: 0 40px; color: #7b5a16;">Relógios</h2>

        @foreach($produtos as $produto)
            <div>
                <a href="{{ route('produto') }}">
                    <img src="{{ asset('storage/' . $produto->imagem) }}" alt="{{ $produto->nome }}">
                </a>
                <p style="text-align: center;">{{ $produto->nome }}</p>
            </div>
        @endforeach
    </div>

    <!-- Scripts iguais aos anteriores -->
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
