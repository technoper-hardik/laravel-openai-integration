<?php

namespace App\Models;

use App\Enums\TicketType;
use App\Enums\TypeStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SupportTicket extends Model
{
    protected $fillable = [
        'name',
        'message',
        'type',
        'type_status',
    ];

    protected $casts = [
        'type' => TicketType::class,
        'type_status' => TypeStatus::class,
    ];

    public function llmResponses(): HasMany
    {
        return $this->hasMany(LLMResponse::class);
    }
}
