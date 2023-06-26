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

    public function editDocument()
    {
        $documents = Document::where('user_id', auth()->user()->id)->get();

        return view('edit-document', compact('documents'));
    }

}
