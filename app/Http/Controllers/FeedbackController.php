<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\ServiceRequest;
use App\Models\ServiceRequestFeedback;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function store(Request $request, ServiceRequest $serviceRequest): RedirectResponse
    {
        abort_unless($serviceRequest->user_id === auth()->id(), 403);
        abort_if(!$serviceRequest->isCompleted(), 422, 'Feedback cuma bisa diisi untuk tugas yang sudah selesai.');
        abort_if($serviceRequest->feedback()->exists(), 422, 'Feedback untuk tugas ini sudah pernah diisi.');

        $validated = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['nullable', 'string', 'max:255'],
        ]);

        ServiceRequestFeedback::create([
            'service_request_id' => $serviceRequest->id,
            'worker_id' => $serviceRequest->worker_id,
            'user_id' => auth()->id(),
            'rating' => $validated['rating'],
            'comment' => $validated['comment'] ?? null,
        ]);

        return back()->with('success', 'Terima kasih atas feedback-nya!');
    }
}
