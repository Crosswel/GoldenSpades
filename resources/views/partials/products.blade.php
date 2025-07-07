@if($produtos->count())
    @foreach($produtos as $product)
        <div class="product-card" style="
            border:1px solid #ddd;
            border-radius:8px;
            overflow:hidden;
            box-shadow:0 0 8px rgba(0,0,0,0.1);
            text-align:center;
            max-width: 300px;
            margin: 0 auto 20px;
        ">
            <a href="{{ route('produto', $product->id) }}">
                <img src="{{ asset($product->imagem) }}"
                     alt="{{ $product->nome }}"
                     style="width:100%; height:220px; object-fit:cover;">
            </a>
            <div style="padding:15px;">
                <h4 style="margin:0;">{{ $product->nome }}</h4>
                <p style="color:#777;">{{ number_format($product->preco, 2) }} €</p>
                <a href="{{ route('produto', $product->id) }}"
                   style="display:inline-block;margin-top:10px;background:#d4af37;color:#fff;
                          padding:8px 15px;border-radius:4px;text-decoration:none;">
                    Ver mais
                </a>
            </div>
        </div>
    @endforeach
@else
    <p style="text-align:center; margin-top:30px;">Sem resultados.</p>
@endif
