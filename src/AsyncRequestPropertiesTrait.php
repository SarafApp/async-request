<?php

namespace Saraf;

use React\Http\Browser;
use Saraf\ResponseHandlers\BasicHandler;

trait AsyncRequestPropertiesTrait
{
    protected string $responseHandler = BasicHandler::class;
    public Browser $browser;

    protected bool $isLoggerActive = false;

    public function activateLogger(): void
    {
        $this->isLoggerActive = true;
    }

    public function deactivateLogger(): void
    {
        $this->isLoggerActive = false;
    }
}