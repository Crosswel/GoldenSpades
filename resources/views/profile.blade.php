@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 600px; margin: 50px auto;">
    <h1 style="margin-bottom: 30px;">O meu perfil</h1>

    <div style="border: 1px solid #ccc; padding: 20px; border-radius: 8px;">
        <p><strong>Nome:</strong> {{ Auth::user()->name }}</p>
        <p><strong>Email:</strong> {{ Auth::user()->email }}</p>

        <form method="POST" action="{{ route('logout') }}" style="margin-top: 30px;">
            @csrf
            <button type="submit" style="
                background-color: #c0392b;
                color: white;
                border: none;
                padding: 10px 20px;
                border-radius: 5px;
                cursor: pointer;
            ">
                Terminar Sessão
            </button>
        </form>
    </div>
</div>
@endsection
