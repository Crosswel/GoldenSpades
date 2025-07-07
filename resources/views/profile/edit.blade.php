@extends('layouts.profile')

@section('title', 'Perfil')

@section('content')
<style>
    html, body {
        height: 100%;
        margin: 0;
        padding: 0;
        background-color: #f7f8fc;
    }

    body {
    font-family: 'Figtree', sans-serif;
    background-color: #f7f8fc;
    margin: 0;
    padding: 0;
    }


    .profile-page {
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 100%;
        max-width: 900px;
        margin: 0 auto;
        padding: 20px;
    }

    .logo-centered {
        display: block;
        margin-bottom: 40px;
        height: 100px;
    }

    .tab-buttons {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
        flex-wrap: wrap;
        justify-content: flex-start;
    }

    .tab-button {
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        background-color: #d4af37;
        color: white;
        font-weight: bold;
        cursor: pointer;
    }

    .tab-button.active {
        background-color: #bfa134;
    }

    .gold-border-box {
        border: 2px solid gold;
        border-radius: 10px;
        padding: 30px;
        width: 100%;
        background-color: #fff;
        margin-bottom: 30px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
        position: relative;
    }

    .btn-primary {
        background-color: #d4af37;
        border: none;
        color: white;
        padding: 10px 20px;
        font-weight: bold;
        cursor: pointer;
        border-radius: 4px;
    }

    .btn-logout {
        background-color: #dc3545;
        color: white;
        border: none;
        padding: 10px 20px;
        font-weight: bold;
        border-radius: 4px;
        cursor: pointer;
    }

    .form-label {
        font-weight: bold;
        display: block;
        margin-bottom: 5px;
    }

    .form-control {
        width: 100%;
        padding: 8px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .list-group {
        list-style: none;
        padding: 0;
        margin-top: 15px;
    }

    .list-group-item {
        padding: 10px;
        border: 1px solid #ddd;
        margin-bottom: 5px;
        border-radius: 4px;
        background-color: #f9f9f9;
    }

    .top-right-button {
        position: absolute;
        top: 30px;
        right: 30px;
    }

    #new-product-form {
    overflow: hidden;
    transition: max-height 0.5s ease;
    max-height: 0;
    }
    #new-product-form.show {
    max-height: 1200px;
    overflow: auto;
    }


</style>

<script>
    function toggleTab(tab) {
    document.getElementById('profile-section').style.display = tab === 'profile' ? 'block' : 'none';

    @if($user->usertype == 0)
        document.getElementById('admin-history-section').style.display = tab === 'history' ? 'block' : 'none';
        document.getElementById('product-section').style.display = tab === 'products' ? 'block' : 'none';
    @else
        document.getElementById('history-section').style.display = tab === 'history' ? 'block' : 'none';
    @endif

    document.getElementById('btn-profile').classList.toggle('active', tab === 'profile');
    document.getElementById('btn-history').classList.toggle('active', tab === 'history');
    @if($user->usertype == 0)
        document.getElementById('btn-products').classList.toggle('active', tab === 'products');
    @endif
    }

        function toggleNewProductForm() {
            const form = document.getElementById('new-product-form');
            form.classList.toggle('show');

            if (form.classList.contains('show')) {
                form.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        }



    document.addEventListener('DOMContentLoaded', () => toggleTab('profile'));
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('new-product-form');
    const productList = document.getElementById('product-list');

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(form);

        fetch('{{ route('products.store') }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            // fecha o formulário suavemente
            form.parentElement.classList.remove('show');

            // mostra alerta
            alert('Produto adicionado com sucesso!');

            // adiciona o produto dinamicamente
            const newItem = `
                <li class="list-group-item" style="display:flex;align-items:center;justify-content:space-between;gap:20px;padding:15px;">
                    <div style="flex:0 0 120px;">
                        <img src="/storage/${data.imagem}" alt="${data.nome}" style="width:120px;height:120px;object-fit:cover;border-radius:8px;border:1px solid #ccc;">
                    </div>
                    <div style="flex:1;">
                        <h4 style="margin:0 0 8px 0;">${data.nome}</h4>
                        <p style="margin:0 0 5px 0;">${data.descricao}</p>
                        <p style="margin:0 0 5px 0;"><strong>Categoria:</strong> ${data.categoria}</p>
                        <p style="margin:0 0 5px 0;"><strong>Preço:</strong> ${Number(data.preco).toFixed(2)} €</p>
                        <p style="margin:0;"><strong>Quantidade:</strong> ${data.quantidade}</p>
                    </div>
                    <div style="display:flex;flex-direction:column;gap:10px;justify-content:center;">
                        <a href="/admin/products/${data.id}/edit" class="btn-primary" style="width:100px;text-align:center;">Editar</a>
                        <form action="/admin/products/${data.id}" method="POST" onsubmit="return confirm('Eliminar este produto?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-logout" style="width:100px;">Eliminar</button>
                        </form>
                    </div>
                </li>
            `;
            productList.insertAdjacentHTML('beforeend', newItem);

            // limpa o form
            form.reset();

            // força a ficar no tab de produtos
            toggleTab('products');
        })
        .catch(error => {
            console.error(error);
            alert('Erro ao adicionar produto');
        });
    });
});


