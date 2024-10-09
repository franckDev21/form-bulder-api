<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FieldLigne extends Model {
    use HasFactory;

    protected $fillable = [
        'column_cont',
        'form_id',
    ];

    public function form(): BelongsTo {
        return $this->belongsTo(Form::class);
    }

    public function fields(): HasMany {
        return $this->hasMany(Field::class);
    }
}
