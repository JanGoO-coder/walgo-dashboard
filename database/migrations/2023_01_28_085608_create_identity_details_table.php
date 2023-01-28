<?php

use App\Enums\IdentityTypeEnum;
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
        Schema::create('identity_details', function (Blueprint $table) {
            $table->id();
            $table->enum("type", IdentityTypeEnum::getValues())->default(IdentityTypeEnum::CARD);
            $table->json("images");
            $table->date("expires_at");
            $table->string("number");
            $table->unsignedBigInteger("user_id");
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->tinyInteger("archive")->default(0);
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
        Schema::dropIfExists('identity_details');
    }
};
