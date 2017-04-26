<?php

declare(strict_types=1);

namespace FondBot\Drivers\Facebook\Templates;

use FondBot\Contracts\Arrayable;
use FondBot\Conversation\Template;
use JsonSerializable;

interface TemplateInterface extends Template, Arrayable, JsonSerializable
{

}