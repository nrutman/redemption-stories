<?php

namespace App\Domain\Testimony;

use App\Domain\DomainException\DomainRecordNotFoundException;

class TestimonyNotFoundException extends DomainRecordNotFoundException
{
    protected $message = 'The object you requested does not exist.';
}
