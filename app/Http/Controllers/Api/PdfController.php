<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\TemplateProcessor;

class PdfController extends Controller {

    public function generate(Request $request) {
        // Augmenter le temps d'exécution à 120 secondes
        set_time_limit(120);
    
        // Valider l'upload et les inputs
        $request->validate([
            'file' => 'required|file|mimes:docx',
            'company_name' => 'required|string',
            'address' => 'required|string',
        ]);
    
        // Charger le fichier Word
        $template = new TemplateProcessor($request->file('file')->getPathName());
    
        // Remplacer les placeholders dans le document Word avec les valeurs de l'utilisateur
        $template->setValue('COMPANY_NAME', $request->input('company_name'));
        $template->setValue('ADDRESS_COMPANY_NAME', $request->input('address'));
    
        // Sauvegarder le fichier Word avec les variables modifiées
        $tempWordPath = storage_path('app/temp.docx');
        $tempPdfPath = storage_path('app/temp.pdf');
        $template->saveAs($tempWordPath);
    
        // Utiliser LibreOffice ou une autre librairie pour convertir Word en PDF
        $outputPdfPath = storage_path('app/generated.pdf');

        
        $command = "libreoffice --headless --convert-to pdf $tempWordPath --outdir " . storage_path('app');
        
        // Exécuter la commande et vérifier s'il y a des erreurs
        shell_exec($command);
   
        // Retourner le fichier PDF généré
        return response()->download($tempPdfPath);
    }
    
}
