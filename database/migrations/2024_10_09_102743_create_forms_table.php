<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('forms', function (Blueprint $table) {
            $table->uuid('id')->primary(); // UUID comme clé primaire

            $table->string('name');
            $table->timestamp('validated_at')->nullable(); // date de validation du formulaire par l'auteur
            $table->integer('validated_user_id'); // id de l'utilisateur qui doit faire la validation
            $table->boolean('active')->default(true);

            $table->foreignIdFor(User::class); // author [auteur du formulaire]
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('forms');
    }
};
