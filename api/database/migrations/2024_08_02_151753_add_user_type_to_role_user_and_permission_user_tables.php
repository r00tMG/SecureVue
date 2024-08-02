<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserTypeToRoleUserAndPermissionUserTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('role_user', function (Blueprint $table) {
            $table->string('user_type')->default('App\\Models\\User');
        });

        Schema::table('permission_user', function (Blueprint $table) {
            $table->string('user_type')->default('App\\Models\\User');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('role_user', function (Blueprint $table) {
            $table->dropColumn('user_type');
        });

        Schema::table('permission_user', function (Blueprint $table) {
            $table->dropColumn('user_type');
        });
    }
}
