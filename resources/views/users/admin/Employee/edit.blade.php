<x-app-layout>
    <div class="main-screen">
        <x-admin.sidebar-new />

        <div class="main-content">
            <x-admin.navbar-new />

            @if (Session::has('rejected'))
                <div class="panel-error">
                    <span>
                        CODE ERROR - Lorem ipsum dolor sit amet consectetur adipisicing elit. Blanditiis, dolor?
                    </span>
                </div>
            @endif

            @if (Session::has('approved'))
                <div class="panel-success">
                    <span>
                        CODE SUCCESS - Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptate, voluptatum?
                    </span>
                </div>
            @endif

            @if (Session::has('message'))
                <div class="panel-success">
                    <span>{{ Session::get('message') }}</span>
                </div>
            @endif

            <div class="panel overflow-y-auto">
                <h1 class="page-title">Edit Employee</h1>
                <div class="h-auto flex flex-col gap-2 rounded p-4">
                    <form action="{{ route('admin.employee.update', ['employee' => $employee->id]) }}" method="post">
                        @csrf

                        @method('put')

                        <div class="flex flex-col space-y-5 w-full">
                            <div class="flex flex-col gap-2">
                                <label for="" class="text-sm text-gray-500">Email</label>
                                <input type="email" class="input input-accent w-full" placeholder="{{$employee->email}}"
                                    name="email">
                                @if ($errors->has('email'))
                                    <p class="text-xs text-error">{{ $errors->first('email') }}</p>
                                @endif
                            </div>
                            <div class="flex flex-col gap-2">
                                <label for="" class="text-sm text-gray-500">Password</label>
                                <input type="password" class="input input-accent w-full" placeholder="Password"
                                    name="password">
                                @if ($errors->has('password'))
                                    <p class="text-xs text-error">{{ $errors->first('password') }}</p>
                                @endif
                            </div>
                            <div class="flex flex-col gap-2">
                                <label for="" class="text-sm text-gray-500">Confirm Password</label>
                                <input type="password" class="input input-accent w-full" placeholder="Confirm Password"
                                    name="password_confirmation">
                            </div>
                        </div>
                        <div class="grid grid-cols-3 grid-flow-row gap-5">
                            <div class="flex flex-col gap-2">
                                <label for="" class="capitalize text-sm text-gray-500">last name</label>
                                <input type="text" name="last_name" class="input input-accent w-full" @change="checkLastName($event)"
                                    oninput="this.value = this.value.replace(/[0-9]/g, '');" placeholder="{{$employee->profile->last_name}}">
                                @if ($errors->has('last_name'))
                                    <p class="text-xs text-error">{{ $errors->first('last_name') }}</p>
                                @endif
                            </div>
                            <div class="flex flex-col gap-2">
                                <label for="" class="capitalize text-sm text-gray-500">first name</label>
                                <input type="text" name="first_name" class="input input-accent w-full"
                                    oninput="this.value = this.value.replace(/[0-9]/g, '');" placeholder="{{$employee->profile->first_name}}">
                                @if ($errors->has('first_name'))
                                    <p class="text-xs text-error">{{ $errors->first('first_name') }}</p>
                                @endif
                            </div>
                            <div class="flex flex-col gap-2">
                                <label for="" class="capitalize text-sm text-gray-500">middle name <span
                                        class="text-xs gray-400">- optional</span></label>
                                <input type="text" name="middle_name" class="input input-accent w-full"
                                    oninput="this.value = this.value.replace(/[0-9]/g, '');" placeholder="{{ $employee->profile->middle_name}}">
                            </div>
                        </div>
                        {{-- <div class="flex flex-col gap-2">
                            <label for="" class="text-sm text-gray-500">Full Name</label>
                            <input type="text" class="input input-accent w-full" x-model="fullName" :placeholder="fullName"
                                name="name">
                            @if ($errors->has('name'))
                                <p class="text-xs text-error">{{ $errors->first('name') }}</p>
                            @endif
                        </div> --}}
                        <div class="grid grid-cols-3 grid-flow-row gap-5">
                            <div class="flex flex-col gap-2">
                                <label for="" class="capitalize text-sm text-gray-500">Age</label>
                                <input type="text" class="input input-accent w-full" name="age"
                                    placeholder="Age">
                                @if ($errors->has('age'))
                                    <p class="text-xs text-error">{{ $errors->first('age') }}</p>
                                @endif
                            </div>
                            <div class="flex flex-col gap-2">
                                <label for="" class="capitalize text-sm text-gray-500">Birthdate</label>
                                <input type="date" class="input input-accent w-full" name="birthdate"
                                    placeholder="birthdate">
                                @if ($errors->has('birthdate'))
                                    <p class="text-xs text-error">{{ $errors->first('birthdate') }}</p>
                                @endif
                            </div>
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
                        <div class="flex flex-col gap-2">
                            <label for="" class="capitalize text-sm text-gray-500">Street</label>
                            <input type="text" name="street" class="input input-accent w-full"
                                placeholder="Street">
                            @if ($errors->has('street'))
                                <p class="text-xs text-error">{{ $errors->first('street') }}</p>
                            @endif
                        </div>
                        <div class="grid grid-cols-3 grid-flow-row gap-5" x-data="phLocation">
                            <div class="flex flex-col gap-2">
                                <label for="" class="capitalize text-sm text-gray-500">Region</label>
                                <select class="select select-accent w-full" name="region" id="region-dropdown"
                                    @change="fillSelectionCityByRegion($event)">
                                    <template x-for="region in regions" :key="region.code">
                                        <option :value="region.name"><span x-text="region.regionName"></span> <span
                                                x-text=region.name></span></option>
                                    </template>
                                </select>
                                @if ($errors->has('region'))
                                    <p class="text-xs text-error">{{ $errors->first('region') }}</p>
                                @endif
                            </div>
                            <div class="flex flex-col gap-2">
                                <label for="" class="capitalize text-sm text-gray-500">City</label>
                                <select class="select select-accent w-full" name="municipality" id="region-dropdown"
                                    @change="fillSelectionBarangayByCity($event)">
                                    <template x-if="barangays.length === 0">
                                        <option selected disabled>Select City</option>
                                    </template>
                                    <template x-for="city in cities" :key="city.code">
                                        <option :value="city.name"><span x-text="city.name"></span></option>
                                    </template>
                                </select>
                                @if ($errors->has('municipality'))
                                    <p class="text-xs text-error">{{ $errors->first('municipality') }}</p>
                                @endif
                            </div>
                            <div class="flex flex-col gap-2">
                                <label for="" class="capitalize text-sm text-gray-500">Barangay</label>
                                <select class="select select-accent w-full" name="barangay" id="region-dropdown">
                                    <template x-if="barangays.length === 0">
                                        <option selected disabled>Select Barangay</option>
                                    </template>

                                    <template x-for="barangay in barangays" :key="barangay.code">
                                        <option :value="barangay.name"><span x-text="barangay.name"></span></option>
                                    </template>
                                </select>
                                @if ($errors->has('barangay'))
                                    <p class="text-xs text-error">{{ $errors->first('barangay') }}</p>
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
                                <label for="" class="capitalize text-sm text-gray-500">Contact No. <span>ex :
                                        09123456789 </span></label>
                                <input type="text" name="contact_no" class="input input-accent input-sm w-full"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                    maxlength="11" placeholder="Ex: 09123456789">
                            </div>
                        </div>
                        <div class="flex justify-end p-2">
                            <button class="btn-generic btn-sm uppercase">Update Employee</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
