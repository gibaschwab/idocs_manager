<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;

class HomeController extends Controller
{
    public function index()
    {
        if (auth()->check()) {
            $documents = Document::all();
            return view('home', compact('documents'));
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
