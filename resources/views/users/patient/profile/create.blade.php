<x-app-layout>
    <div class="flex w-full min-h-screen">
        <div class="w-64 h-full">
            <x-patient-siderbar />
        </div>
        <div class="w-full flex flex-col space-y-5">
            <div class="w-full">
                <x-patient.navbar>
                    <x-slot name="header">
                        {{ __('Profile - Create') }}
                    </x-slot>
                </x-patient.navbar>
            </div>
            <div class="w-full h-full flex justify-center items-center p-2">
                <div class="w-5/6 h-full bg-base-100 shadow-sm hover:shadow-lg duration-700">
                    <form action="{{ route('patient.profile.store') }}" method="post"
                        class="p-5 flex flex-col gap-5 w-full h-full" enctype="multipart/form-data">
                        @csrf
                        <h1 class="text-lg font-semibold text-center w-full">Personal Information</h1>
                        <div class="w-full flex justify-center items-center">
                            <div class="h-auto w-64 rounded-lg">
                                <div class="flex items-center justify-center w-full">
                                    <label for="dropzone-file"
                                        class="flex flex-col items-center justify-center w-full h-full border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50
                                        ">
                                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                            <svg class="w-8 h-8 mb-4 text-gray-500 " aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                            </svg>
                                            <p class="mb-2 text-sm text-gray-500 "><span class="font-semibold">Click to
                                                    upload</span> or drag and drop</p>
                                            <p class="text-xs text-gray-500 ">SVG, PNG, JPG or GIF
                                            </p>
                                        </div>
                                        <input id="dropzone-file" type="file" class="hidden" name="avatar" />
                                    </label>
                                </div>
                                @if ($errors->has('avatar'))
                                    <p class="text-xs text-error">{{ $errors->first('avatar') }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="grid grid-cols-3 grid-flow-row gap-5">
                            <div class="flex flex-col gap-2">
                                <label for="" class="capitalize text-sm text-gray-500">last name</label>
                                <input type="text" name="last_name" class="input input-accent w-full"
                                    placeholder="Last Name">
                                @if ($errors->has('last_name'))
                                    <p class="text-xs text-error">{{ $errors->first('last_name') }}</p>
                                @endif
                            </div>
                            <div class="flex flex-col gap-2">
                                <label for="" class="capitalize text-sm text-gray-500">first name</label>
                                <input type="text" name="first_name" class="input input-accent w-full"
                                    placeholder="First Name">
                                @if ($errors->has('first_name'))
                                    <p class="text-xs text-error">{{ $errors->first('first_name') }}</p>
                                @endif
                            </div>
                            <div class="flex flex-col gap-2">
                                <label for="" class="capitalize text-sm text-gray-500">middle name <span
                                        class="text-xs gray-400">- optional</span></label>
                                <input type="text" name="middle_name" class="input input-accent w-full"
                                    placeholder="Middle Name">
                            </div>
                        </div>
                        <div class="grid grid-cols-3 grid-flow-row gap-5">
                            <div class="flex flex-col gap-2">
                                <label for="" class="capitalize text-sm text-gray-500">Sex</label>
                                <select class="select select-accent w-full" name="gender">
                                    <option disabled selected>Select Sex</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                                @if ($errors->has('gender'))
                                    <p class="text-xs text-error">{{ $errors->first('gender') }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="grid grid-cols-2 grid-flow-row gap-5">
                            <div class="flex flex-col gap-2">
                                <label for="" class="capitalize text-sm text-gray-500">Street</label>
                                <input type="text" name="street" class="input input-accent w-full"
                                    placeholder="Street">
                                @if ($errors->has('street'))
                                    <p class="text-xs text-error">{{ $errors->first('street') }}</p>
                                @endif
                            </div>
                            <div class="flex flex-col gap-2">
                                <label for="" class="capitalize text-sm text-gray-500">Barangay</label>
                                <input type="text" name="barangay" class="input input-accent w-full"
                                    placeholder="Barangay">
                                @if ($errors->has('barangay'))
                                    <p class="text-xs text-error">{{ $errors->first('barangay') }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="grid grid-cols-3 grid-flow-row gap-5">
                            <div class="flex flex-col gap-2">
                                <label for="" class="capitalize text-sm text-gray-500">Municipality</label>
                                <input type="text" name="municipality" class="input input-accent w-full"
                                    placeholder="Municipality">
                                @if ($errors->has('municipality'))
                                    <p class="text-xs text-error">{{ $errors->first('municipality') }}</p>
                                @endif
                            </div>
                            <div class="flex flex-col gap-2">
                                <label for="" class="capitalize text-sm text-gray-500">Region</label>
                                <select class="select select-accent w-full" name="region">
                                    <option selected disabled>Select Region</option>
                                    <option value="Region 1 - Ilocos Region">Region 1 - Ilocos Region</option>
                                    <option value="Region II – Cagayan Valley">Region II – Cagayan Valley</option>
                                    <option value="Region III – Central Luzon">Region III – Central Luzon</option>
                                    <option value="Region IV‑A – CALABARZON">Region IV‑A – CALABARZON</option>
                                    <option value="MIMAROPA Region">MIMAROPA Region</option>
                                    <option value="Region V – Bicol Region">Region V – Bicol Region</option>
                                    <option value="Region VI – Western Visayas">Region VI – Western Visayas</option>
                                    <option value="Region IV‑A – CALABARZON">Region IV‑A – CALABARZON</option>
                                    <option value="Region VII – Central Visayas">Region VII – Central Visayas</option>
                                    <option value="Region VIII – Eastern Visayas">Region VIII – Eastern Visayas
                                    </option>
                                    <option value="Region IX – Zamboanga Peninsula">Region IX – Zamboanga Peninsula
                                    </option>
                                    <option value="Region XI – Davao Region">Region XI – Davao Region</option>
                                    <option value="Region XII – SOCCSKSARGEN">Region XII – SOCCSKSARGEN</option>
                                    <option value="Region XIII – Caraga">Region XIII – Caraga</option>
                                    <option value="NCR – National Capital Region">NCR – National Capital Region
                                    </option>
                                    <option value="CAR – Cordillera Administrative Region">CAR – Cordillera
                                        Administrative Region</option>
                                    <option value="BARMM – Bangsamoro Autonomous Region in Muslim Mindanao">BARMM –
                                        Bangsamoro Autonomous
                                        Region in Muslim Mindanao</option>
                                </select>
                                @if ($errors->has('region'))
                                    <p class="text-xs text-error">{{ $errors->first('region') }}</p>
                                @endif
                            </div>
                            <div class="flex flex-col gap-2">
                                <label for="" class="capitalize text-sm text-gray-500">Zip Code</label>
                                <input type="text" name="zip_code" class="input input-accent w-full"
                                    placeholder="Zip Code">
                                @if ($errors->has('zip_code'))
                                    <p class="text-xs text-error">{{ $errors->first('zip_code') }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="grid grid-cols-3 grid-flow-row gap-5">
                            <div class="flex flex-col gap-2">
                                <label for="" class="capitalize text-sm text-gray-500">Contact No.</label>
                                <input type="text" name="contact_no" class="input input-accent w-full"
                                    placeholder="Contact_no">
                                @if ($errors->has('contact_no'))
                                    <p class="text-xs text-error">{{ $errors->first('contact_no') }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="flex w-full p-5 justify-end">
                            <button class="btn btn-accent">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
