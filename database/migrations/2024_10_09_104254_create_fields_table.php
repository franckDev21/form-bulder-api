<?php

use App\Models\Enums\FieldEnum;
use App\Models\FieldLigne;
use App\Models\Form;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('fields', function (Blueprint $table) {
            $table->id();

            $table->string('name');

            $table->enum('type', FieldEnum::values())->default(FieldEnum::INPUT->value);

            $table->string('placeholder')->nullable();
            $table->boolean('required')->default(true);
            $table->boolean('crypted')->default(false);

            $table->foreignIdFor(Form::class);
            $table->foreignIdFor(FieldLigne::class);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fields');
    }
};
