<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>iDocs</title>
    <link rel="stylesheet" href="{{ asset('css/styles.min.css') }}">

    <script src="https://cdn.tiny.cloud/1/v6hb3iqv4rdjxqj5v3mfsgx7ip8ckrj6ei5e3oci9ijcymtb/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
</head>

<body>
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
        <aside class="left-sidebar">
            <div>
                <div class="brand-logo d-flex align-items-center justify-content-between">
                    <a class="text-nowrap logo-img">
                        <h2>iDocs</h2>
                    </a>
                </div>
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
                    <ul id="sidebarnav">
                        <li class="nav-small-cap">
                            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                            <span class="hide-menu">Home</span>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="/" aria-expanded="false">
                                <span>
                                    <i class="ti ti-layout-dashboard"></i>
                                </span>
                                <span class="hide-menu">Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-small-cap">
                            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                            <span class="hide-menu">DOCUMENTOS</span>
                        </li>
                        <li class="sidebar-item">
                            <!-- <a class="sidebar-link" href="{{ route('upload.create') }}" aria-expanded="false"> -->
                            <a class="sidebar-link" href="/upload" aria-expanded="false">
                                <span>
                                    <i class="ti ti-upload"></i>
                                </span>
                                <span class="hide-menu">Upload</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="/edit-document" aria-expanded="false">
                                <span>
                                    <i class="ti ti-edit"></i>
                                </span>
                                <span class="hide-menu">Redação</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="/3" aria-expanded="false">
                                <span>
                                    <i class="ti ti-share"></i>
                                </span>
                                <span class="hide-menu">Compartilhamento</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="/4" aria-expanded="false">
                                <span>
                                    <i class="ti ti-search"></i>
                                </span>
                                <span class="hide-menu">Busca</span>
                            </a>
                        </li>
                </nav>
            </div>
        </aside>
        <div class="body-wrapper">
            <header class="app-header">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
                        <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
                            <h5>Olá, {{ auth()->user()->name }}!</h5>
                        </ul>
                    </div>
                </nav>
            </header>
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        @if(session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                        @endif

                        <form action="{{ $document->id ? route('documents.update', $document->id) : route('documents.store') }}" method="POST">

                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Título do Documento</label>
                                <input type="text" class="form-control" name="filename" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{ $document->filename }}">
                            </div>

                            <div class="form-group">
                                <label for="docx-content">Conteúdo do Documento</label>
                                <textarea id="docx-content" name="content" class="form-control" rows="8">{{ $document->content }}</textarea>
                            </div>

                            <div class="form-group mt-3">
                                <button type="submit" class="btn btn-primary">Salvar Documento</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        // Obtém a URL atual
        var currentUrl = window.location.pathname;

        // Verifica se a URL corresponde à página de edição de documentos
        if (currentUrl.match(/^\/documents\/\d+\/edit$/)) {
            // Obtém o ID do documento da URL
            var documentId = currentUrl.match(/\d+/)[0];

            // Obtém o elemento do menu do Dashboard
            var dashboardItem = document.querySelector('.sidebar-item a[href="/edit-document"]');

            // Adiciona a classe "active" ao elemento
            if (dashboardItem) {
                dashboardItem.classList.add('active');
            }
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



    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons@latest/iconfont/tabler-icons.min.css">
    <!-- Include the Quill library -->
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

</body>

</html>