<x-app-layout>
    <div class="main-screen">

        <x-patient-siderbar />

        <div class="main-content w-5/6">

            <x-patient.navbar />


            <div class="panel overflow-y-auto" x-data="profile">
                <div class="w-full h-full shadow-sm hover:shadow-lg duration-700">
                    <form action="{{ route('patient.profile.update',['profile' => $profile->id]) }}" method="post"
                        class="p-5 flex flex-col gap-5 w-full h-full" enctype="multipart/form-data">
                        @method('put')
                        @csrf
                        <h1 class="text-lg font-semibold text-center w-full">Edit Personal Information</h1>
                        <div class="w-full flex justify-center items-center">
                            <div class="h-auto w-64 rounded-lg">
                                <div class="flex items-center justify-center w-full">
                                    <label for="dropzone-file"
                                        class="flex flex-col items-center justify-center w-full h-full border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50
                                        "
                                        x-show="image === null">
                                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                            <svg class="w-8 h-8 mb-4 text-gray-500 " aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                            </svg>
                                            <p class="mb-2 text-sm text-gray-500 "><span class="font-semibold">Click
                                                    to
                                                    upload</span> or drag and drop</p>
                                            <p class="text-xs text-gray-500 ">SVG, PNG, JPG or GIF
                                            </p>
                                        </div>
                                        <input id="dropzone-file" type="file" class="hidden" name="avatar"
                                            @change="previewImage($event)" />
                                    </label>
                                    <template x-if="image !== null">
                                        <label for="dropzone-file"
                                            class=" relative flex flex-col items-center justify-center w-full h-full border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50
                                        ">
                                            <img :src="image" class="w-full h-auto object object-center"
                                                alt="">
                                            <button
                                                class="bg-gray-200 opacity-25 rounded-full px-4 py-2 top-2 right-2 absolute hover:opacity-100 duration-700"
                                                @click="removeImage($event)">X</button>
                                        </label>
                                    </template>


                                </div>
                                @if ($errors->has('avatar'))
                                    <p class="text-xs text-error">{{ $errors->first('avatar') }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 grid-flow-row gap-5">
                            <div class="flex flex-col gap-2">
                                <label for="" class="capitalize text-sm text-gray-500">last name</label>
                                <input type="text" name="last_name" class="input input-accent w-full"
                                    oninput="this.value = this.value.replace(/[0-9]/g, '');" placeholder="Last Name">
                                @if ($errors->has('last_name'))
                                    <p class="text-xs text-error">{{ $errors->first('last_name') }}</p>
                                @endif
                            </div>
                            <div class="flex flex-col gap-2">
                                <label for="" class="capitalize text-sm text-gray-500">first name</label>
                                <input type="text" name="first_name" class="input input-accent w-full"
                                    oninput="this.value = this.value.replace(/[0-9]/g, '');" placeholder="First Name">
                                @if ($errors->has('first_name'))
                                    <p class="text-xs text-error">{{ $errors->first('first_name') }}</p>
                                @endif
                            </div>
                            <div class="flex flex-col gap-2">
                                <label for="" class="capitalize text-sm text-gray-500">middle name <span
                                        class="text-xs gray-400">- optional</span></label>
                                <input type="text" name="middle_name" class="input input-accent w-full"
                                    oninput="this.value = this.value.replace(/[0-9]/g, '');" placeholder="Middle Name">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 grid-flow-row gap-5">
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
                        <div class="grid grid-cols-1 md:grid-cols-3 grid-flow-row gap-5" x-data="phLocation">
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
                        <div class="grid grid-cols-1 md:grid-cols-3 grid-flow-row gap-5">
                            <div class="flex flex-col gap-2">
                                <label for="" class="capitalize text-sm text-gray-500">Contact No. <span>ex :
                                        09123456789 </span></label>
                                <input type="text" name="contact_no" class="input input-accent input-sm w-full"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                    maxlength="11" placeholder="Ex: 09123456789">
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

    @push('js')
        <script>
            function profile() {
                return {
                    image: null,
                    previewImage(e) {
                        const file = e.target.files[0]

                        reader = new FileReader()

                        reader.onload = function() {
                            this.image = reader.result


                        }.bind(this)

                        reader.readAsDataURL(file)

                    },
                    removeImage(e) {
                        e.preventDefault();
                        this.image = null
                    },

                }
            }
        </script>
    @endpush

</x-app-layout>
