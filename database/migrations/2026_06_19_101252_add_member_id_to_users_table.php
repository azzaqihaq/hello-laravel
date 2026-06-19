<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('member_id')->nullable()->unique()->after('id');
        });

        // Generate unique member IDs for existing users if any
        $users = DB::table('users')->get();
        foreach ($users as $user) {
            do {
                $code = 'MEM-' . strtoupper(Str::random(6));
            } while (DB::table('users')->where('member_id', $code)->exists());

            DB::table('users')->where('id', $user->id)->update([
                'member_id' => $code
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('member_id');
        });
    }
};
