<?php

namespace WebSupply\Commander\Annotations;

#[\Attribute(\Attribute::TARGET_CLASS)]
final class CommandHandler
{
    public function __construct() {}
}
