<?php

namespace App\Services;

use App\Models\Transaction;


class TransactionsService
{
    public function index($request)
    {
        $perPage = $request->get('per_page', 20);
        $posts = Transaction::orderBy('created_at', 'desc')->paginate($perPage);
        return response()->json([
            'data' => $posts->items(),
            'current_page' => $posts->currentPage(),
            'last_page' => $posts->lastPage(),
            'per_page' => $posts->perPage(),
            'total' => $posts->total(),
            'next_page_url' => $posts->nextPageUrl(),
            'prev_page_url' => $posts->previousPageUrl(),
        ]);
    }

    public function store($request)
    {

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'campaign_id' => 'nullable|exists:campaigns,id', // Ensure campaign exists if provided
            'transaction_date' => 'required|date',
            'method' => 'required|string|in:stripe,paypal,bank_transfer', // Restrict to valid methods
            'status' => 'required|string|in:pending,completed,failed', // Restrict to valid statuses
        ]);

        $validated['user_id'] = auth()->id();

        // Create a new transaction
        return Transaction::create($validated);

    }

    public function edit($id)
    {
        return $post = Transaction::findOrFail($id);

    }

    public function update($request, $id)
    {

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'campaign_id' => 'nullable|exists:campaigns,id',
            'transaction_date' => 'required|date',
            'method' => 'required|string|in:stripe,paypal,bank_transfer',
            'status' => 'required|string|in:pending,completed,failed',
        ]);
        $transaction = Transaction::find($id);
        if (!$transaction) {
            return response()->json([
                'message' => 'Transaction not found.',
            ], 404);
        }
        return $transaction->update($validated);
    }

    public function destroy($id)
    {
        $Transaction = Transaction::findOrFail($id);
        if ($Transaction) {
            $Transaction->delete();
        }
    }
}
