<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\PaymentAccount;
use Illuminate\Http\Request;

class PaymentAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $accounts = PaymentAccount::get();

        return view('users.admin.payment.index', compact(['accounts']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.admin.payment.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'account_name' => 'required',
            'account_number' => 'required'
        ]);


        $paymentAccount = PaymentAccount::create([
            'name' => $request->name,
            'account_name' => $request->account_name,
            'account_number' => $request->account_number
        ]);


        if($request->hasFile('image')){

            $request->validate([
                'image' => 'mimes:jpg,jpeg'
            ]);

            $imageName = 'pymntccnt-' . uniqid() . '.' . $request->image->extension();
            $dir = $request->image->storeAs('/paymentAccount', $imageName, 'public');

            $paymentAccount->update([
                'image' => asset('/storage/' . $dir),
            ]);
        }

        return to_route('admin.paymentAccount.index')->with(['message' => 'Payment Account Added']);
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

        $account = PaymentAccount::find($id);

        return view('users.admin.payment.edit', compact(['account']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $account = PaymentAccount::find($id);


        $account->update([
            'name' => $request->name ?? $account->name,
            'account_name' => $request->account_name ?? $account->account_name,
            'account_number' => $request->account_number ?? $account->account_number
        ]);


        if($request->hasFile('image')){

            $request->validate([
                'image' => 'mimes:jpg,jpeg'
            ]);

            $imageName = 'pymntccnt-' . uniqid() . '.' . $request->image->extension();
            $dir = $request->image->storeAs('/paymentAccount', $imageName, 'public');

            $account->update([
                'image' => asset('/storage/' . $dir),
            ]);
        }



        return back()->with(['message' =>'Data Updated']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $account = PaymentAccount::find($id);

        $account->delete();


        return back()->with(['message' => 'Account Deleted']);
    }
}
