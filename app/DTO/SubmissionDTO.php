<?php

namespace App\DTO;

use Spatie\DataTransferObject\DataTransferObject;

class SubmissionDTO extends DataTransferObject
{
    public ?int $id;
    public string $name;
    public string $email;
    public string $message;
}
