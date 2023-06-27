<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;
use App\Models\User;
use App\Models\DocumentPermission;

class ShareDocumentController extends Controller
{
    public function index()
    {
        $userId = auth()->user()->id;
        $documents = Document::where('user_id', $userId)->get();

        return view('share.index', compact('documents'));
    }

    public function create($id)
    {
        $document = Document::findOrFail($id);
        $users = User::where('id', '!=', auth()->user()->id)->get();

        foreach ($users as $user) {
            $userPermissions = DocumentPermission::where('user_id', $user->id)
                ->where('document_id', $id)
                ->first();

            $user->can_view = $userPermissions->can_view ?? 0;
            $user->can_edit = $userPermissions->can_edit ?? 0;
            $user->can_delete = $userPermissions->can_delete ?? 0;
        }

        return view('share.share-form', compact('document', 'users'));
    }

    public function store(Request $request, $id)
    {
        $document = Document::findOrFail($id);
        $sharedUsers = $request->input('users');
        $permissions = $request->input('permissions');

        foreach ($sharedUsers as $userId) {
            $userPermissions = $permissions[$userId] ?? [];

            $document->permissions()->updateOrCreate(
                ['user_id' => $userId],
                [
                    'can_view' => in_array('can_view', $userPermissions),
                    'can_edit' => in_array('can_edit', $userPermissions),
                    'can_delete' => in_array('can_delete', $userPermissions),
                ]
            );
        }

        return redirect()->route('documents.share.index')->with('success', 'Documento compartilhado com sucesso!');
    }
}
