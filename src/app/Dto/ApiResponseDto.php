<?php

namespace App\Dto;

use AllowDynamicProperties;

#[AllowDynamicProperties] class ApiResponseDto
{
    public bool $error = false;
    public string $message = '';
    public array $data = [];
}
