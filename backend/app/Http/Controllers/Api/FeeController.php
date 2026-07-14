<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\FeeRequest;
use App\Models\Fee;
use App\Http\Resources\FeeResource;
use Illuminate\Http\Request;
use App\Helpers\QueryFilter;
use App\Helpers\ApiResponse;

class FeeController extends Controller
{
    
    /**
     * List Fees
     *
     * Returns a list of all student fee records with student and semester information.
     *
     * @group Fee Management
     *
     * @authenticated
     *
     * @response 200 {"success": true}
     */
    public function index(Request $request)
    {
        $fees = QueryFilter::apply(
            Fee::with([
                'student',
                'semester'
            ]),
            $request,

            [],

            [
                'student_id',
                'semester_id',
                'status'
            ],

            [
                'id',
                'amount',
                'created_at'
            ]
        );

        return ApiResponse::success(
            FeeResource::collection($fees),
            'Fees retrieved successfully',
            $fees
        );
    }

    /**
     * Create Fee
     *
     * Creates a new student fee record.
     *
     * @group Fee Management
     *
     * @authenticated
     *
     * @bodyParam student_id integer required Student ID. Example: 1
     * @bodyParam semester_id integer required Semester ID. Example: 2
     * @bodyParam amount number required Total fee amount. Example: 15000
     * @bodyParam paid_amount number required Amount already paid. Example: 10000
     * @bodyParam due_amount number required Remaining due amount. Example: 5000
     * @bodyParam payment_date date Payment date. Example: 2026-01-20
     * @bodyParam payment_method string Payment method. Allowed values: Cash, Bank, Mobile Banking. Example: Bank
     * @bodyParam transaction_id string Transaction ID. Example: TXN123456789
     * @bodyParam status string required Payment status. Allowed values: Paid, Partial, Due. Example: Partial
     * @bodyParam remarks string Additional remarks. Example: First installment paid.
     *
     * @response 201 {
     *   "success": true,
     *   "message": "Fee created successfully."
     * }
     */
    public function store(FeeRequest $request)
    {
        $fee = Fee::create($request->validated());

        return ApiResponse::created(
            new FeeResource($fee),
            'Fee created successfully'
        );
    }

    /**
     * Show Fee
     *
     * Returns details of a specific fee record.
     *
     * @group Fee Management
     *
     * @authenticated
     *
     * @urlParam fee integer required Fee ID. Example: 1
     *
     * @response 200 {"success": true}
 */
    public function show(Fee $fee)
    {
        $fee->load([
            'student',
            'semester',
        ]);

        return ApiResponse::success(
            new FeeResource($fee),
            'Fee retrieved successfully'
        );
    }

    /**
     * Update Fee
     *
     * Updates an existing fee record.
     *
     * @group Fee Management
     *
     * @authenticated
     *
     * @urlParam fee integer required Fee ID. Example: 1
     *
     * @bodyParam student_id integer required Student ID. Example: 1
     * @bodyParam semester_id integer required Semester ID. Example: 2
     * @bodyParam amount number required Total fee amount. Example: 15000
     * @bodyParam paid_amount number required Amount already paid. Example: 12000
     * @bodyParam due_amount number required Remaining due amount. Example: 3000
     * @bodyParam payment_date date Payment date. Example: 2026-02-01
     * @bodyParam payment_method string Payment method. Allowed values: Cash, Bank, Mobile Banking. Example: Mobile Banking
     * @bodyParam transaction_id string Transaction ID. Example: TXN987654321
     * @bodyParam status string required Payment status. Allowed values: Paid, Partial, Due. Example: Partial
     * @bodyParam remarks string Additional remarks. Example: Second installment received.
     *
     * @response 200 {
     *   "success": true,
     *   "message": "Fee updated successfully."
     * }
     */
    public function update(FeeRequest $request, Fee $fee)
    {
        $fee->update($request->validated());

        return ApiResponse::success(
            new FeeResource($fee),
            'Fee updated successfully'
        );
    }

    /**
     * Delete Fee
     *
     * Deletes a fee record.
     *
     * @group Fee Management
     *
     * @authenticated
     *
     * @urlParam fee integer required Fee ID. Example: 1
     *
     * @response 200 {
     *   "success": true,
     *   "message": "Fee deleted successfully."
     * }
     */
    public function destroy(Fee $fee)
    {
        $fee->delete();

        return ApiResponse::deleted(
            'Fee deleted successfully'
        );
    }
}