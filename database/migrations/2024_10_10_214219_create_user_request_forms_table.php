<?php

use App\Models\Form;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('user_request_forms', function (Blueprint $table) {
            $table->uuid('id')->primary(); // UUID comme clé primaire

            $table->string('request_name');
            $table->json('form_data');

            $table->timestamp('validated_at')->nullable(); // date de validation du formulaire par l'auteur
            $table->integer('validated_by_user_id')->nullable(); // id de l'utilisateur qui doit faire la validation
            $table->boolean('active')->default(false);

            $table->foreignIdFor(Form::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('user_request_forms');
    }
};
