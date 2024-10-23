<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('users', function (Blueprint $table) {
        $table->string('contact_info')->nullable();
        $table->string('jobs')->nullable();
        $table->text('achievements')->nullable();
        $table->text('bio')->nullable();
    });
}

public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn(['contact_info', 'jobs', 'achievements', 'bio']);
    });
}

};
