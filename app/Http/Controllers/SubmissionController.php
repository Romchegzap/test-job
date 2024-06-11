<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidateSubmissionSubmitRequest;
use App\Jobs\SubmissionSubmit;
use Illuminate\Http\JsonResponse;

class SubmissionController extends Controller
{
    public function __invoke(ValidateSubmissionSubmitRequest $request): JsonResponse
    {
//        dd(111, $request->all());
        $submissionDTO = $request->toDTO();
//        dd($submissionDTO);
        SubmissionSubmit::dispatch($submissionDTO->toArray())->onQueue('submission-submit');

        return response()->json(['status' => true, 'message' => 'Data submitted for processing']);
    }
}
