<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exchange', function (Blueprint $table) {
            $table->increments('id', 5);
            $table->uuid('uuid');
            $table->string('uname', 200);
            $table->string('name', 200);
            $table->string('module', 255)->comment('module to load as a service');
            $table->string('display_name', 200)->comment('friendly display name');
            $table->string('meta_keywords', 255);
            $table->string('meta_description', 255);
            $table->text('desc');
            $table->string('short_desc', 200);
            $table->decimal('score', 1, 1);
            $table->tinyInteger('score_rank');
            $table->smallInteger('coins', 5);
            $table->string('site_url', 255);
            $table->string('blog_url', 255)->nullable();
            $table->string('twitter_url')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('tiktok_url')->nullable();
            $table->string('youtube_url')->nullable();
            $table->smallInteger('country_id', 5);
            $table->tinyInteger('active')->nullable()->default('0');
            $table->tinyInteger('deleted')->nullable()->default('0');
            $table->tinyInteger('banned')->nullable()->default('0');
            $table->datetime('banned_until')->nullable();
            $table->year('year_established')->nullable();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->nullable();
            $table->smallInteger('updated_by')->length(5);
            // $table->timestamps();
        });

        DB::statement("ALTER TABLE exchange AUTO_INCREMENT=600");
		// ensure that MYSQL enforces on update
		DB::statement('ALTER TABLE exchange
    			CHANGE updated_at 
        		updated_at TIMESTAMP NOT NULL
                    	DEFAULT CURRENT_TIMESTAMP
			ON UPDATE CURRENT_TIMESTAMP
		');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exchange');
    }
};