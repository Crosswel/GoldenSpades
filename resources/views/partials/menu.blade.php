<div class="side-menu" id="sideMenu">
    <div class="menu-header">
        <span>MENU</span>
        <span class="close-btn" onclick="closeMenu()">×</span>
    </div>
    <ul>
        <li><a href="{{ route('categoria', ['categoria' => 'relógios']) }}">Relógios</a></li>
        <li><a href="{{ route('categoria', ['categoria' => 'pulseiras']) }}">Pulseiras</a></li>
        <li><a href="{{ route('categoria', ['categoria' => 'anéis']) }}">Anéis</a></li>
        <li><a href="{{ route('categoria', ['categoria' => 'medalhas']) }}">Medalhas</a></li>
        <li><a href="{{ route('novacolecao') }}">Nova Coleção</a></li>
        <li><a href="{{ route('faqs') }}">FAQ's</a></li>
    </ul>
    <div class="language">🌐 Português - Portugal</div>
</div>

<div class="menu-overlay" id="menuOverlay" onclick="closeMenu()"></div>

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
    transition: left 0.3s ease;
    overflow-y: auto;
}
.side-menu.open {
    left: 0;
}
.menu-header {
    background: #d4af37;
    color: white;
    padding: 15px;
    font-weight: bold;
}
.menu-header .close-btn {
    float: right;
    cursor: pointer;
}
.side-menu ul {
    list-style: none;
    padding: 0;
    margin: 0;
}
.side-menu ul li {
    border-bottom: 1px solid #eee;
}
.side-menu ul li a {
    display: block;
    padding: 12px 20px;
    color: #333;
    text-decoration: none;
}
.side-menu ul li a:hover {
    background: #f8f8f8;
}
.side-menu .language {
    padding: 15px;
    font-size: 14px;
    color: #555;
}
.menu-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.3);
    z-index: 9998;
    display: none;
}
.menu-overlay.visible {
    display: block;
}
</style>
