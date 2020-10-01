<?php

namespace App\Infrastructure\Http;

use Symfony\Component\HttpFoundation\Request;

interface RequestDtoInterface
{
    public function __construct(Request $request);
}
