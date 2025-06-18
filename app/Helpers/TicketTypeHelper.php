<?php

namespace App\Helpers;

use App\Enums\TicketType;
use App\Models\SupportTicket;
use Exception;
use Prism\Prism\Enums\Provider;
use Prism\Prism\Prism;
use Prism\Prism\Text\PendingRequest;
use Throwable;

class TicketTypeHelper
{
    public static function getTicketType(SupportTicket $ticket): ?TicketType
    {
        $systemPrompt = self::systemPrompt();
        try {
            $response = retry(3, function () use ($systemPrompt, $ticket) {
                return self::request()
                    ->withSystemPrompt($systemPrompt)
                    ->withPrompt($ticket->toJson())->asText()->text;
            }, 15000);
            if (!$response) {
                throw new Exception('Error while calling llm request.');
            }
            $ticket->llmResponses()->create([
                'request' => json_encode([
                    'system_prompt' => $systemPrompt,
                    'message' => $ticket,
                ]),
                'response' => $response,
            ]);
            return TicketType::from($response);
        } catch (Throwable $throwable) {
            $ticket->llmResponses()->create([
                'request' => json_encode([
                    'system_prompt' => $systemPrompt,
                    'message' => $ticket,
                ]),
                'response' => $throwable->getMessage(),
            ]);
            return null;
        }
    }

    private static function request(): PendingRequest
    {
        return Prism::text()->using(Provider::OpenAI, 'gpt-4o-2024-08-06');
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
