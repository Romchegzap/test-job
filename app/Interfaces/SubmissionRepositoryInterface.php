<?php

namespace App\Interfaces;

interface SubmissionRepositoryInterface
{
    public function getAllSubmissions();
    public function getSubmissionById(int $submissionId);
    public function deleteSubmission(int $submissionId);
    public function createSubmission(array $submissionDetails);
    public function updateSubmission(int $submissionId, array $newDetails);
}
