<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StorePaymentRequest;
use App\Http\Requests\UpdatePaymentRequest;
use App\Models\Payment;
use App\Models\Admission;


class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      // $paginate = $request->paginate ?? 25;
      $payments = Payment::latest()->paginate(25);
      return response()->json([
        'payments' => $payments
      ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      $data = $request->validate([
        'admission_id' => 'required|numeric',
        'payment_type' => 'required',
        'transaction_id' => 'nullable',
        'account_no' => 'nullable',
        'paid_amount' => 'nullable'
      ]);

      $data['school_id'] = app('school')->id;
      
      try {
        $payment = Payment::create($data);

        //update admision after payment
        Admission::where('id', $request->admission_id)->update([
          'status' => 'Paid'
        ]);

        return response()->json([
          'payment' => $payment,
          'message' => 'Payment receive successful.'
        ], 200);
      }
      catch(\Exception $e)
      {
        return $e->getMessage();
      }

      return response()->json([
        'message' => 'Unknown error, contact with administrator'
      ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
      $payment = Payment::find($payment);
      return response()->json([
        'payment' => $payment
      ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payment $payment)
    {
      $data = $request->validate([
        'admission_id' => 'required|numeric',
        'payment_type' => 'nullable',
        'transaction_id' => 'nullable',
        'account_no' => 'nullable',
        'paid_amount' => 'nullable'
      ]);
      
      try {
        $payment = Payment::where('id', $payment)->update($data);
        return response()->json([
          'payment' => $payment,
          'message' => 'Payment updated.'
        ], 200);
      }
      catch(\Exception $e)
      {
        return $e->getMessage();
      }

      return response()->json([
        'message' => 'Unknown error, contact with administrator'
      ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
      $payment = Payment::find($payment);
      $payment->delete();
      return response()->json(
        [
          'payment' => $payment,
          'message' => 'Requested payment deleted.'
        ], 200
      );
    }
}
