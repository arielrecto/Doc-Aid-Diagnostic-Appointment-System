<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $appointment  = Appointment::find($request->appointment_id);

        if($request->amount !== $appointment->balance){
            return back()->with(['rejected' => 'The amount is less than or greater than the total balance: ₱ ' . $appointment->balance ]);
        }

        $imageName = 'PYMNT-' . uniqid() . '.' . $request->image->extension();
        $dir = $request->image->storeAs('/payment', $imageName, 'public');


        Payment::create([
            'ref_number' => $request->ref_number,
            'amount' => $request->amount,
            'image' => asset('/storage/' . $dir),
            'type' => 'fullpayment',
            'appointment_id' => $appointment->id
        ]);
        $appointment->update([
            'balance' => $appointment->balance - $request->amount,
        ]);


        return back()->with(['message' => 'payment success!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
