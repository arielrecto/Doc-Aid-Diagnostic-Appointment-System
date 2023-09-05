<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Utilities\ImageUploader;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $query = $request->query();

        $builder = Service::select('*');

        if($query['availability'] ?? false ){
            $builder = Service::where(function($q) use($query) {
                $q->where('availability', '=', $query['availability']);
            });
        }

        $services = $builder->paginate(4);
        $total = Service::total();
        $totalInactiveServices = Service::totalBaseOnAvailability('INACTIVE');

        return view('users.admin.Services.index', compact(['services', 'total', 'totalInactiveServices']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.admin.Services.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'image' => 'required',
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'initPayment' => 'required',
            'session_time' => 'required',
            'extension_time' =>'required',
            'extension_price' => 'required'
        ]);


        $imageUploader = new ImageUploader();
        $imageUploader->handler($request->image, '/image/services/', 'SRVCS');

           $service = Service::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'init_payment' => $request->initPayment,
            'image' => $imageUploader->getURL(),
            'time_slot' => $request->timeSlot,
            'session_time' => $request->session_time,
            'extension_time' => $request->extension_time,
            'extension_price' => $request->extension_price
           ]);


           return back()->with(['message' => 'Medical Service Added Successfully']);
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
