<?php

namespace App\Interfaces;

use App\DTO\SubmissionDTO;

interface SubmissionRepositoryInterface
{
    public function getAllSubmissions();
    public function getSubmissionById(int $submissionId);
    public function deleteSubmission(int $submissionId);
    public function createSubmission(SubmissionDTO $submissionDTO);
    public function updateSubmission(int $submissionId, array $newDetails);
}
