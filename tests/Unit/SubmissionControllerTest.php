<?php

namespace Tests\Unit;

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
    public function test_submit_method_dispatches_job_and_returns_json_response()
    {
        $controller = new SubmissionController();
        $request = $this->createMock(ValidateSubmissionSubmitRequest::class);

        $data = [
            'name'    => 'John Doe',
            'email'   => 'john.doe@example.com',
            'message' => 'This is a test message.'
        ];

        $request->expects($this->once())
            ->method('validated')
            ->willReturn($data);

        Queue::fake();

        $response = $controller->submit($request);
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(['status' => true, 'message' => 'Data submitted for processing'], $response->getData(true));

        Queue::assertPushed(SubmissionSubmit::class, function (SubmissionSubmit $job) use ($data) {
            return $job->data === $data;
        });
    }
}
