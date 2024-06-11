<?php

namespace App\Jobs;

use App\DTO\SubmissionDTO;
use App\Events\SubmissionSaved;
use App\Exceptions\SavingSubmissionErrorException;
use App\Interfaces\SubmissionRepositoryInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SubmissionSubmit implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public SubmissionDTO $submissionDTO;

    public function __construct(array $data)
    {
        $this->submissionDTO = new SubmissionDTO(
            name: $data['name'],
            email: $data['email'],
            message: $data['message']
        );
    }

    public function handle(SubmissionRepositoryInterface $submissionRepository)
    {
        try {
            $submission = $submissionRepository->createSubmission($this->submissionDTO);
            event(new SubmissionSaved($submission));
        } catch (SavingSubmissionErrorException $exception) {
            $exceptionMessage = $exception->getMessage();
            Log::error("Error appeared on submission save: Error - $exceptionMessage", $this->submissionDTO->toArray());
        }
    }
}
