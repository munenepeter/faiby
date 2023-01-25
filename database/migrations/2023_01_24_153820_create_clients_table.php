<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('full_names');
            $table->string('email')->unique();
            $table->string('phone');
            $table->unsignedInteger('plan_id');
            $table->foreign('plan_id')->references('id')->on('plans');
            $table->date('plan_start_at');
            $table->date('plan_end_at')->default(
                date("Y-m-d", strtotime('+1 month', strtotime(DB::raw('plan_start_at'))))
            );
            $table->text('notes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('clients');
    }
};
