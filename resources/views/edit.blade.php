@extends('layouts.profile')

@section('content')
<style>
    .profile-page {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding-top: 60px;
    }

    .gold-border-box {
        border: 2px solid gold;
        border-radius: 10px;
        padding: 30px;
        background: #fff;
        width: 100%;
        max-width: 800px;
        margin-bottom: 30px;
    }

    .btn-primary {
        background-color: #d4af37;
        border-color: #d4af37;
        color: white;
        cursor: pointer;
    }
    .btn-primary:hover {
        background-color: #bfa134;
        border-color: #bfa134;
    }

    .list-group-item {
        border: 1px solid #ddd;
        margin-bottom: 10px;
        border-radius: 5px;
        padding: 10px;
        background: #fafafa;
    }
</style>

<div class="profile-page">

    <!-- LOGO -->
    <a href="/">
        <img src="{{ asset('images/logo.png') }}" style="height:50px; margin-bottom:30px;">
    </a>

    <div style="display:flex; justify-content:center; gap:10px; margin-bottom:20px;">
        <a href="{{ route('profile.edit') }}" class="btn btn-primary">Editar Perfil</a>
        <a href="#" onclick="document.getElementById('history-section').scrollIntoView({behavior: 'smooth'})" class="btn btn-primary">Histórico</a>
        <a href="#product-section" class="btn btn-primary">Produto</a>
        @if($user->usertype == 0)
            <a href="{{ route('admin.orders.index') }}" class="btn btn-primary">Pedidos</a>
        @endif
    </div>


    <!-- FORM EDIT -->
    <div class="gold-border-box">
        <h3>Editar Perfil</h3>
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
            </div>
            <div class="mb-3">
                <label>Morada</label>
                <input type="text" name="address" class="form-control" value="{{ old('address', $user->address) }}">
            </div>
            <div class="mb-3">
                <label>Telefone</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
            </div>
            <button class="btn btn-primary">Guardar Alterações</button>
        </form>
    </div>

    <!-- HISTÓRICO ADMIN -->
@if($user->usertype == 0)
<div id="history-section" class="gold-border-box">
    <h4>Histórico de Compras (Admin)</h4>
    @if($orders && count($orders))
        <ul class="list-group">
            @foreach($orders as $order)
                <li class="list-group-item" style="margin-bottom:10px;">
                    <strong>Compra #{{ $order->id }}</strong><br>
                    Data: {{ $order->created_at->format('d/m/Y H:i') }}<br>
                    <strong>Estado:</strong> {{ $order->estado }} 
                    @if($order->estado !== 'Enviado')
                        <form action="{{ route('admin.orders.update', $order->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('PATCH')
                            <button class="btn btn-sm btn-primary" style="margin-left:5px;">Marcar como Enviado</button>
                        </form>
                    @endif
                    <br>
                    <strong>Método:</strong> {{ ucfirst($order->metodo) }}<br>
                    <strong>Endereço:</strong> {{ $order->endereco }}<br>

                    <div style="margin-top:10px;">
                        <strong>Itens:</strong>
                        @foreach($order->items as $item)
                            <div style="display:flex;align-items:center;margin-top:5px;">
                                <img src="{{ asset($item->produto->imagem) }}" style="width:40px;height:40px;object-fit:cover;margin-right:10px;">
                                {{ $item->produto->nome }} x {{ $item->quantidade }} — 
                                {{ number_format($item->preco, 2) }} €
                            </div>
                        @endforeach
                    </div>
                    <div style="margin-top:5px; font-weight:bold;">
                        Total:
                        {{
                            number_format(
                                $order->items->sum(fn($i) => $i->preco * $i->quantidade) +
                                ($order->items->sum(fn($i) => $i->preco * $i->quantidade) < 75 ? 7.5 : 0),
                                2
                            )
                        }} €
                    </div>
                </li>
            @endforeach
        </ul>
    @else
        <p>Sem compras registadas.</p>
    @endif
