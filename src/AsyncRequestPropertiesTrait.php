<?php

namespace Saraf;

use Saraf\ResponseHandlers\BasicHandler;
use React\Http\Browser;

trait AsyncRequestPropertiesTrait
{
    protected string $responseHandler = BasicHandler::class;
    public Browser $browser;
}