</script>



<div class="profile-page">
    <a href="/">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo-centered">
    </a>

    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; margin-bottom: 20px;">
        <div style="display: flex; gap: 10px;">
            <button id="btn-profile" class="tab-button" onclick="toggleTab('profile')">Editar Perfil</button>
            <button id="btn-history" class="tab-button" onclick="toggleTab('history')">Histórico</button>
            @if($user->usertype == 0)
                <button id="btn-products" class="tab-button" onclick="toggleTab('products')">Produto</button>
            @endif
        </div>
        <div style="margin-left: auto; margin-right: 0; padding-left: 30px;">
            <a href="{{ route('home') }}" class="tab-button" style="text-decoration: none;">
                Voltar ao menu principal
            </a>
        </div>
    </div>



    <!-- Editar Perfil -->
    <div id="profile-section" class="gold-border-box">
        <h3 class="mb-4">Editar Perfil</h3>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}">
            @csrf

            <label for="email" class="form-label">Email</label>
            <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>

            <label for="address" class="form-label">Morada</label>
            <input type="text" id="address" name="address" class="form-control" value="{{ old('address', $user->address) }}">

            <label for="phone" class="form-label">Telefone</label>
            <input type="text" id="phone" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">

            <button type="submit" class="btn-primary">Guardar Alterações</button>
        </form>

        <form method="POST" action="{{ route('logout') }}" style="margin-top: 15px;">
            @csrf
            <button type="submit" class="btn-logout">Terminar Sessão</button>
        </form>
    </div>

    <!-- Histórico -->
@if($user->usertype != 0)
    <div id="history-section" class="gold-border-box" style="display: none;">
        <h4>Histórico de Compras</h4>
        @if($orders && $orders->count())
            <ul class="list-group">
                @foreach($orders as $order)
                    @php
                        $subtotal = $order->items->sum(fn($i) => $i->preco * $i->quantidade);
                        $shipping = $subtotal < 75 ? 7.50 : 0;
                        $total = $subtotal + $shipping;
                    @endphp
                    <li class="list-group-item">
                        <strong>Compra #{{ $order->id }}</strong><br>
                        <span><strong>Data:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</span><br>
                        <span><strong>Estado:</strong> {{ ucfirst($order->estado) }}</span><br>
                        <span><strong>Método:</strong> {{ ucfirst($order->metodo) }}</span><br>
                        <span><strong>Endereço:</strong> {{ $order->endereco }}</span><br>
                        <div style="margin-top:10px;">
                            <strong>Itens:</strong>
                            @foreach($order->items as $item)
                                <div style="display:flex;align-items:center;margin-top:5px;">
                                    <img src="{{ asset($item->produto->imagem) }}" style="width:50px;height:50px;object-fit:cover;margin-right:10px;">
                                    {{ $item->produto->nome }} ({{ $item->quantidade }}) —
                                    {{ number_format($item->preco * $item->quantidade, 2) }} €
                                </div>
                            @endforeach
                        </div>
                        <div style="margin-top:5px;">
                            @if($shipping > 0)
                                <em>Portes de envio: {{ number_format($shipping, 2) }} € (aplicados por compra inferior a 75 €)</em><br>
                            @endif
                            <strong>Total: {{ number_format($total, 2) }} €</strong>
                        </div>
                    </li>
                @endforeach
            </ul>
        @else
            <p>Sem compras registadas.</p>
        @endif
    </div>
