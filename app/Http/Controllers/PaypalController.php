<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Service;
use App\Models\TimeSlot;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Enums\AppointmentStatus;
use App\Models\SubscribeService;
use Illuminate\Support\Facades\Auth;
use Srmklive\PayPal\Services\PayPal as PayPalClient;


class PaypalController extends Controller
{
    public function paypal(Request $request)
    {

        $user = Auth::user();



        $services = json_decode($request->service);


        $request->validate([
            'patient' => 'required',
            'date' => 'required',
            'patient' => 'required'
        ]);


        $otherDate = Carbon::createFromFormat('Y-m-d', $request->date);


        if ($otherDate->lt(now())) {
            return back()->with(['reject' => 'Appointment cannot be made since the selected date has passed.']);
        }

        $hasAppointment = Appointment::where('date', $request->date)
        ->where('user_id', $user->id)
        ->where('status', '!=',  AppointmentStatus::DONE->value)
        ->where('patient', $request->patient)
        ->latest()->first();

    if ($hasAppointment !== null) {

        $subscribeServices = $hasAppointment->subscribeServices;
        foreach ($subscribeServices as $s_service) {
            foreach ($services as $a_service) {
                if ($s_service->service_id === $a_service->id) {
                    return back()->with(['reject' => 'You have Already Appointment with same service and date']);
                }
            }
        }

        // if ($service->id === $subscribeService->service_id) {
        //     return back()->with(['reject' => 'You have Already Appointment with service and date']);
        // }
    }



        $provider = new PayPalClient();


        $provider->setApiCredentials(config('paypal'));

        $paypalToken = $provider->getAccessToken();

        $provider->setCurrency('PHP');


        $data = [
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('patient.paypal.success'),
                "cancel_url" => route('patient.paypal.cancel')
            ],
            "purchase_units" => [
                [
                    "amount" => [
                        "currency_code" => "PHP",
                        "value" => $request->total
                    ]
                ]
            ]
        ];

        $response =  $provider->createOrder($data);

        if (isset($response['id']) && $response['id'] !== null) {
            foreach ($response['links'] as $link) {
                if ($link['rel'] === 'approve') {


                    return redirect()->away($link['href'])->with([
                        'patient' => $request->patient,
                        'date' => $request->date,
                        'services' => $request->services,
                        'payment_type' => $request->payment_type,
                        'balance' => $request->balance,
                        'downpayment_total' => $request->downpayment_total,
                        'total' => $request->total
                    ]);
                }
            }
        } else {
            return redirect()->route('patient.paypal.cancel');
        }
    }
    public function success(Request $request)
    {

        $session = $request->session();

        $provider = new PayPalClient();
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request->token);

        $user = Auth::user();


        if (isset($response['id']) && $response['status'] === 'COMPLETED') {


            $appointment = Appointment::create([
                'date' => $session->get('date'),
                'patient' => $session->get('patient'),
                'type' => 'sample',
                'user_id' => $user->id,
                'receipt_number' => $response['purchase_units'][0]['payments']['captures'][0]['id'],
                'receipt_amount' => $response['purchase_units'][0]['payments']['captures'][0]['amount']['value'],
                'balance' => $session->get('balance'),
                'total' => $session->get('total'),
                'status' => 'pending',
                'payment_type' => $session->get('payment_type'),
                'is_extended' => $request?->is_extended === "on" ? true : false
            ]);


            Payment::create([
                'ref_number' => $response['purchase_units'][0]['payments']['captures'][0]['id'],
                'image' => 'paypal',
                'amount' => $response['purchase_units'][0]['payments']['captures'][0]['amount']['value'],
                'type' => 'fullpayment',
                'appointment_id' => $appointment->id
            ]);

            $services = json_decode($session->get('services'));


            collect($services)->map(function ($service) {
                $slot = $service->time_slot;
                $t_slot = TimeSlot::where('date', $slot->date)->first();
                if ($t_slot) {
                    $t_slot->update([
                        'slots' => json_encode($slot->slots),
                    ]);
                }
                TimeSlot::create([
                    'service_id' => $service->id,
                    'slots' => json_encode($slot->slots),
                    'date' => $slot->date
                ]);
            });

            $this->processServices($services, $appointment);
            return to_route('patient.appointment.create')->with([
                'message' => 'Appointment Set !'
            ]);
        } else {

            return redirect()->route('patient.paypal.cancel');
        }
    }
    public function cancel(Request $request)
    {

        return view('components.paypal.cancel');
    }
    private function processServices($services, $appointment)
    {
        collect($services)->map(function ($service) use ($appointment) {
            list($startTime, $endTime) = explode(" - ", $service->selectedSlot->duration);
            $startTime = Carbon::parse($startTime);
            $endTime = Carbon::parse($endTime);

            Service::find($service->id)->update(['time_slot' => json_encode($service->time_slot)]);


            SubscribeService::create([
                'start_time' => $startTime,
                'end_time' => $endTime,
                'service_id' => $service->id,
                'appointment_id' => $appointment->id
            ]);
        });
    }
}
