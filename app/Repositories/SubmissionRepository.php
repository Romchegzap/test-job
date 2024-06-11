<?php

namespace App\Repositories;

use App\DTO\SubmissionDTO;
use App\Interfaces\SubmissionRepositoryInterface;
use App\Models\Submission;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class SubmissionRepository implements SubmissionRepositoryInterface
{
    public function getAllSubmissions(): Collection
    {
        return Submission::all();
    }

    public function getSubmissionById(int $submissionId): Model
    {
        return Submission::query()->findOrFail($submissionId);
    }

    public function deleteSubmission(int $submissionId): int
    {
        return Submission::destroy($submissionId);
    }

    public function createSubmission(SubmissionDTO $submissionDTO): Model
    {
        return Submission::query()->create($submissionDTO->toArray());
    }

    public function updateSubmission(int $submissionId, array $newDetails)
    {
        return Submission::whereId($submissionId)->update($newDetails);
    }
}
