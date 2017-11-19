<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminsRolePermission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',64)->index();
            $table->text('description');
            $table->timestamps();
        });
        Schema::create('admin_permission_role', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('role_id')->index();
            $table->integer('permission_id')->index();
            $table->timestamps();
            $table->unique(['role_id','permission_id']);
        });
        Schema::create('admin_role_user', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('role_id')->index();
            $table->integer('user_id')->index();
            $table->timestamps();
            $table->unique(['role_id','user_id']);
        });
        Schema::create('admin_permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->name('name',64)->unique();
            $table->text('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_roles');
        Schema::dropIfExists('admin_permission_role');
        Schema::dropIfExists('admin_role_user');
        Schema::dropIfExists('admin_permissions');
    }
}
