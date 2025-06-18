<?php

namespace App\Http\Controllers;

use App\Enums\TypeStatus;
use App\Http\Requests\StoreSupportTicketRequest;
use App\Jobs\ProcessTicketTypeStatus;
use App\Models\SupportTicket;
use Illuminate\Http\JsonResponse;

class SupportTicketController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(SupportTicket::query()->paginate(10));
    }

    public function show(SupportTicket $supportTicket): JsonResponse
    {
        return response()->json($supportTicket);
    }

    public function store(StoreSupportTicketRequest $request): JsonResponse
    {
        $ticket = SupportTicket::query()->create([
            ...$request->validated(),
            'type' => null,
            'type_status' => TypeStatus::PENDING->value,
        ]);
        ProcessTicketTypeStatus::dispatch($ticket);
        return response()->json($ticket);
    }
}
