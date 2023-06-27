@extends('layout')

@section('content')
<div class="card">
    <div class="card-body">
        @if(session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
        @endif

        <form action="{{ route('newdocument.store') }}" method="POST">

            @csrf

            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Título do Documento</label>
                <input type="text" class="form-control" name="filename" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{ old('filename') }}">
            </div>

            <div class="form-group">
                <label for="docx-content">Conteúdo do Documento</label>
                <textarea id="docx-content" name="content" class="form-control" rows="8">{{ old('content') }}</textarea>
            </div>

            <div class="form-group mt-3">
                <button type="submit" class="btn btn-primary">Criar Documento</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Obtém a URL atual
    var currentUrl = window.location.pathname;

    // Verifica se a URL corresponde à página
    if (currentUrl === "/documents/create") {
        // Obtém o elemento do menu
        var dashboardItem = document.querySelector('.sidebar-item a[href="/edit-document"]');

        // Adiciona a classe "active" ao elemento
        dashboardItem.classList.add('active');
    }
</script>


<script>
    tinymce.init({
        selector: 'textarea',
        plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount checklist mediaembed casechange export formatpainter pageembed linkchecker a11ychecker tinymcespellchecker permanentpen powerpaste advtable advcode editimage tinycomments tableofcontents footnotes mergetags autocorrect typography inlinecss',
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
        tinycomments_mode: 'embedded',
        tinycomments_author: 'Author name',
        mergetags_list: [{
                value: 'First.Name',
                title: 'First Name'
            },
            {
                value: 'Email',
                title: 'Email'
            }
        ]
    });
</script>

<!-- Include the Quill library -->
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

@endsection