@extends('layout')

@section('content')
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
@endsection