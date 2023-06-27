<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>iDocs</title>
    <link rel="stylesheet" href="{{ asset('css/styles.min.css') }}">
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
                            <a class="sidebar-link" href="/documents/share" aria-expanded="false">
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
                        <h5 class="card-title fw-semibold mb-4">Compartilhamento de Documentos</h5>
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
                                            <a href="{{ route('documents.share', ['id' => $document->id]) }}" class="btn btn-primary">Compartilhar</a>
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
        if (currentUrl === "/documents/share") {
            // Obtém o elemento do menu do Dashboard
            var dashboardItem = document.querySelector('.sidebar-item a[href="/documents/share"]');

            // Adiciona a classe "active" ao elemento
            dashboardItem.classList.add('active');
        }
    </script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons@latest/iconfont/tabler-icons.min.css">

</body>

</html>