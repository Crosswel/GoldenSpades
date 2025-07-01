@if(count($products))
    @foreach($products as $product)
        <li class="list-group-item" style="display: flex; align-items: center; justify-content: space-between; gap: 20px; padding: 15px;">
            <div style="flex: 0 0 120px;">
                @if($product->imagem)
                    <img src="{{ asset($product->imagem) }}" alt="{{ $product->nome }}"
                         style="width: 120px; height: 120px; object-fit: cover; border-radius: 8px; border: 1px solid #ccc;">
                @else
                    <div style="width: 120px; height: 120px; background-color: #eee; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                        <span>Sem imagem</span>
                    </div>
                @endif
            </div>
            <div style="flex: 1;">
                <h4>{{ $product->nome }}</h4>
                <p>{{ $product->descricao }}</p>
                <p><strong>Categoria:</strong> {{ $product->categoria }}</p>
                <p><strong>Preço:</strong> {{ number_format($product->preco, 2) }} €</p>
                <p><strong>Quantidade:</strong> {{ $product->quantidade }}</p>
            </div>
            <div style="display: flex; flex-direction: column; gap: 10px;">
                <a href="{{ route('products.edit', $product->id) }}" class="btn-primary" style="text-align:center;">Editar</a>
                <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Eliminar este produto?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-logout">Eliminar</button>
                </form>
            </div>
        </li>
    @endforeach
@else
    <p>Sem produtos registados.</p>
@endif
