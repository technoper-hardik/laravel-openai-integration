<?php

namespace App\Helpers;

use App\Enums\TicketType;
use App\Models\SupportTicket;
use Prism\Prism\Enums\Provider;
use Prism\Prism\Prism;
use Prism\Prism\Text\PendingRequest;
use Throwable;

class TicketTypeHelper
{
    public static function getTicketType(SupportTicket $ticket): ?TicketType
    {
        try {
            return TicketType::from(self::request()->withPrompt($ticket->toJson())->asText()->text);
        } catch (Throwable) {
            return null;
        }
    }

    private static function request(): PendingRequest
    {
        return Prism::text()
            ->using(Provider::OpenAI, 'gpt-4o-2024-08-06')
            ->withSystemPrompt(static::systemPrompt());
    }

    private static function systemPrompt(): string
    {
        $statuses = collect(TicketType::cases())->pluck('value')->toJson();
        return <<<PROMPT
You are an intelligent support ticket classifier.

Given any customer message, your task is to analyze its content and output only one category that best fits the issue.
The response must be a single word from the following list (no other text):

$statuses

Rules:
Do not explain your answer.
Do not include any extra text or punctuation.
Only respond with one category from the list, even if the message is unclear.
If multiple categories apply, choose the most dominant one.
PROMPT;
    }
}
