@extends('layouts.app')

@section('title', 'Finalizar Compra')

@section('content')
<div class="home-container" style="max-width:600px; margin:50px auto; background:white; border:1px solid #ddd; border-radius:8px; padding:30px; box-shadow:0 0 10px rgba(0,0,0,0.1);">

    <h2 style="text-align:center; margin-bottom:20px;">Finalizar Compra</h2>

    <form method="POST" action="{{ route('checkout.endereco') }}">
        @csrf

        <div style="margin-bottom:20px;">
            <label for="address" style="font-weight:bold;">Endereço de entrega</label>
            <textarea
                name="address"
                id="address"
                placeholder="Rua, nº, andar, código postal, cidade"
                required
                style="width:100%; border:1px solid #ccc; border-radius:4px; padding:10px; margin-top:5px;"
            ></textarea>
        </div>

        @if(Auth::user()->address)
        <div style="margin-bottom:20px;">
            <input type="checkbox" id="use_account_address">
            <label for="use_account_address">Usar morada da conta</label>
        </div>
        @endif

        <div style="margin-bottom:20px;">
            <input type="checkbox" name="save_address" id="save_address">
            <label for="save_address">Guardar este endereço na minha conta</label>
        </div>

        <button
            type="submit"
            style="width:100%; background:#d4af37; color:white; border:none; padding:15px; border-radius:4px; font-size:1rem; cursor:pointer;"
        >
            Continuar para Pagamento
        </button>
    </form>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const checkbox = document.getElementById("use_account_address");
    const textarea = document.getElementById("address");

    if (checkbox) {
        checkbox.addEventListener("change", () => {
            if (checkbox.checked) {
                textarea.value = "{{ Auth::user()->address }}";
                textarea.readOnly = true;
            } else {
                textarea.value = "";
                textarea.readOnly = false;
            }
        });
    }

    // garante no submit
    const form = document.querySelector("form");
    form.addEventListener("submit", (e) => {
        if (checkbox && checkbox.checked) {
            textarea.value = "{{ Auth::user()->address }}";
        }
    });
});
</script>

@endsection