@endif

<!-- Histórico (apenas para admin) -->
@if($user->usertype == 0)
<div id="admin-history-section" class="gold-border-box" style="display: none;">
    <h4>Histórico de Compras (Admin)</h4>
    @if($orders && $orders->count())
        <ul class="list-group">
            @foreach($orders as $order)
                @php
                    $subtotal = $order->items->sum(fn($i) => $i->preco * $i->quantidade);
                    $shipping = $subtotal < 75 ? 7.50 : 0;
                    $total = $subtotal + $shipping;
                @endphp
                <li class="list-group-item">
                    <strong>Compra #{{ $order->id }}</strong><br>
                    <strong>Data:</strong> {{ $order->created_at->format('d/m/Y H:i') }}<br>
                    <strong>Estado:</strong> {{ ucfirst($order->estado) }} 
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
                                    <img src="{{ asset($item->produto->imagem) }}" style="width:50px;height:50px;object-fit:cover;margin-right:10px;">
                                    {{ $item->produto->nome }} ({{ $item->quantidade }}) —
                                    {{ number_format($item->preco * $item->quantidade, 2) }} €
                                </div>
                            @endforeach
                        </div>
                        <div style="margin-top:5px;">
                            @if($shipping > 0)
                                <em>Portes de envio: {{ number_format($shipping, 2) }} € (aplicados por compra inferior a 75 €)</em><br>
                            @endif
                            <strong>Total: {{ number_format($total, 2) }} €</strong>
                        </div>
                </li>
            @endforeach
        </ul>
    @else
        <p>Sem compras registadas.</p>
    @endif
</div>
@endif

<!-- Produtos (Admin Only) -->
@if($user->usertype == 0)
<div id="product-section" class="gold-border-box" style="display: none;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
        <h4>Gestão de Produtos</h4>
        <button onclick="toggleNewProductForm()" class="btn-primary">+ Novo Produto</button>
    </div>

@if(isset($categories) && count($categories))
<div style="margin-bottom:15px; display:flex; align-items:center; gap:10px;">
    <img src="{{ asset('images/Filtro.PNG') }}" alt="Filtro"
         style="width:30px; height:30px; cursor:pointer;"
         onclick="toggleCategoryFilter()">
    <select id="categoryFilter"
            multiple
            class="form-control"
            style="max-width:200px; display:none;">
        @foreach($categories as $cat)
            <option value="{{ $cat }}">{{ $cat }}</option>
        @endforeach
    </select>
</div>
@endif

