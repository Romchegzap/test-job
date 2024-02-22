<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidateSubmissionSubmitRequest;
use App\Jobs\SubmissionSubmit;
use Illuminate\Http\JsonResponse;

class SubmissionController extends Controller
{
    public function submit(ValidateSubmissionSubmitRequest $request): JsonResponse
    {
        $validatedFields = $request->validated();
        SubmissionSubmit::dispatch($validatedFields)->onQueue('submission-submit');

        return response()->json(['status' => true, 'message' => 'Data submitted for processing']);
    }
}
