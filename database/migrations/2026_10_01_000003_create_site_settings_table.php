<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table): void {
            $table->id();
            $table->string('site_name');
            $table->string('tagline');
            $table->string('hero_eyebrow');
            $table->string('hero_title');
            $table->text('hero_copy');
            $table->string('altitude_label');
            $table->string('altitude_value');
            $table->string('velocity_label');
            $table->string('velocity_value');
            $table->string('heading_label');
            $table->string('heading_value');
            $table->string('primary_cta_label');
            $table->string('primary_cta_url');
            $table->string('secondary_cta_label');
            $table->string('secondary_cta_anchor');
            $table->text('footer_text');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
