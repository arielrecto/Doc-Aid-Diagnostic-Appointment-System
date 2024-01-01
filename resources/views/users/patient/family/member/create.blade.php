<x-app-layout>
    <div class="main-screen">
        <x-patient-siderbar/>
        <div class="main-content">
            <x-patient.navbar />
            <div class="w-full flex-grow flex flex-col gap-2 h-full panel overflow-y-auto">
                <div class="flex flex-col gap-2 p-5 w-full h-full relative">
                   @if (Session::has('message'))
                   <div class="alert alert-success">
                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <span>{{Session::get('message')}} !</span>
                  </div>
                   @endif
                    <div
                        class="w-full h-full flex flex-col gap-2 rounded-lg shadow-sm hover:shadow-lg duration-700">
                        <form action="{{ route('patient.family.members.store') }}" method="post"
                            class="flex flex-col gap-2" enctype="multipart/form-data">
                            @csrf
                            <div class="w-full flex justify-center h-12 items-center border-b-2 border-gray-100">
                                <h1 class="text-base lg:text-lg font-semibold capitalize">Family Member Information</h1>
                            </div>
                            <div class="w-full h-full flex flex-col space-y-2 md:space-y-5 lg:space-y-10 lg:p-5">
                                <div class="w-full flex flex-col gap-2">
                                    <label for="" class="capitalize text-xs lg:text-sm text-gray-500">profile</label>
                                    <input type="file" name="image" placeholder="image" class="file-input file-input-bordered file-input-accent w-full" />
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-3 grid-flow-row gap-2">
                                    <div class="flex flex-col gap-2 w-full">
                                        <label for="" class="capitalize text-xs lg:text-sm text-gray-500">last name</label>
                                        <input type="text" name="last_name" id=""
                                            class="input input-accent w-full" placeholder="Last Name">
                                        @if ($errors->has('last_name'))
                                            <p class="w-full text-xs text-error">{{ $errors->first('last_name') }}</p>
                                        @endif
                                    </div>
                                    <div class="flex flex-col gap-2 w-full">
                                        <label for="" class="capitalize text-xs md:text-sm text-gray-500">first
                                            name</label>
                                        <input type="text" name="first_name" id=""
                                            class="input input-accent w-full" placeholder="First Name">
                                        @if ($errors->has('first_name'))
                                            <p class="w-full text-xs text-error">{{ $errors->first('first_name') }}</p>
                                        @endif
                                    </div>
                                    <div class="flex flex-col gap-2 w-full">
                                        <label for="" class="capitalize text-xs md:text-sm text-gray-500">middle name -
                                            <span class="text-xs text-gray-400">optional</span></label>
                                        <input type="text" name="middle_name" id=""
                                            class="input input-accent w-full" placeholder="Middle">
                                    </div>
                                </div>
                                <div class="flex flex-col gap-2">
                                    <label for="" class="text-xs md:text-sm text-gray-500">Email</label>
                                    <input type="email" name="email" class="input input-accent w-full"
                                        placeholder="Email">
                                    @if ($errors->has('email'))
                                        <p class="w-full text-xs text-error">{{ $errors->first('email') }}</p>
                                    @endif
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-3 grid-flow-row gap-2">
                                    <div class="flex flex-col gap-2 w-full">
                                        <label for="" class="capitalize text-xs md:text-sm text-gray-500">birthdate</label>
                                        <input type="date" name="birthdate" id=""
                                            class="input input-accent w-full" placeholder="Contact #">
                                        @if ($errors->has('birthdate'))
                                            <p class="w-full text-xs text-error">The Contact Number is required</p>
                                        @endif
                                    </div>
                                    <div class="flex flex-col gap-2 w-full">
                                        <label for="" class="capitalize text-xs md:text-sm text-gray-500">Contact #</label>
                                        <input type="text" name="contact_no" id=""
                                            class="input input-accent w-full" placeholder="Contact #">
                                        @if ($errors->has('contact_no'))
                                            <p class="w-full text-xs text-error">The Contact Number is required</p>
                                        @endif
                                    </div>
                                    <div class="flex flex-col gap-2 w-full">
                                        <label for="" class="capitalize text-xs md:text-sm text-gray-500">Sex</label>
                                        <select class="select select-accent w-full" name="sex">
                                            <option disabled selected>Select Sex</option>
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                        </select>
                                        @if ($errors->has('sex'))
                                            <p class="w-full text-xs text-error">{{ $errors->first('sex') }}</p>
                                        @endif
                                    </div>
                                    <div class="flex flex-col gap-2 w-full">
                                        <label for=""
                                        class="capitalize text-xs md:text-sm text-gray-500">Relationship</label>
                                        <select class="select select-accent w-full max-w-xs"  name="relationship">
                                            <option disabled selected>Relationship ? </option>
                                            <option value="Grandmother">Grandmother</option>
                                            <option value="Husband">Husband</option>
                                            <option value="Mother">Mother</option>
                                            <option value="Grandparent">Grandparent</option>
                                            <option value="Sister">Sister</option>
                                            <option value="Aunt">Aunt</option>
                                            <option value="Cousins">Cousins</option>
                                            <option value="Brother">Brother</option>
                                            <option value="Father">Father</option>

                                          </select>
                                          @if ($errors->has('relationship'))
                                            <p class="w-full text-xs text-error">{{ $errors->first('relationship') }}</p>
                                        @endif

                                        {{-- <label for=""
                                            class="capitalize text-sm text-gray-500">Relationship</label>
                                        <input type="text" name="relationship" id=""
                                            class="input input-accent w-full" placeholder="Relationship">
                                        @if ($errors->has('relationship'))
                                            <p class="w-full text-xs text-error">{{ $errors->first('relationship') }}</p>
                                        @endif --}}
                                    </div>
                                </div>
                                <div class="w-full p-5 flex justify-end">
                                    <button class="btn btn-accent">Add </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('js')
    @endpush
</x-app-layout>
