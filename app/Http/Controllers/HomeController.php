<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;
use App\Models\User;
use App\Models\DocumentPermission;

class HomeController extends Controller
{
    public function index()
    {
        if (auth()->check()) {
            $usersCount = User::count();

            $user = auth()->user();
            $documentCount = Document::where('user_id', $user->id)->count();

            $documentShareCount = DocumentPermission::where('user_id', $user->id)
                ->where(function ($query) {
                    $query->where('can_view', 1)
                        ->orWhere('can_edit', 1)
                        ->orWhere('can_delete', 1);
                })
                ->count();

            return view('home', compact('usersCount', 'documentCount', 'documentShareCount'));
        } else {
            return redirect()->route('login');
        }
    }




    public function createDocument()
    {
        return view('create-document');
    }

    public function editDocumentbk()
    {
        $documents = Document::where('user_id', auth()->user()->id)->get();

        return view('edit-document', compact('documents'));
    }

    public function editDocument()
    {
        $userId = auth()->user()->id;

        $documents = Document::where('user_id', $userId)
            ->orWhereHas('permissions', function ($query) use ($userId) {
                $query->where('user_id', $userId)
                    ->where('can_edit', 1);
            })
            ->get();

        return view('edit-document', compact('documents'));
    }
}
