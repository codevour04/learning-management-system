<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function getList(Request $request): JsonResponse
    {
        $transactionList = Transaction
            ::select([
                'id',
                'issued_at',
                'transaction_number',
                'status',
                'customers_id',
                'sales_agent',
                'pre_approver',
                'pre_approved_at',
                'final_approver',
                'final_approved_at',
            ])
            ->with([
                'customer:id,first_name,middle_name,last_name,address,city,country',
                'salesAgent:id',
                'preApprover:id',
                'finalApprover:id'
            ])
            ->paginate(5);

        return response()->json($transactionList);
    }


    public function create()
    {
    }

    public function store(Request $request)
    {
    }

    public function show(Transaction $transaction)
    {
    }

    public function edit(Transaction $transaction)
    {
    }

    public function update(Request $request, Transaction $transaction)
    {
    }

    public function destroy(Transaction $transaction)
    {
    }
}
