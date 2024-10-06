<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::statement("CREATE EXTENSION IF NOT EXISTS unaccent");

        \DB::statement('
        CREATE OR REPLACE FUNCTION public.s(input text)
        RETURNS text
        LANGUAGE plpgsql
        AS $function$
        begin
            return lower(unaccent(input));
        END;
        $function$
        ;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::statement("DROP EXTENSION IF EXISTS unaccent");

        \DB::statement('DROP FUNCTION IF EXISTS s(text);');
    }
};
