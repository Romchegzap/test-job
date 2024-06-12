<?php

namespace Tests\Unit;

use App\DTO\SubmissionDTO;
use App\Events\SubmissionSaved;
use App\Interfaces\SubmissionRepositoryInterface;
use App\Repositories\SubmissionRepository;
use Illuminate\Support\Facades\Event;
use Mockery;
use Tests\TestCase;
use App\Http\Controllers\SubmissionController;
use App\Http\Requests\ValidateSubmissionSubmitRequest;
use Illuminate\Http\JsonResponse;
use App\Jobs\SubmissionSubmit;
use Illuminate\Support\Facades\Queue;

class SubmissionControllerTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_invoke_method_request_validation()
    {
        $data = [
            'name'    => 'John Doe',
            'email'   => 'john.doe@example.com',
            'message' => 'This is a test message.'
        ];

        $request = new ValidateSubmissionSubmitRequest($data);

        $validated = $request->validate($request->rules());
        $this->assertEquals($validated, $data);
    }


    public function test_invoke_method_request_to_dto()
    {
        $data = [
            'name'    => 'John Doe',
            'email'   => 'john.doe@example.com',
            'message' => 'This is a test message.'
        ];

        $request = new ValidateSubmissionSubmitRequest($data);
        $dto = $request->toDTO();

        $expectedDTO = new SubmissionDTO(
            name: 'John Doe',
            email: 'john.doe@example.com',
            message: 'This is a test message.'
        );

        $this->assertEquals($expectedDTO, $dto);
    }

    public function test_invoke_method_dispatches_job_and_returns_json_response()
    {
        $data = [
            'name'    => 'John Doe',
            'email'   => 'john.doe@example.com',
            'message' => 'This is a test message.'
        ];

        $controller = new SubmissionController();
        $request = new ValidateSubmissionSubmitRequest($data);

        Queue::fake();

        $response = $controller($request);

        $this->assertInstanceOf(JsonResponse::class, $response);

        $this->assertEquals(['status' => true, 'message' => 'Data submitted for processing'], $response->getData(true));

        Queue::assertPushed(SubmissionSubmit::class, function (SubmissionSubmit $job) use ($data, $request) {
            return $job->submissionDTO == $request->toDTO();
        });
    }

    public function test_submission_submit_queue()
    {
        $job = new SubmissionSubmit(new SubmissionDTO(
            name: 'John Doe',
            email: 'john.doe@example.com',
            message: 'This is a test message.'
        ));

        Event::fake();

        $submissionRepository = app()->make(SubmissionRepositoryInterface::class);
        $job->handle($submissionRepository);

        $this->assertDatabaseHas('submissions', [
            'name' => $job->submissionDTO->name,
            'email' => $job->submissionDTO->email,
            'message' => $job->submissionDTO->message,
        ]);
        Event::assertDispatched(SubmissionSaved::class);
    }
}
