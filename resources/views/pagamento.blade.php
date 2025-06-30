@extends('layouts.app')

@section('title', 'Pagamento')

@section('content')
    <h2>Escolha o método de pagamento</h2>

    <div style="display:flex; gap:20px; flex-wrap:wrap;">
        <form action="{{ route('checkout.finalizar') }}" method="POST">
            @csrf
            <input type="hidden" name="metodo" value="paypal">
            <button type="submit" style="border:none; background:none;">
                <img src="{{ asset('images/paypal.png') }}" style="width:200px;">
            </button>
        </form>

        <form action="{{ route('checkout.finalizar') }}" method="POST">
            @csrf
            <input type="hidden" name="metodo" value="mbway">
            <button type="submit" style="border:none; background:none;">
                <img src="{{ asset('images/mbway.png') }}" style="width:200px;">
            </button>
        </form>

        <form action="{{ route('checkout.finalizar') }}" method="POST">
            @csrf
            <input type="hidden" name="metodo" value="transferencia">
            <button type="submit" style="border:none; background:none;">
                <img src="{{ asset('images/bank.jpg') }}" style="width:200px;">
            </button>
        </form>
    </div>
@endsection
