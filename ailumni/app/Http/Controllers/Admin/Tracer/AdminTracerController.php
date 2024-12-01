<?php

namespace App\Http\Controllers\Admin\Tracer;

use App\Models\Alumnus;
use App\Models\PendingResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminTracerController extends Controller
{
    public function index()
    {
        $pendingResponses = PendingResponse::where('status', 'pending')->get();
        $processedResponses = PendingResponse::whereIn('status', ['approved', 'rejected'])->get();
        return view('admin.pending-responses', compact('pendingResponses', 'processedResponses'));
    }

    public function show(PendingResponse $response)
    {
        return response()->json($response);
    }

    public function edit(PendingResponse $response)
    {
        return response()->json($response);
    }

    public function update(Request $request, PendingResponse $response)
    {
        $validatedData = $request->validate([
            // Add validation rules for all fields
            'name' => 'nullable|string|max:255',
            'year_graduated' => 'required|integer',
            // ... add other fields ...
        ]);

        $response->update(['response_data' => $validatedData]);

        return response()->json(['success' => true]);
    }

    public function approve(PendingResponse $response)
    {
        $alumniData = $response->response_data;
        Alumnus::create($alumniData);
        $response->update(['status' => 'approved']);
        return redirect()->route('admin.pending-responses')->with('success', 'Response approved and added to alumni table.');
    }

    public function reject(PendingResponse $response)
    {
        $response->update(['status' => 'rejected']);
        return redirect()->route('admin.pending-responses')->with('success', 'Response rejected.');
    }
}
