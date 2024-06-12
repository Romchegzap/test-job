<?php

namespace App\Jobs;

use App\DTO\SubmissionDTO;
use App\Events\SubmissionSaved;
use App\Interfaces\SubmissionRepositoryInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Throwable;

class SubmissionSubmit implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;

    public function __construct(public SubmissionDTO $submissionDTO)
    {
    }

    public function handle(SubmissionRepositoryInterface $submissionRepository)
    {
        $submission = $submissionRepository->createSubmission($this->submissionDTO);
        event(new SubmissionSaved($submission));
    }

    public function failed(Throwable $exception)
    {
        Log::error('SubmissionSubmit@failed', ['message' => $exception->getMessage(), 'data' => $this->submissionDTO->toArray()]);
    }
}
