<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIssuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('issues', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('project_id');
            $table->string('subject');
            $table->text('description');
            $table->tinyInteger('tracker');
            $table->tinyInteger('priority');
            $table->bigInteger('parent_issue_id')->nullable();
            $table->bigInteger('assignee_user_id')->nullable();
            $table->bigInteger('author_user_id');
            $table->date('due_date')->nullable();
            $table->decimal('estimated_time', 8, 2)->nullable();
            $table->tinyInteger('status');
            $table->dateTime('created_at', 0);
            $table->dateTime('updated_at', 0);
            $table->unique(['project_id', 'subject']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('issues');
    }
}
