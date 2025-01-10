<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use App\Models\VerificationRequest;
use App\Models\VerificationDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class VerificationController extends Controller
{
    public function store(Request $request)
    {
        Log::info('Verification request initiated', ['user_id' => auth()->id()]);

        $request->validate([
            'documents' => 'required|array|min:1',
            'documents.*' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048'
        ]);

        try {
            DB::beginTransaction();

            $verificationRequest = auth()->user()->verificationRequests()->create([
                'status' => 'pending'
            ]);

            Log::info('Verification request created', ['request_id' => $verificationRequest->id]);

            foreach ($request->file('documents') as $document) {
                $path = $document->store('verification-documents', 'private');
                
                $verificationDocument = new VerificationDocument([
                    'document_path' => $path,
                    'original_name' => $document->getClientOriginalName(),
                    'mime_type' => $document->getMimeType()
                ]);

                $verificationRequest->documents()->save($verificationDocument);

                Log::info('Verification document uploaded', [
                    'document_id' => $verificationDocument->id,
                    'original_name' => $verificationDocument->original_name
                ]);
            }

            DB::commit();
            Log::info('Verification request submitted successfully', ['request_id' => $verificationRequest->id]);

            return redirect()->back()->with('success', 'Verification request submitted successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to submit verification request', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()->with('error', 'Failed to submit verification request. Please try again. Error: ' . $e->getMessage());
        }
    }


    public function review(Request $request, VerificationRequest $verificationRequest)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
            'admin_notes' => 'nullable|string|max:1000'
        ]);

        $verificationRequest->update([
            'status' => $request->status,
            'admin_notes' => $request->admin_notes
        ]);

        if ($request->status === 'approved') {
            $verificationRequest->user->profile->update(['is_verified' => true]);
        }

        return redirect()->back()->with('success', 'Verification request updated successfully');
    }
}