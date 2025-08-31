<?php

use App\Models\{Suggestion, User};
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    public function up(): void
    {
        Schema::create('votes', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Suggestion::class)->constrained()->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['user_id', 'suggestion_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('votes');
    }
};
