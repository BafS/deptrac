<?php

declare(strict_types=1);

namespace SensioLabs\Deptrac\AstRunner\Event;

use Symfony\Contracts\EventDispatcher\Event;

class AstFileAnalyzedEvent extends Event
{
    private $file;

    public function __construct(\SplFileInfo $file)
    {
        $this->file = $file;
    }

    public function getFile(): \SplFileInfo
    {
        return $this->file;
    }
}
