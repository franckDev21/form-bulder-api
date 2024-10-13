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

    protected $append = [
        'user_validated'
    ];

    protected function casts(): array {
        return [
            'validated_at' => 'datetime',
            'active' => 'boolean',
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

    public function requestForms(): HasMany {
        return $this->hasMany(UserRequestForm::class);
    }

    // Accessor for 'user_validated'
    public function getUserValidatedAttribute(): User {
        if ($this->validated_user_id) {
            // Assuming 'User' model exists and is related to the form
            $user = User::find($this->validated_user_id);
            return $user ? $user : null; // You can return any attribute from the user
        }
        return null;
    }
}
