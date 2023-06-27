<?php

namespace App\Http\Controllers;

use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Settings;
use App\Models\Document;
use App\Models\DocumentPermission;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Storage;
// use Html2Text\Html2Text;


class DocumentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:pdf,doc,docx|max:2048',
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = $file->getClientOriginalName();
            $path = $file->store('uploads', 'public');

            // Salvar as informações do documento no banco de dados
            $document = Document::create([
                'filename' => $filename,
                'file_path' => $path,
                'user_id' => auth()->user()->id,
            ]);

            // Verificar se o arquivo é um DOCX
            if ($file->getClientOriginalExtension() === 'docx') {
                // Carregar o conteúdo do arquivo DOCX usando PhpWord
                $phpWord = IOFactory::load($file);

                // Definir configurações para salvar como HTML
                Settings::setOutputEscapingEnabled(true);

                // Salvar o conteúdo como HTML
                $htmlWriter = new \PhpOffice\PhpWord\Writer\HTML($phpWord);
                $htmlFilePath = storage_path('app/public/html/') . $filename . '.html';
                $htmlWriter->save($htmlFilePath);

                // Ler o conteúdo HTML do arquivo
                $html = file_get_contents($htmlFilePath);

                // Atualizar a coluna 'content' com o conteúdo convertido para HTML
                $document->update(['content' => $html]);

                // Remover o arquivo HTML temporário
                unlink($htmlFilePath);
            }

            return redirect()->route('upload.create')->with('success', 'Arquivo enviado com sucesso.');
        }

        return redirect()->route('upload.create')->withErrors(['error' => 'Falha ao enviar o arquivo.']);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'filename' => 'required',
            'content' => 'required',
        ]);

        $document = Document::findOrFail($id);

        $document->filename = $request->input('filename'); // Atualizar o título (filename)
        $document->content = $request->input('content'); // Atualizar o conteúdo (content)
        $document->save();

        return redirect()->route('document.edit', ['id' => $id])->with('success', 'Documento atualizado com sucesso.');
    }

    public function create()
    {
        return view('upload.create');
    }

    private function extractContent($element)
    {
        $content = '';

        if ($element instanceof \PhpOffice\PhpWord\Element\TextRun) {
            foreach ($element->getElements() as $textElement) {
                if ($textElement instanceof \PhpOffice\PhpWord\Element\Text) {
                    $content .= $textElement->getText();
                }
            }
        } elseif ($element instanceof \PhpOffice\PhpWord\Element\Text) {
            $content .= $element->getText();
        }

        return $content;
    }

    public function destroy($id)
    {
        $document = Document::findOrFail($id);

        // Verificar se o usuário tem permissão para excluir o documento
        if (!$document->canDelete()) {
            abort(403, 'Acesso negado');
        }

        // Excluir os registros na tabela document_permissions relacionados ao documento
        DocumentPermission::where('document_id', $document->id)->delete();

        // Excluir o documento
        $document->delete();

        return redirect()->route('documents.search')->with('success', 'Documento excluído com sucesso');
    }

    public function show($id)
    {
        $document = Document::findOrFail($id);
        return view('show', compact('document'));
    }
}
