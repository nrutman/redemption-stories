<?php

namespace App\Domain\Story;

use App\Domain\DomainException\DomainRecordNotFoundException;

class StoryNotFoundException extends DomainRecordNotFoundException
{
    protected $message = 'The story you requested does not exist.';
}
