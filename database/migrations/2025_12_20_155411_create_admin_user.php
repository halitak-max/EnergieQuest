<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Admin::create([
            'name' => 'Admin',
            'email' => 'halit.ak@eclipso.de',
            'password' => Hash::make('3xR%3YJ$'),
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $admin = Admin::where('email', 'admin@teleson.de')->first();
        if ($admin) {
            $admin->delete();
        }
    }
};
