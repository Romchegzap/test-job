<?php

namespace App\Jobs;

use App\Events\SubmissionSaved;
use App\Interfaces\SubmissionRepositoryInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Throwable;

class SubmissionSubmit implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function handle(SubmissionRepositoryInterface $submissionRepository)
    {
        try {
            $submission = $submissionRepository->createSubmission($this->data);
            event(new SubmissionSaved($submission));
        } catch (Throwable $exception) {
            $data = json_encode($this->data);
            $exceptionMessage = $exception->getMessage();
            Log::error("Error appeared on submission save: Error - $exceptionMessage, Data - $data");
        }
    }
}
