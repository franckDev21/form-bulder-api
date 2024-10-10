<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserRequestForm extends Model {
    use HasFactory, HasUuids;

    protected $fillable = ['request_name', 'form_data', 'form_id', 'validated_by_user_id', 'validated_at'];

    protected function casts(): array {
        return [
            'validated_at' => 'datetime',
        ];
    }
    
    // Cast form_data to array automatically
    protected $casts = [
        'form_data' => 'array',
    ];

    // Override the primary key type to UUID
    public function getKeyType() {
        return 'string';
    }

    public function getIncrementing() {
        return false;
    }

    public function form(): BelongsTo{
        return $this->belongsTo(Form::class);
    }
}
