<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('dni')->nullable()->unique();
            $table->string('code')->nullable()->unique();
            $table->string('phone')->nullable();
            $table->string('whatsapp')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->enum('gender', ['M','F','O'])->nullable()->after('date_of_birth');
            $table->string('address')->nullable()->after('gender');
            $table->string('avatar_path')->nullable()->after('address');
            $table->unsignedBigInteger('position_id')->nullable()->after('avatar_path');
            $table->unsignedBigInteger('department_id')->nullable()->after('position_id');
            $table->unsignedBigInteger('role_id')->nullable()->after('department_id');
            $table->string('supplier_company_name')->nullable()->after('role_id');
            $table->string('supplier_commercial_email')->nullable()->after('supplier_company_name');
            $table->text('supplier_commercial_info')->nullable()->after('supplier_commercial_email');
            $table->json('metadata')->nullable()->after('supplier_commercial_info');
        
            // Si necesitas claves foráneas, agrega:
            $table->foreign('position_id')->references('id')->on('sys_positions')->onDelete('set null');
            $table->foreign('department_id')->references('id')->on('sys_departments')->onDelete('set null');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
