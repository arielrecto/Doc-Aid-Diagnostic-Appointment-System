<?php

namespace App\Http\Controllers\Admin;

use App\Models\Service;
use App\Models\TimeSlot;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Utilities\ImageUploader;
use PhpParser\Node\Expr\FuncCall;
use App\Http\Controllers\Controller;
use App\Models\Day;
use App\Models\ServiceAssignment;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $query = $request->query();

        $builder = Service::whereAvailability('ACTIVE');

        if ($query['availability'] ?? false) {
            $builder = Service::where(function ($q) use ($query) {
                $q->where('availability', '=', $query['availability']);
            });
        }

        $services = $builder->paginate(4);
        $total = Service::whereAvailability('ACTIVE')->count();
        $totalInactiveServices = Service::totalBaseOnAvailability('INACTIVE');

        return view('users.admin.Services.index', compact(['services', 'total', 'totalInactiveServices']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {


        $days = Day::get()->toJson();



        return view('users.admin.Services.create', compact(['days']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $days = json_decode($request->service_days);

        $data = $request->validate([
            'image' => 'required',
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'initPayment' => 'required',
            'session_time' => 'required',
            'extension_time' => 'required',
            'extension_price' => 'required',
            'service_days' => 'required'
        ]);

        $imageUploader = new ImageUploader();
        $imageUploader->handler($request->image, '/image/services/', 'SRVCS');

        $service = Service::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'init_payment' => $request->initPayment,
            'image' => $imageUploader->getURL(),
            //'time_slot' => $request->timeSlot,
            'session_time' => $request->session_time,
            'extension_time' => $request->extension_time,
            'extension_price' => $request->extension_price
        ]);

        TimeSlot::create([
            'slots' => $request->timeSlot,
            'service_id' => $service->id
        ]);



        collect($days)->map(function($day) use ($service){
            $day_data = Day::find($day->id);
           $day_data->services()->attach($service);
        });


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

        $days = Day::get()->toJson();

        return view('users.admin.Services.edit', compact(['service', 'days']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {


        $service = Service::find($id);


        $days = json_decode($request->service_days);





        if ($request->image !== null) {
            $imageUploader = new ImageUploader();
            $imageUploader->handler($request->image, '/image/services/', 'SRVCS');
        }



        $timeSLot = TimeSlot::where('service_id', $service->id)->latest()->first();

        $timeSLot->update([
            'slots' => $request->timeSlot
        ]);


        $service->update([
            'name' => $request->name ?? $service->name,
            'description' => $request->description ?? $service->description,
            'price' => $request->price ?? $service->price,
            'init_payment' => $request->initPayment ?? $service->init_payment,
            'image' => $request->image !== null ? $imageUploader->getURL() : $service->image,
            //'time_slot' => $request->timeSlot ?? $request->time_slot,
            'session_time' => $request->session_time ?? $service->session_time,
            'extension_time' => $request->extension_time ?? $service->extension_time,
            'extension_price' => $request->extension_price ?? $service->extension_price
        ]);






        // $service_days = $service->days;


        // collect($service_days)->map(function($service_day) use ($days ){

        // });



        $service_days = $service->days;


        collect($days)->map(function($day) use($service, $service_days) {
            collect($service_days)->map(function($service_day) use ($day, $service){
                if($service_day !== $day->name){
                    $service->days()->detach($service_day->id);
                    return;
                }
            });
            $service->days()->attach($day->id);
        });

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
    public function availability(Request $request, $id)
    {

        $service = Service::find($id);



        $service->update([
            'availability' => $request->availability
        ]);


        return back();
    }
}