</div>
@endif

    <!-- HISTÓRICO UTILIZADOR NORMAL -->
    @if($user->usertype != 0)
    <div class="gold-border-box">
        <h4>🛒 O meu Histórico de Compras</h4>
        @if($orders->count())
            <ul class="list-group">
                @foreach($orders as $order)
                <li class="list-group-item">
                    <strong>Pedido #{{ $order->id }}</strong> <br>
                    <span>Método: {{ ucfirst($order->metodo) }}</span><br>
                    <span>Estado: {{ $order->estado }}</span><br>
                    <span>Endereço: {{ $order->endereco }}</span><br>
                    <div style="margin-top:10px;">
                        <strong>Itens:</strong>
                        @foreach($order->items as $item)
                            <div style="display:flex;align-items:center;margin-top:5px;">
                                <img src="{{ asset($item->produto->imagem) }}" style="width:40px; height:40px; object-fit:cover; margin-right:10px;">
                                {{ $item->produto->nome }} x {{ $item->quantidade }} — 
                                {{ number_format($item->preco, 2) }} €
                            </div>
                        @endforeach
                        <div style="margin-top:5px;font-weight:bold;">
                            Total: 
                            {{ number_format($order->items->sum(fn($i) => $i->preco * $i->quantidade), 2) }} €
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
        @else
            <p>Sem compras registadas.</p>
        @endif
    </div>
    @endif

    @if($user->usertype == 0)
    <div class="gold-border-box" id="product-section">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
            <h4>Gestão de Produtos</h4>
            <button onclick="toggleNewProductForm()" class="btn-primary">+ Novo Produto</button>
            @if(isset($categories) && count($categories))
    <form method="GET" action="{{ route('profile') }}" style="margin-top:15px; display:flex; align-items:center; gap:10px;">
        <label style="margin:0;">
            <img src="{{ asset('images/Filtro.PNG') }}" alt="Filtro" style="width:30px; height:30px; vertical-align:middle;">
        </label>
        <select name="categories[]" multiple class="form-control" style="max-width:200px;">
            @foreach($categories as $categoria)
                <option value="{{ $categoria }}">{{ $categoria }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn btn-primary">Filtrar</button>
    </form>
@endif

        </div>

        <!-- FORM NOVO PRODUTO -->
        <div id="new-product-form" style="display:none; margin-top:15px;">
            <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
                @csrf
                <label class="form-label">Nome</label>
                <input type="text" name="nome" class="form-control" required>
                <label class="form-label">Imagem</label>
                <input type="file" name="imagem" class="form-control" required>
                <label class="form-label">Categoria</label>
                <input type="text" name="categoria" class="form-control" required>
                <label class="form-label">Descrição</label>
                <textarea name="descricao" class="form-control" required></textarea>
                <label class="form-label">Preço (€)</label>
                <input type="number" step="0.01" name="preco" class="form-control" required>
                <label class="form-label">Quantidade</label>
                <input type="number" name="quantidade" class="form-control" required>
                <button class="btn-primary" style="margin-top:10px;">Adicionar Produto</button>
            </form>
        </div>



        

                    <!-- BOTÃO DE FILTRO COM IMAGEM -->
            <div style="margin-bottom:15px;">
                <button onclick="toggleFilter()" style="background:none; border:none; cursor:pointer;">
                    <img src="{{ asset('images/Filtro.PNG') }}" alt="Filtrar" style="width:30px;">
                </button>
            </div>

            <!-- SELECT MULTIPLE PARA FILTRO -->
            <div id="filter-box" style="display:none; margin-bottom:15px;">
                <form method="GET" action="{{ route('products.index') }}">
                    <label for="categories">Filtrar por Categoria:</label>
                    <select name="categories[]" id="categories" multiple class="form-control" style="margin-top:5px;">
                        @foreach($categories as $categoria)
                            <option value="{{ $categoria }}">{{ $categoria }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-primary" style="margin-top:10px;">Filtrar</button>
                </form>
            </div>








        <!-- LISTA DE PRODUTOS -->
        @if($products && count($products))
            <ul class="list-group mt-4">
                @foreach($products as $product)
                    <li class="list-group-item" style="display:flex; align-items:center; gap:20px;">
                        <div style="flex:0 0 80px;">
                            <img src="{{ asset($product->imagem) }}" style="width:80px; height:80px; object-fit:cover; border-radius:5px;">
                        </div>
                        <div style="flex:1;">
                            <strong>{{ $product->nome }}</strong><br>
                            Categoria: {{ $product->categoria }}<br>
                            Preço: {{ number_format($product->preco,2) }} €<br>
                            Quantidade: {{ $product->quantidade }}
                        </div>
                        <div style="display:flex; flex-direction:column; gap:5px;">
                            <a href="{{ route('products.edit', $product->id) }}" class="btn-primary" style="text-align:center;">Editar</a>
                            <form method="POST" action="{{ route('products.destroy', $product->id) }}" onsubmit="return confirm('Tem a certeza que quer eliminar este produto?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Eliminar</button>
                            </form>
                        </div>
                    </li>
                @endforeach
            </ul>
        @else
            <p>Sem produtos registados.</p>
        @endif
    </div>

    <script>
        function toggleNewProductForm() {
            const form = document.getElementById('new-product-form');
            form.style.display = form.style.display === 'none' ? 'block' : 'none';
        }

            function toggleFilter() {
        const box = document.getElementById('filter-box');
        box.style.display = box.style.display === 'none' ? 'block' : 'none';
    }
    </script>
@endif

    @if($user->usertype == 0)
        <div style="margin-top:20px; text-align:center;">
            <a href="{{ route('admin.orders.index') }}" class="btn btn-primary">
                Ver Todos os Pedidos (Admin)
            </a>
        </div>
    @endif



</div>
@endsection
