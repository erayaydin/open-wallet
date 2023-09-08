<?php

namespace OpenWallet\Shared\Domain;

interface UuidGenerator
{
    public function generate(): string;
}
