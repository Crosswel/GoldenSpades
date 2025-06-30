@extends('layouts.app')

@section('title', 'Pagamento Mbway')

@section('content')
    <h2>Pagamento Mbway</h2>
    <p>Envie o pagamento para <strong>927202585</strong> nos próximos 10 minutos.</p>
    <a href="{{ route('profile') }}" style="background:#d4af37;color:white;padding:10px 20px;border-radius:4px;">Ir para o meu perfil</a>
@endsection