<script>
    function toggleCategoryFilter() {
        const select = document.getElementById('categoryFilter');
        select.style.display = select.style.display === 'none' ? 'block' : 'none';
    }

    document.addEventListener('DOMContentLoaded', function() {
        const select = document.getElementById('categoryFilter');
        if (select) {
            select.addEventListener('change', function() {
                const selected = Array.from(select.selectedOptions).map(opt => opt.value);

                fetch("{{ route('profile') }}?categories=" + selected.join(','), {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.text())
                .then(html => {
                    document.getElementById('product-list').innerHTML = html;
                })
                .catch(error => {
                    console.error(error);
                    alert("Erro ao filtrar produtos");
                });
            });
        }
    });
</script>


    <!-- FORM DE NOVO PRODUTO -->
    <div style="margin-top: 20px;">
        <form  id="new-product-form" action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <label class="form-label">Nome</label>
            <input type="text" name="nome" class="form-control" required>

            <label class="form-label">Imagem</label>
            <input type="file" name="imagem" class="form-control" required>

            <label class="form-label">Categoria</label>
            <select name="categoria" class="form-control" required>
                <option value="">-- Selecione a categoria --</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat }}">{{ ucfirst($cat) }}</option>
                @endforeach
            </select>

            <label class="form-label">Descrição</label>
            <textarea name="descricao" class="form-control" required></textarea>

            <label class="form-label">Preço (€)</label>
            <input type="number" step="0.01" name="preco" class="form-control" required>

            <label class="form-label">Quantidade</label>
            <input type="number" name="quantidade" class="form-control" min="0" required>

            <button type="submit" class="btn-primary" style="margin-top: 10px;">Inserir</button>
        </form>
    </div>

    <!-- LISTA DE PRODUTOS -->
    @if(isset($products) && count($products))
        <ul id="product-list" class="list-group mt-4">
            @foreach($products as $product)
                <li class="list-group-item" style="display: flex; align-items: center; justify-content: space-between; gap: 20px; padding: 15px;">
                    <div style="flex: 0 0 120px;">
                        @if($product->imagem)
                            <img src="{{ asset($product->imagem) }}"
                                alt="{{ $product->nome }}"
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
                        <button
                            class="btn-primary"
                            style="text-align:center;"
                            onclick="openEditModal({{ $product->id }}, '{{ addslashes($product->nome) }}', '{{ addslashes($product->descricao) }}', {{ $product->preco }}, {{ $product->quantidade }})"
                        >
                            Editar
                        </button>
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Tem a certeza que quer eliminar este produto?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-logout">Eliminar</button>
                        </form>
                    </div>
                </li>
            @endforeach
        </ul>

    @else
        <p>Sem produtos registados.</p>
    @endif


    <script>
    function applyFilter() {
        const selected = Array.from(document.getElementById('categoryFilter').selectedOptions).map(opt => opt.value);

        fetch("{{ route('profile') }}", {
            method: "GET",
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            params: { categories: selected },
        })
        .then(response => response.text())
        .then(html => {
            document.getElementById('product-list').innerHTML = html;
        })
        .catch(error => {
            console.error(error);
            alert("Erro ao filtrar produtos");
        });
    }
</script>

</div>

    <!-- MODAL -->
    <div id="editModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); justify-content:center; align-items:center;">
        <div style="background:white; padding:20px; border-radius:8px; width:400px;">
            <h4>Editar Produto</h4>
            <form id="editProductForm" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" id="edit_id">
            <label>Nome</label>
            <input type="text" id="edit_nome" name="nome" class="form-control" required>
            <label>Descrição</label>
            <textarea id="edit_descricao" name="descricao" class="form-control" required></textarea>
            <label>Preço (€)</label>
            <input type="number" step="0.01" id="edit_preco" name="preco" class="form-control" required>
            <label>Quantidade</label>
            <input type="number" id="edit_quantidade" name="quantidade" class="form-control" required>
            <div style="margin-top:10px;">
                <button type="submit" class="btn-primary">Guardar</button>
                <button type="button" class="btn-logout" onclick="closeEditModal()">Cancelar</button>
            </div>
            </form>
        </div>
    </div>

    <script>
        function openEditModal(id, nome, descricao, preco, quantidade) {
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_nome').value = nome;
            document.getElementById('edit_descricao').value = descricao;
            document.getElementById('edit_preco').value = preco;
            document.getElementById('edit_quantidade').value = quantidade;
            document.getElementById('editModal').style.display = 'flex';

            document.getElementById('editProductForm').action = `/admin/products/${id}`;
        }

        function closeEditModal() {
            document.getElementById('editModal').style.display = 'none';
        }
    </script>

@endif
</div>
@endsection
