@extends('layout')

@section('content')
<div class="card">
    <div class="card-body">

        <h3>{{ $document->filename }}</h3>
        <hr>
        <div class="document-content">
            {!! $document->content !!}
        </div>
    </div>
</div>

<script>
    // Obtém a URL atual
    var currentUrl = window.location.pathname;

    // Verifica se a URL corresponde à página
    if (currentUrl.match(/^\/\d+$/)) {
        // Obtém o ID do documento da URL
        var documentId = currentUrl.match(/\d+/)[0];

        // Obtém o elemento do menu do Dashboard
        var dashboardItem = document.querySelector('.sidebar-item a[href="/documents/search"]');

        // Adiciona a classe "active" ao elemento
        if (dashboardItem) {
            dashboardItem.classList.add('active');
        }
    }
</script>


@endsection