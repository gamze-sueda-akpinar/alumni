<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_posting_id')->constrained('job_postings')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->text('cover_letter')->nullable();
            $table->string('resume_path')->nullable();
            $table->string('status', 50)->default('pending'); // pending, reviewed, shortlisted, accepted, rejected
            $table->text('notes')->nullable();
            $table->timestamp('applied_at')->nullable();
            $table->timestamps();

            // Constraint: One application per user per job posting
            $table->unique(['job_posting_id', 'user_id'], 'unique_user_job_application');
            $table->index('status');
        });

        // Updatable SQL View 'applications' for universal compatibility
        DB::statement('CREATE OR REPLACE VIEW applications AS SELECT * FROM job_applications');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS applications');
        Schema::dropIfExists('job_applications');
    }
};
