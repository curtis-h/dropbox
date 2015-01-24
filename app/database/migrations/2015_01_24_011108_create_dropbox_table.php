<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDropboxTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	   Schema::create('dropbox', function(Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();
            $table->string('access_token');
            $table->string('latitude');
            $table->string('longitude');
            $table->string('filename');
            $table->string('link');
            
            /*
             * Not sure on the name for this?
             * The column type is an identier for the type of account the user is.
             * 0 => they are not an active user, ie they have just signed up for a ticket but didn't want a user account
             * 1 => active - they have created an account
             * 2 => staff
             */
	    });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('dropbox');
	}

}
