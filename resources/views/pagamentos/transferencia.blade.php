@extends('layouts.app')

@section('title', 'Pagamento Transferência Bancária')

@section('content')
    <h2>Pagamento por Transferência Bancária</h2>
    <p>Por favor faça transferência para o IBAN <strong>PT50 0002 0123 1234 5678 9101 2</strong></p>
    <p>Valor: confirme no histórico do seu perfil.</p>
    <a href="{{ route('profile') }}" style="background:#d4af37;color:white;padding:10px 20px;border-radius:4px;">Ir para o meu perfil</a>
@endsection
