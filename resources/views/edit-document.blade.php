@extends('layout')

@section('content')
<div class="card">
    <div class="card-body">
        <div class="mb-3">
            <a href="{{ route('newdocument.create') }}" class="btn btn-primary">Novo documento</a>
        </div>
        <h5 class="card-title fw-semibold mb-4">Edição de Documento</h5>
        <div class="table-responsive">
            <table class="table text-nowrap mb-0 align-middle">
                <thead class="text-dark fs-4">
                    <tr>
                        <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">Nome do Documento</h6>
                        </th>
                        <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">Criado por</h6>
                        </th>
                        <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">Ação</h6>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($documents as $document)
                    <tr>
                        <td>{{ $document->filename }}</td>
                        <td>{{ $document->user->name }}</td>
                        <td>
                            @if (strtolower(pathinfo($document->file_path, PATHINFO_EXTENSION)) === 'docx')
                            <a href="{{ route('document.edit', ['id' => $document->id]) }}" class="btn btn-primary">Editar</a>
                            @else
                            <button class="btn btn-primary" disabled>Editar</button>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>
</div>

<script>
    // Obtém a URL atual
    var currentUrl = window.location.pathname;

    // Verifica se a URL corresponde à página do Dashboard
    if (currentUrl === "/edit-document") {
        // Obtém o elemento do menu do Dashboard
        var dashboardItem = document.querySelector('.sidebar-item a[href="/edit-document"]');

        // Adiciona a classe "active" ao elemento
        dashboardItem.classList.add('active');
    }
</script>
@endsection