<?php

namespace App\Validator\DiscordWebhook;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

final class DiscordWebhookValidator extends ConstraintValidator
{
    private const string DISCORD_PATTERN = '/^https:\/\/(?:(?:canary|ptb)\.)?discord(?:app)?\.com\/api\/webhooks\/(\d{17,20})\/([\w-]{60,80})\/?$/';

    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof DiscordWebhook) {
            throw new UnexpectedTypeException($constraint, DiscordWebhook::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        if (!preg_match(self::DISCORD_PATTERN, $value)) {
            $this->context
                ->buildViolation($constraint->message)
                ->addViolation()
            ;
        }
    }
}
