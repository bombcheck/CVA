<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCampaignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->string('title');
            $table->string('description');
            $table->text('sms_script')->nullable();
            $table->text('call_script')->nullable();
            $table->text('email_subject')->nullable();
            $table->text('email_html')->nullable();
            $table->boolean('sms_verified')->default(false);
            $table->boolean('call_verified')->default(false);
            $table->boolean('email_verified')->default(false);
            $table->boolean('campaign_verified')->default(false);

            $table->bigInteger('brand_id')->unsigned();

            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade');
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
        Schema::dropIfExists('campaigns');
    }
}
