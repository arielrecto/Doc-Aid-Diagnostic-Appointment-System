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
    public function index()
    {
        $services = Service::paginate(4);
        $total = Service::total();
        return view('users.admin.Services.index', compact(['services', 'total']));
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
            'initPayment' => 'required'
        ]);


        $imageUploader = new ImageUploader();
        $imageUploader->handler($request->image, '/image/services/', 'SRVCS');

           $service = Service::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'init_payment' => $request->initPayment,
            'image' => $imageUploader->getURL()
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
