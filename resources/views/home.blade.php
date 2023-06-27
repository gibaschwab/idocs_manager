@extends('layout')

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title fw-semibold mb-4">Dashboard</h5>
        <div class="row">
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <h4 class="fw-semibold mb-0">Usuários Cadastrados</h4>
                        <h1 class="fw-semibold mb-0">{{ $usersCount }}</h1>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <h4 class="fw-semibold mb-0">Meus Documentos</h4>
                        <h1 class="fw-semibold mb-0">{{ $documentCount }}</h1>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <h4 class="fw-semibold mb-0">Compartilhados comigo</h4>
                        <h1 class="fw-semibold mb-0">{{ $documentShareCount }}</h1>
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
    if (currentUrl === "/") {
        // Obtém o elemento do menu do Dashboard
        var dashboardItem = document.querySelector('.sidebar-item a[href="/"]');

        // Adiciona a classe "active" ao elemento
        dashboardItem.classList.add('active');
    }
</script>
@endsection