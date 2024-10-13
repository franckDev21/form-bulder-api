<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Field extends Model {
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'placeholder',
        'required',
        'crypted',
        'form_id',
        'field_ligne_id',
        'key',
        'options'
    ];

    protected $casts = [
        'required' => 'boolean',
        'crypted' => 'boolean',
        'options' => 'array',
    ];

    // Accessor to format 'options' as key-value pair
    public function getOptionsAttribute($value) {
        // Décoder les options JSON
        $options = json_decode($value, true);

        // Si c'est un tableau valide, transformer les données
        if (is_array($options)) {
            return array_map(function ($key, $value) {
                return [
                    'key' => $key,   // Conserve la clé originale (ex: 'option1')
                    'value' => $value // Valeur correspondante (ex: 'Douala')
                ];
            }, array_keys($options), $options);
        }

        // Si le champ est null ou mal formé, retourner un tableau vide
        return [];
    }

    public function ligne(): BelongsTo {
        return $this->belongsTo(FieldLigne::class);
    }

    public function form(): BelongsTo {
        return $this->belongsTo(Form::class);
    }
}
