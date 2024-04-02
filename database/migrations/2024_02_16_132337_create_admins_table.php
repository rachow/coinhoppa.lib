<?php

use Symfony\Component\Console\Output\ConsoleOutput;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    protected $output;

    public function __construct()
    {
        $this->output = new ConsoleOutput();
        parent::__construct();
    }
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (($confirm == readline('Would you like to delete existing table [y/n] ? :')) == 'y') {
            $this->down();
            $this->output->writeln('Existing table has been deleted.');
        }

        Schema::create('admins', function (Blueprint $table) {
            $table->increments('id', 5);
            $table->string('firstname', 100);
            $table->string('lastname', 100);
            $table->string('email', 200);
            $table->string('password', 255);
            $table->string('remember_token', 100)->nullable();
            $table->string('avatar', 255)->nullable();
            $table->tinyInteger('admin_level')->default('1');
            $table->tinyInteger('active')->nullable()->default('0');
            $table->timestamp('activation_date')->nullable();
            $table->tinyInteger('banned')->nullable()->default('0');
            $table->datetime('banned_until')->nullable();
            $table->timestamp('password_changed_at')->nullable();
            $table->string('last_login_ip', 16)->nullable();
            $table->timestamp('last_login_at')->nullable();
            $table->timestamp('last_activity')->nullable();
            $table->timestamps();
            $table->unique(['email']);
        });

        DB::statement('ALTER TABLE admins AUTO_INCREMENT=300');
		// ensure that MYSQL enforces on update
		DB::statement('ALTER TABLE admins
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
        Schema::dropIfExists('admins');
    }
};