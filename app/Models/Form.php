<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Form extends Model {
    use HasFactory;

    protected $fillable = [
        'name',
        'validated_at',
        'validated_user_id',
        'active',
        'user_id'
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function lignes(): HasMany {
        return $this->hasMany(FieldLigne::class);
    }

}
