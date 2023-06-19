<?php

namespace Saraf\ResponseHandlers;

enum HandlerEnum: string
{
    case Basic = BasicHandler::class;
    case Json = JsonHandler::class;
    case File = FileHandler::class;
}
