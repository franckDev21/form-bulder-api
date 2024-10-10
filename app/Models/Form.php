<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Form extends Model {
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'validated_at',
        'validated_user_id',
        'active',
        'user_id'
    ];

    protected function casts(): array {
        return [
            'validated_at' => 'datetime',
        ];
    }


    // Override the primary key type to UUID
    public function getKeyType() {
        return 'string';
    }

    public function getIncrementing() {
        return false;
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function lignes(): HasMany {
        return $this->hasMany(FieldLigne::class);
    }

    public function fields(): HasMany {
        return $this->hasMany(Field::class);
    }

}
