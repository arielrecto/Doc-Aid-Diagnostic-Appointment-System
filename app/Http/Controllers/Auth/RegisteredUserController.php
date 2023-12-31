<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Models\Family;
use App\Models\FamilyMember;
use App\Notifications\FamilyMemberCreatedAnAccount;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', 'regex:/^(?=.*[a-zA-Z])(?=.*\d)(?=.*[!@#$%^&*()_+])[A-Za-z\d!@#$%^&*()_+]{8,}$/' , Rules\Password::defaults()],
        ]);

        $checkUserIsFamilyMember = FamilyMember::whereEmail($request->email)->first();

        if($checkUserIsFamilyMember !== null){
            $this->notifyFamilyMember($request->email);
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        $patientRole = Role::where('name', 'patient')->first();


        $user->assignRole($patientRole);


        return redirect(route('patient.dashboard'));
    }

    private function notifyFamilyMember(string $email){

        $family_member = FamilyMember::whereEmail($email)->first();

        $user = $family_member->family->user;

        $families = $user->family->members()->whereNot('email', $email)->get();


        $message  = [
            'introduction' => "{$family_member->first_name} {$family_member->last_name} is Created an account",
            'Date' =>  'Date: ' . now()->format('F-d-Y')
        ];

        foreach($families as $userFam){
            $userFam->notify(new FamilyMemberCreatedAnAccount($message));
        }

        $user->notify(new FamilyMemberCreatedAnAccount($message));
    }
}
