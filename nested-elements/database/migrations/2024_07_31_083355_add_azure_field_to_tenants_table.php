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
        Schema::table('tenants', function (Blueprint $table) {
            $table->string('azure_client_id')->nullable();
            $table->string('azure_client_secret')->nullable();
            $table->string('azure_redirect_uri')->nullable();
            $table->string('azure_tenant_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tenants', function (Blueprint $table) {
            $table->dropColumn([
                'azure_client_id',
                'azure_client_secret',
                'azure_redirect_uri',
                'azure_tenant_id',
                'company_id',
            ]);
        });
    }
};
