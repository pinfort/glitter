<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAccessTokenAndRefreshTokenFieldToLinkedSocialAccounts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('linked_social_accounts', function (Blueprint $table) {
            $table->string('access_token')->nullable();
            $table->string('refresh_token')->nullable();
            $table->dateTime('token_expires_in')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('linked_social_accounts', function (Blueprint $table) {
            $table->dropColumn('access_token');
            $table->dropColumn('refresh_token');
            $table->dropColumn('token_expires_in');
        });
    }
}
