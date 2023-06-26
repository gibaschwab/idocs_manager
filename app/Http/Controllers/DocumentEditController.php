<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Shared\ZipArchive;
use PhpOffice\PhpWord\Settings;
use Illuminate\Support\Facades\File;
use App\Models\Document;

class DocumentEditController extends Controller
{

    public function edit($document_id)
    {
        // Recupere o documento do banco de dados pelo ID
        $document = Document::findOrFail($document_id);

        // Passe o documento para a visualização
        return view('write-text', compact('document'));
    }

}
