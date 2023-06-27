@extends('layout')

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title fw-semibold mb-4">Upload de Documento</h5>
        <form action="{{ route('upload.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="file" class="form-label">Arquivo</label>
                <input type="file" class="form-control" id="file" name="file">
            </div>
            <button type="submit" class="btn btn-outline-dark m-1">Enviar</button>
        </form>
    </div>
</div>
@if(session('success'))
<div class="alert alert-success" role="alert">
    {{ session('success') }}
</div>
@endif
@if ($errors->has('file'))
<div class="alert alert-danger">
    {{ $errors->first('file') }}
</div>
@endif

<script>
    // Obtém a URL atual
    var currentUrl = window.location.pathname;

    // Verifica se a URL corresponde à página de Upload
    if (currentUrl === "/upload") {
        // Obtém o elemento do menu de Upload
        var uploadItem = document.querySelector('.sidebar-item a[href="/upload"]');

        // Adiciona a classe "active" ao elemento
        uploadItem.classList.add('active');
    }
</script>
@endsection