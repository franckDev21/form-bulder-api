<?php

namespace App\Http\Controllers\Api;

use App\Helpers\TransactionHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\FormStoreRequest;
use App\Http\Requests\Api\FormUpdateRequest;
use App\Http\Resources\Api\FormResource;
use App\Models\Field;
use App\Models\FieldLigne;
use App\Models\Form;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class FormController extends Controller {
    
    public function index(): AnonymousResourceCollection {
        $forms = Form::with('lignes.fields','user')->latest()->get();
        return FormResource::collection($forms);
    }

    public function show(Form $form): FormResource {
        $form->load('lignes.fields');
    
        return new FormResource($form);   
    }

    public function store(FormStoreRequest $request): FormResource {
        $data = $request->validated();

        return TransactionHelper::transactionWrapper(function() use ($data, $request) {
            $userId = $request->user()->id; // l'id de l'admin connecté

            // Créer le formulaire en ajoutant 'user_id' aux données validées
            $form = Form::create(array_merge($data, ['user_id' => $userId]));
    
            // Sauvegarde des lignes du formulaire
            $this->storeFormLines($data['lignes'], $form->id);
    
            // Charger les relations 'lignes' et 'fields'
            $form->load('lignes.fields');
    
            return new FormResource($form);    
        });
        
    }

    public function update(FormUpdateRequest $request, Form $form): FormResource {
        $data = $request->validated();

        return TransactionHelper::transactionWrapper(function() use ($data, $form) {
            // Mettre à jour le formulaire
            $form->update($data);

            // Supprimer les anciennes lignes et champs
            $form->lignes()->delete();

            // Sauvegarde des nouvelles lignes du formulaire
            $this->storeFormLines($data['lignes'], $form->id);

            // Recharger les relations 'lignes' et 'fields'
            $form->load('lignes.fields');

            return new FormResource($form);
        });
    }

    private function storeFormLines(array $lignes, string $formId): void {
        foreach ($lignes as $ligneData) {
            // Créer la ligne du formulaire
            $ligne = FieldLigne::create([
                'form_id' => $formId,
                'column_count' => $ligneData['column_count'],
            ]);
    
            // Sauvegarde des champs de chaque ligne du formulaire
            $this->storeFormFields($ligneData['fields'], $ligne->id, $formId);
        }
    }


    private function storeFormFields(array $fields, int $ligneId, string $formId): void {
        foreach ($fields as $fieldData) {
            // Créer les champs et associer la ligne et l'utilisateur
            Field::create(array_merge($fieldData, [
                'field_ligne_id' => $ligneId, // Associer l'id de la ligne à chaque champ
                'form_id' => $formId
            ]));
        }
    }

    public function destroy(Form $form) : Response {
        $form->delete();
        return response()->noContent();
    }

}
