{{-- Painel de Login --}}
<div class="login-content" id="loginContent">
    <h2>JÁ TENHO UMA CONTA</h2>

    @if ($errors->any() && session('form') !== 'register')
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

    <form method="POST" action="{{ route('login') }}">
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

{{-- Painel de Registo --}}
<div class="login-content" id="registerContent" style="display: none;">
    <h2>CRIAR UMA CONTA</h2>

    @if ($errors->any() && session('form') === 'register')
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

    <form method="POST" action="{{ route('register') }}">
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

{{-- Script para alternar login/registo --}}
<script>
    function switchToRegister() {
        document.getElementById('loginContent').style.display = 'none';
        document.getElementById('registerContent').style.display = 'block';
    }

    function switchToLogin() {
        document.getElementById('registerContent').style.display = 'none';
        document.getElementById('loginContent').style.display = 'block';
    }
</script>
