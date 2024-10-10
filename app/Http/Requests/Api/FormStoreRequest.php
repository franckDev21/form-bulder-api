<?php

namespace App\Http\Requests\Api;

use App\Models\Enums\FieldEnum;
use Illuminate\Foundation\Http\FormRequest;

class FormStoreRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array {
        return [
            'name' => 'required|string|max:255',  // Validation du champ 'name'
            'validated_user_id' => 'required|integer|exists:users,id',  // Validation de l'ID utilisateur existant dans la table users
            'lignes' => 'required|array|min:1',  // 'lignes' doit être un tableau avec au moins une ligne
            'lignes.*.column_count' => 'required|integer|min:1',  // 'column_count' est requis et doit être un entier
            'lignes.*.fields' => 'required|array|min:1',  // Chaque 'lignes' doit contenir un tableau 'fields' avec au moins un élément
            'lignes.*.fields.*.name' => 'required|string|max:255',  // Chaque 'name' dans 'fields' doit être une chaîne de caractères
            'lignes.*.fields.*.key' => 'required|string|max:255',  // Chaque 'key' dans 'fields' doit être une chaîne de caractères
            'lignes.*.fields.*.placeholder' => 'nullable|string|max:255',  // 'placeholder' peut être nul ou une chaîne de caractères
            'lignes.*.fields.*.required' => 'required|boolean',  // 'required' doit être un booléen
            'lignes.*.fields.*.crypted' => 'required|boolean',  // 'crypted' doit être un booléen
            'lignes.*.fields.*.type' => 'required|string|in:' . implode(',', FieldEnum::values()),  // 'type' doit être soit 'input' soit 'textarea'
        ];
    }

    public function messages() {
        return [
            'name.required' => 'Le nom du formulaire est requis.',
            'key.required' => 'La key du formulaire est requise.',
            'validated_user_id.required' => "L'ID de l'administrateur qui valide le formulaire est requis.",
            'validated_user_id.integer' => "L'ID de l'administrateur doit être un entier.",
            'validated_user_id.exists' => "L'administrateur validé n'existe pas.",
            'lignes.required' => 'Les lignes du formulaire sont obligatoires.',
            'lignes.*.column_count.required' => 'Le nombre de colonnes est requis.',
            'lignes.*.fields.*.name.required' => 'Le champ "Nom" est requis pour chaque field.',
            'lignes.*.fields.*.type.required' => 'Le champ "Type" est requis et doit être soit "input" soit "textarea".',
        ];
    }
}
