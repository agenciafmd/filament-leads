<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leads', static function (Blueprint $table) {
            $table->id();
            $table->boolean('is_active')
                ->default(true)
                ->unsigned()
                ->index();
            $table->string('source')
                ->nullable();
            $table->string('name')
                ->nullable();
            $table->string('email')
                ->nullable();
            $table->string('phone')
                ->nullable();
            $table->longText('description')
                ->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
};
