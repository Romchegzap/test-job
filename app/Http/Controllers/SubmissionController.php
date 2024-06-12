<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidateSubmissionSubmitRequest;
use App\Jobs\SubmissionSubmit;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Throwable;

class SubmissionController extends Controller
{
    public function __invoke(ValidateSubmissionSubmitRequest $request): JsonResponse
    {
        try {
            $submissionDTO = $request->toDTO();
            SubmissionSubmit::dispatch($submissionDTO)->onQueue('submission-submit');

            return response()->json(['status' => true, 'message' => 'Data submitted for processing']);
        } catch (ValidationException $e) {
            return response()->json(['status' => false, 'message' => $e->validator->errors()->first()], 422);
        }  catch (Throwable $e) {
            return response()->json(['status' => false, 'message' => 'Internal Server Error'], 500);
        }

        //Possible to use custom exceptions if there will be more logic
    }
}
