<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSupportTicketRequest;
use App\Jobs\ProcessTicketTypeStatus;
use App\Models\SupportTicket;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class SupportTicketUIController
{
    public function index(): Response
    {
        return Inertia::render('tickets/index', [
            'tickets' => SupportTicket::query()->latest()->get(),
        ]);
    }

    public function store(StoreSupportTicketRequest $request): RedirectResponse
    {
        $ticket = SupportTicket::query()->create($request->validated());
        ProcessTicketTypeStatus::dispatch($ticket);
        return redirect()->back()->with('success', 'Ticket submitted.');
    }
}
