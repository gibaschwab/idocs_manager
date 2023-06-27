<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Settings;

class NewDocumentController extends Controller
{
    public function create()
    {
        // Lógica para exibir o formulário de criação de documentos
        return view('newdocument.create');
    }

    public function store(Request $request)
    {
        // Lógica para salvar o novo documento
        $document = new Document();
        $document->filename = $request->input('filename');
        $document->content = $request->input('content');
        $document->user_id = auth()->user()->id; // Associar o usuário logado ao documento

        // Converter o conteúdo para DOCX
        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $section = $phpWord->addSection();
        $section->addHtml($document->content);

        $tempFilePath = storage_path('app/public/temp/') . $document->filename . '.docx';
        $tempFilePath = str_replace(' ', '_', $tempFilePath);

        // Salvar o documento DOCX temporário
        $phpWord->save($tempFilePath, 'Word2007');

        // Mover o arquivo temporário para o local desejado
        $destinationPath = storage_path('app/public/uploads/');
        $destinationFilePath = $destinationPath . $document->filename . '.docx';
        $destinationFilePath = str_replace(' ', '_', $destinationFilePath);

        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        rename($tempFilePath, $destinationFilePath);

        // Definir o caminho do arquivo
        $document->file_path = 'uploads/' . $document->filename . '.docx';

        $document->save();

        // Redirecionar ou retornar uma resposta de sucesso
        return redirect()->route('document.edit', ['id' => $document->id])->with('success', 'Documento criado com sucesso.');
    }
}
