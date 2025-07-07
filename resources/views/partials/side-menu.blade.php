<div class="side-menu" id="sideMenu">
    <span class="close-btn" onclick="closeMenu()">×</span>
    <h3>MENU</h3>
    <ul>
        <li><a href="{{ route('categoria', ['categoria' => 'relógios']) }}">Relógios</a></li>
        <li><a href="{{ route('categoria', ['categoria' => 'pulseiras']) }}">Pulseiras</a></li>
        <li><a href="{{ route('categoria', ['categoria' => 'anéis']) }}">Anéis</a></li>
        <li><a href="{{ route('categoria', ['categoria' => 'medalhas']) }}">Medalhas</a></li>
        <li><a href="{{ route('novacolecao') }}">Nova coleção</a></li>
        <li><a href="{{ route('faqs') }}">FAQ</a></li>
    </ul>
    <div class="language">🌐 Português</div>
</div>
