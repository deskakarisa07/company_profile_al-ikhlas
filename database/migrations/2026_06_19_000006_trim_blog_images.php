<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('blogs')->whereNotNull('image')->orderBy('id')->eachById(function ($blog) {
            DB::table('blogs')->where('id', $blog->id)->update(['image' => trim($blog->image)]);
        });
    }

    public function down(): void {}
};
