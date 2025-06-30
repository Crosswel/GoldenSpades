<!-- Painel de Login -->
    <div class="login-panel" id="loginPanel">
        <div class="login-header">
            <span>LOGIN</span>
            <span class="close-login" onclick="closeLogin()">×</span>
        </div>
        <div class="login-content">
            <h2>JÁ TENHO UMA CONTA</h2>

            @if ($errors->any())
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