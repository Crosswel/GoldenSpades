@extends('layouts.app')

@section('title', 'Pagamento Paypal')

@section('content')
    <h2>Pagamento Paypal</h2>
    <p>Por favor envie o pagamento para <strong>admin@goldspades.com</strong></p>
    <p>Valor: confirmar no histórico do seu perfil</p>
    <a href="{{ route('profile') }}" style="background:#d4af37;color:white;padding:10px 20px;border-radius:4px;">Ir para o meu perfil</a>
@endsection
