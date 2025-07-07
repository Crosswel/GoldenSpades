<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'GoldSpades')</title>
  <link rel="stylesheet" href="{{ asset('css/site.css') }}">
  <style>
    .side-menu {
      position: fixed;
      top: 0;
      left: -300px;
      width: 300px;
      height: 100%;
      background: #fff;
      box-shadow: 2px 0 5px rgba(0,0,0,0.2);
      z-index: 9999;
      overflow-y: auto;
      transition: left 0.3s ease;
    }
    .side-menu.open { left: 0; }
    .menu-overlay,
    .login-overlay {
      position: fixed; top: 0; left: 0; right: 0; bottom: 0;
      background: rgba(0,0,0,0.3);
      z-index: 9998;
      display: none;
    }
    .menu-overlay.visible,
    .login-overlay.visible { display: block; }
  </style>
</head>
<body>

  <!-- overlays -->
  <div class="menu-overlay" id="menuOverlay" onclick="closeAllPanels()"></div>
  <div id="overlay" class="login-overlay" onclick="closeAllPanels()"></div>

  <!-- side menu -->
  @include('partials.menu')

  <header>
    <div class="top-bar">Portes grátis em Encomendas acima de 75€</div>
    <div class="header-content">
      <div class="menu-button" onclick="toggleMenu()">
        <img src="{{ asset('images/Menu.png') }}" alt="Menu" style="height:24px;">
      </div>
      <a href="{{ route('home') }}">
        <img src="{{ asset('images/Logo.png') }}" alt="GoldSpades" class="logo">
      </a>
      <div class="header-icons">
        <!-- Pesquisa -->
        <div class="search-container" id="searchBox" style="position: relative;">
          <input type="text" id="searchQuery" placeholder="Procurar produto..."
            style="
              display:none;
              position: absolute;
              right: 35px;
              top: 0;
              border: 1px solid #ccc;
              border-radius: 4px;
              padding: 5px 10px;
              background: white;
              z-index: 9999;">
          <button type="button" id="toggleSearch" style="background:none; border:none;">
            <img src="{{ asset('images/Pesquisa.png') }}" alt="Pesquisar" style="height:20px;">
          </button>
        </div>

        @guest
          <button onclick="openLogin()">
            <img src="{{ asset('images/Profile.png') }}" alt="Login" style="height:24px;">
          </button>
        @else
          <a href="{{ route('profile') }}" style="background:none;border:none;">
            <img src="{{ asset('images/Profile.png') }}" alt="Perfil" style="height:24px;">
          </a>
        @endguest

        <!-- Carrinho -->
        @php
          $carrinho = session('carrinho', []);
          $totalItens = array_sum($carrinho);
        @endphp
        <button onclick="openCart()" style="position:relative;">
          <img src="{{ asset('images/Carrinho.png') }}" alt="Carrinho" style="height:24px;">
          @if($totalItens > 0)
            <span style="
              position:absolute;
              top:-5px;
              right:-5px;
              background:#d4af37;
              color:white;
              border-radius:50%;
              padding:2px 6px;
              font-size:12px;">{{ $totalItens }}</span>
          @endif
        </button>
      </div>
    </div>
  </header>

  <main class="home-container" style="padding:20px;">
    <div id="productContainer">
      @yield('content')
    </div>
  </main>

  <!-- login/register -->
  @include('partials.login-register')

  <!-- carrinho -->
  @include('partials.cart')

  <!-- perfil -->
  <div id="profilePanel" style="
    position:fixed; top:0; right:-300px; width:300px; height:100%;
    background:white; box-shadow:-2px 0 5px rgba(0,0,0,0.2);
    transition:right 0.3s ease; z-index:9999;
    overflow-y:auto; display:none;">
    <div style="
      background-color:#d4af37;
      color:white;
      padding:10px 20px;
      display:flex;
      justify-content:space-between;
      align-items:center;">
      <strong>MINHA CONTA</strong>
      <button onclick="closeProfile()" style="background:none; border:none; color:white; font-size:20px; cursor:pointer;">×</button>
    </div>
    <ul style="list-style:none; padding:20px;">
      <li><a href="{{ route('profile') }}">Editar perfil</a></li>
      <li><a href="{{ route('favoritos') }}">Favoritos</a></li>
      <li><a href="{{ route('dashboard') }}">Encomendas</a></li>
      <li>
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" style="background:none; border:none; color:#d4af37; cursor:pointer;">Sair</button>
        </form>
      </li>
    </ul>
  </div>

  <script>
    function toggleMenu(){
      document.getElementById('sideMenu').classList.toggle('open');
      document.getElementById('menuOverlay').classList.toggle('visible');
    }
    function closeMenu(){
      document.getElementById('sideMenu').classList.remove('open');
      document.getElementById('menuOverlay').classList.remove('visible');
    }
    function openLogin(){
      document.getElementById('loginPanel').classList.add('show');
      document.getElementById('overlay').classList.add('visible');
    }
    function closeLogin(){
      document.getElementById('loginPanel').classList.remove('show');
      document.getElementById('overlay').classList.remove('visible');
    }
    function openProfile(){
      const p = document.getElementById('profilePanel');
      p.style.display='block';
      setTimeout(()=>{ p.style.right="0"; }, 10);
      document.getElementById('overlay').classList.add('visible');
    }
    function closeProfile(){
      const p = document.getElementById('profilePanel');
      p.style.right="-300px";
      setTimeout(()=>{ p.style.display='none'; }, 300);
      document.getElementById('overlay').classList.remove('visible');
    }
    function openCart(){
      const p = document.getElementById('cartPanel');
      p.classList.add('show');
      document.getElementById('overlay').classList.add('visible');
    }
    function closeCart(){
      const p = document.getElementById('cartPanel');
      p.classList.remove('show');
      document.getElementById('overlay').classList.remove('visible');
    }
    function closeAllPanels(){
      closeMenu();
      closeLogin();
      closeCart();
      closeProfile();
    }
    function updateCart(id, action){
      fetch("{{ route('cart.update') }}", {
        method:'POST',
        headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}','Content-Type':'application/json'},
        body:JSON.stringify({id,action})
      }).then(()=>location.reload());
    }
    function removeCart(id){
      fetch(`/cart/remove/${id}`, {method:'GET'}).then(()=>location.reload());
    }
    document.addEventListener('DOMContentLoaded', function(){
      const toggleSearch = document.getElementById('toggleSearch');
      const searchQuery = document.getElementById('searchQuery');
      toggleSearch.addEventListener('click', function(){
        if(searchQuery.style.display==='block'){
          searchQuery.style.display='none';
          searchQuery.value='';
          location.reload();
        }else{
          searchQuery.style.display='block';
          searchQuery.focus();
        }
      });
      searchQuery.addEventListener('input', function(){
        const q = searchQuery.value;
        if(q.length >= 2){
          fetch(`/search?q=${encodeURIComponent(q)}`, {
              headers: { 'Accept': 'text/html' }
          })
          .then(resp => resp.text())
          .then(html => {
            document.getElementById('productContainer').innerHTML = html;
          });
        }
      });
      document.addEventListener('click', function(e){
        if(!document.getElementById('searchBox').contains(e.target)){
          searchQuery.style.display='none';
        }
      });
    });
  </script>
</body>
</html>
