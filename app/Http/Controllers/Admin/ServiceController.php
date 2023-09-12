<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Utilities\ImageUploader;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\FuncCall;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $query = $request->query();

        $builder = Service::select('*');

        if ($query['availability'] ?? false) {
            $builder = Service::where(function ($q) use ($query) {
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
            'extension_time' => 'required',
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

        $service = Service::find($id);

        return view('users.admin.Services.show', compact(['service']));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $service = Service::find($id);
        return view('users.admin.Services.edit', compact(['service']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {


        $service = Service::find($id);

        if ($request->image !== null) {
            $imageUploader = new ImageUploader();
            $imageUploader->handler($request->image, '/image/services/', 'SRVCS');
        }

        $service->update([
            'name' => $request->name ?? $service->name,
            'description' => $request->description ?? $service->description,
            'price' => $request->price ?? $service->price,
            'init_payment' => $request->initPayment ?? $service->init_payment,
            'image' => $request->image !== null ? $imageUploader->getURL() : $service->image,
            'time_slot' => $request->timeSlot ?? $request->time_slot,
            'session_time' => $request->session_time ?? $service->session_time,
            'extension_time' => $request->extension_time ?? $service->extension_time,
            'extension_price' => $request->extension_price ?? $service->extension_price
        ]);

        return redirect(route('admin.services.show', ['service' => $service->id]))->with(['message' => 'Service is Updated !']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $service = Service::find($id);

        $service->delete();

        return redirect(route('admin.services.index'));
    }
    public function availability(Request $request, $id) {

        $service = Service::find($id);



        $service->update([
            'availability' => $request->availability
        ]);


        return back();
    }
}
