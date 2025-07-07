<div id="loginPanel" class="login-panel">
    <div class="login-header">
        <span>LOGIN</span>
        <span class="close-login" onclick="closeLogin()">×</span>
    </div>

    <div class="login-content" id="loginContent">
        <h2>JÁ TENHO UMA CONTA</h2>

        @if ($errors->any() && session('form') !== 'register')
            <div class="error-box">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <input type="email" name="email" placeholder="E-mail" required>
            <input type="password" name="password" placeholder="Palavra-passe" required>

            <button type="submit" class="btn-primary">Iniciar Sessão</button>
        </form>
        <div class="new-user">
            Novo cliente? <a href="#" onclick="switchToRegister()">Crie a sua conta</a>
        </div>
    </div>

    <div class="login-content" id="registerContent" style="display:none;">
        <h2>CRIAR UMA CONTA</h2>

        @if ($errors->any() && session('form') === 'register')
            <div class="error-box">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <input type="text" name="name" placeholder="Nome" required>
            <input type="email" name="email" placeholder="E-mail" required>
            <input type="password" name="password" placeholder="Palavra-passe" required>
            <input type="password" name="password_confirmation" placeholder="Confirmar palavra-passe" required>
            <button type="submit" class="btn-primary">Registar</button>
        </form>
        <div class="new-user">
            Já tem uma conta? <a href="#" onclick="switchToLogin()">Faça o login</a>
        </div>
    </div>
</div>

<style>
.login-panel {
    position: fixed;
    top: 0;
    right: -400px;
    width: 400px;
    height: 100%;
    background: white;
    box-shadow: -2px 0 5px rgba(0,0,0,0.2);
    z-index: 9999;
    transition: right 0.3s ease;
    overflow-y: auto;
}
.login-panel.show {
    right: 0;
}
.login-header {
    background: #d4af37;
    color: white;
    padding: 15px;
    font-weight: bold;
}
.close-login {
    float: right;
    cursor: pointer;
}
.login-content {
    padding: 20px;
}
.login-content input {
    width: 100%;
    margin-bottom: 10px;
    padding: 10px;
    border: 1px solid #ccc;
}
.login-content .btn-primary {
    background: #d4af37;
    color: white;
    border: none;
    padding: 10px 20px;
    width: 100%;
    cursor: pointer;
}
.login-content .forgot-link {
    display: block;
    margin-bottom: 10px;
    color: #d4af37;
}
.login-content .new-user {
    margin-top: 15px;
}
.error-box {
    background: #ffe5e5;
    border: 1px solid #ff4d4d;
    color: #b30000;
    padding: 10px;
    border-radius: 5px;
    margin-bottom: 15px;
}
</style>

<script>
    function switchToRegister() {
        document.getElementById('loginContent').style.display = 'none';
        document.getElementById('registerContent').style.display = 'block';
    }
    function switchToLogin() {
        document.getElementById('registerContent').style.display = 'none';
        document.getElementById('loginContent').style.display = 'block';
    }
    function openLogin() {
        document.getElementById('loginPanel').classList.add('show');
        document.getElementById('loginContent').style.display = 'block';
        document.getElementById('registerContent').style.display = 'none';
        document.getElementById('overlay').classList.add('visible');
    }
    function closeLogin() {
        document.getElementById('loginPanel').classList.remove('show');
        document.getElementById('overlay').classList.remove('visible');
    }
</script>
