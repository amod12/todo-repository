<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVerificationCodesTable extends Migration
{
    public function up()
    {
        Schema::create('verification_codes', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->string('email')->index(); // Email column
            $table->unsignedBigInteger('user_id')->index(); // User ID column
            $table->string('code'); // Verification code column
            $table->timestamps(); // Created_at and Updated_at timestamps

            // Optional: Foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('verification_codes');
    }
}
