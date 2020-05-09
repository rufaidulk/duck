<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIssueTimeLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('issue_time_logs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('issue_id');
            $table->date('date');
            $table->decimal('hours', 2, 2);
            $table->text('comment');
            $table->bigInteger('activity_id');
            $table->dateTime('created_at', 0);
            $table->dateTime('updated_at', 0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('issue_time_logs');
    }
}
