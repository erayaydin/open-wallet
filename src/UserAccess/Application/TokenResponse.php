<?php

namespace OpenWallet\UserAccess\Application;

use OpenWallet\Shared\Domain\Bus\Query\Response;
use OpenWallet\UserAccess\Domain\ValueObject\Token;

final class TokenResponse implements Response
{
    public function __construct(
        public Token $token,
    ) {
    }

    public function toArray(): array
    {
        return [
            'token' => $this->token->getValue(),
        ];
    }
}
