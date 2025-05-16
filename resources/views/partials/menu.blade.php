<div class="side-menu" id="sideMenu">
    <span class="close-btn" onclick="toggleMenu()">✕</span>
    <h3>MENU</h3>
    <input class="search-bar" type="text" placeholder="🔍 Pesquisar">
    <ul>
        <li><a href="{{ route('relogios') }}">Relógios</a></li>
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
