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
    ];

    public function ligne(): BelongsTo {
        return $this->belongsTo(FieldLigne::class);
    }

    public function form(): BelongsTo {
        return $this->belongsTo(Form::class);
    }
}
