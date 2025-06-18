<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LLMResponse extends Model
{
    protected $fillable = [
        'support_ticket_id',
        'request',
        'response',
    ];

    protected $table = 'llm_responses';

    public function supportTicket(): BelongsTo
    {
        return $this->belongsTo(SupportTicket::class);
    }
}
