@extends('layout')

@section('content')
<div class="card">
    <div class="card-body">
        @if(session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
        @endif
        <h5 class="card-title fw-semibold mb-4">Consulta de Documentos</h5>
        <div class="mb-4">
            <form action="{{ route('documents.search') }}" method="GET">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Nome do Documento</label>
                        <input type="text" class="form-control" name="search" placeholder="Pesquisar pelo nome" value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Usuário</label>
                        <select class="form-select" name="user">
                            <option value="">Todos</option>
                            @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ request('user') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label" for="start_date">Data criação - Início</label>
                        <input class="form-control" type="date" id="start_date" name="start_date" value="{{ request('start_date') }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label" for="end_date">Data criação - Fim</label>
                        <input class="form-control" type="date" id="end_date" name="end_date" value="{{ request('end_date') }}">
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary">Pesquisar</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="table-responsive">
            <table class="table text-nowrap mb-0 align-middle">
                <thead class="text-dark fs-4">
                    <tr>
                        <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">ID</h6>
                        </th>
                        <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">Nome do Documento</h6>
                        </th>
                        <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">Criado por</h6>
                        </th>
                        <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">Data de Criação</h6>
                        </th>
                        <th class="border-bottom-0"></th> <!-- Nova coluna -->
                    </tr>
                </thead>
                <tbody>
                    @foreach ($documents as $document)
                    <tr>
                        <td>{{ $document->id }}</td>
                        <td>{{ $document->filename }}</td>
                        <td>{{ $document->user->name }}</td>
                        <td>{{ $document->created_at->format('d/m/Y') }}</td>
                        <td>
                            @if ($document->canView())
                            <a href="{{ route('documents.show', $document->id) }}" class="btn btn-primary"><i class="ti ti-eye" style="font-size: 1.3rem;"></i></a>
                            @endif
                        </td>
                        <td>
                            @if ($document->canDelete())
                            <form action="{{ route('documents.destroy', $document->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este documento?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"><i class="ti ti-trash" style="font-size: 1.3rem;"></i></button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>
</div>



</div>
</div>

<script>
    // Obtém a URL atual
    var currentUrl = window.location.pathname;

    // Verifica se a URL corresponde à página do Dashboard
    if (currentUrl === "/documents/search") {
        // Obtém o elemento do menu do Dashboard
        var dashboardItem = document.querySelector('.sidebar-item a[href="/documents/search"]');

        // Adiciona a classe "active" ao elemento
        dashboardItem.classList.add('active');
    }
</script>

<script>
    function confirmDelete() {
        return confirm("Tem certeza que deseja excluir este documento?");
    }
</script>
@endsection