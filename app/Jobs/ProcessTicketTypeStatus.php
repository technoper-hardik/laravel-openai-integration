<?php

namespace App\Jobs;

use App\Enums\TypeStatus;
use App\Helpers\TicketTypeHelper;
use App\Models\SupportTicket;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ProcessTicketTypeStatus implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(private readonly SupportTicket $ticket)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Added extra sleep to understand status changes
        sleep(5);

        $this->ticket->update([
            'type_status' => TypeStatus::PROCESSING->value
        ]);

        // Added extra sleep to understand status changes
        sleep(5);

        try {
            $type = TicketTypeHelper::getTicketType($this->ticket);
            $this->ticket->update([
                'type' => $type,
                'type_status' => TypeStatus::COMPLETED->value,
            ]);
        } catch (Exception) {
            $this->ticket->update([
                'type_status' => TypeStatus::FAILED->value
            ]);
        }
    }
}
