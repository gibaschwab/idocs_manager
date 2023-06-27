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
                        @if(session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                        @endif

                        <h5 class="card-title">Compartilhar Documento</h5>
                        <form action="{{ route('documents.processShare', ['id' => $document->id]) }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="users" class="form-label">Usuários</label>
                                <select id="users" name="users[]" class="form-select" multiple>
                                    @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @foreach ($users as $user)
                            @php
                            $userPermissions = $user->documentPermissions($document->id)->first();
                            $canView = $userPermissions ? $userPermissions->permissions->can_view : false;
                            $canEdit = $userPermissions ? $userPermissions->permissions->can_edit : false;
                            $canDelete = $userPermissions ? $userPermissions->permissions->can_delete : false;
                            @endphp
                            <div id="permissions_{{ $user->id }}_wrapper" class="permissions-wrapper" style="display: none;">
                                <div class="mb-3">
                                    <label class="form-label">Permissões para {{ $user->name }}</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="can_view" name="permissions[{{ $user->id }}][]" value="can_view" @if($canView) checked @endif>
                                        <label class="form-check-label" for="can_view">Visualizar</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="can_edit" name="permissions[{{ $user->id }}][]" value="can_edit" @if($canEdit) checked @endif>
                                        <label class="form-check-label" for="can_edit">Editar</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="can_delete" name="permissions[{{ $user->id }}][]" value="can_delete" @if($canDelete) checked @endif>
                                        <label class="form-check-label" for="can_delete">Excluir</label>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            <button type="submit" class="btn btn-primary">Compartilhar</button>
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
        if (currentUrl.match(/^\/documents\/\d+\/share$/)) {
            // Obtém o ID do documento da URL
            var documentId = currentUrl.match(/\d+/)[0];

            // Obtém o elemento do menu do Dashboard
            var dashboardItem = document.querySelector('.sidebar-item a[href="/documents/share"]');

            // Adiciona a classe "active" ao elemento
            if (dashboardItem) {
                dashboardItem.classList.add('active');
            }
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var usersSelect = document.getElementById('users');
            var permissionsWrappers = document.getElementsByClassName('permissions-wrapper');

            usersSelect.addEventListener('change', function() {
                for (var i = 0; i < permissionsWrappers.length; i++) {
                    permissionsWrappers[i].style.display = 'none';
                }

                var selectedUsers = Array.from(usersSelect.selectedOptions, option => option.value);
                selectedUsers.forEach(function(userId) {
                    var wrapper = document.getElementById('permissions_' + userId + '_wrapper');
                    wrapper.style.display = 'block';
                });
            });
        });
    </script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons@latest/iconfont/tabler-icons.min.css">

</body>

</html>