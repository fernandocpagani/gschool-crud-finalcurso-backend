<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('subtask', function (Blueprint $table) {
            $table->increments('id');
            $table->string('subtasktitle', 255);
            $table->text('subtaskdescription'); 
            $table->enum('subtaskstatus', ['pending','completed']); 
            $table->timestamps();
            $table->integer('task_id')->unsigned()->index()->nullable();
            $table->foreign('task_id')->references('id')->on('task')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subtask');
    }
};
