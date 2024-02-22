<?php

namespace App\Listeners;

use App\Events\SubmissionSaved;
use App\Models\Submission;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class LogSubmissionSaved
{
    public function __construct()
    {
        //
    }

    public function handle(SubmissionSaved $event)
    {
        $submission = $event->submission;
        $name = $submission->name;
        $email = $submission->email;

        Log::info("Submission saved successfully: Name - $name, Email - $email");
    }
}
