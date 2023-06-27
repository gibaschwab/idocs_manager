@extends('layout')

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title fw-semibold mb-4">Upload de Documento</h5>
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
                    </tr>
                </thead>
                <tbody>
                    @foreach ($documents as $document)
                    <tr>
                        <td>{{ $document->id }}</td>
                        <td>{{ $document->filename }}</td>
                        <td>{{ $document->user->name }}</td>
                        <!-- outros campos do documento -->
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
    if (currentUrl === "/") {
        // Obtém o elemento do menu do Dashboard
        var dashboardItem = document.querySelector('.sidebar-item a[href="/"]');

        // Adiciona a classe "active" ao elemento
        dashboardItem.classList.add('active');
    }
</script>
@endsection