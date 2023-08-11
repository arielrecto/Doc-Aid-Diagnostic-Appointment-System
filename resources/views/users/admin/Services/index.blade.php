<x-app-layout>
    <div class="flex">
        <div>
            <x-admin-siderbar></x-admin-siderbar>
        </div>
        <div class="flex-grow flex flex-col gap-2">
            <x-admin-navbar>
                <x-slot name="sample">
                    {{ __('Services') }}
                </x-slot>
            </x-admin-navbar>
            <div class="flex flex-col gap-2 px-5">
                <div class="w-full grid grid-cols-2 grid-flow-row gap-4">
                    <div class="w-full bg-accent h-32 rounded-lg shadow-sm hover:shadow-lg duration-700">
                        total of services
                    </div>
                    <div class="w-full bg-base-100 h-32 rounded-lg shadow-sm hover:shadow-lg duration-700">
                        total of not availble services
                    </div>
                </div>
                <div class="flex flex-row-reverse">
                    <a href="{{route('admin.services.create')}}">
                        <button class="btn btn-accent capitalize">Add new services</button>
                    </a>
                </div>
                <div class="bg-base-100 rounded-lg shadow-sm hover:shadow-lg duration-700">
                    <div class="overflow-x-auto">
                        <table class="table table-zebra">
                            <!-- head -->
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Name</th>
                                    <th>Job</th>
                                    <th>Favorite Color</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- row 1 -->
                                <tr>
                                    <th>1</th>
                                    <td>Cy Ganderton</td>
                                    <td>Quality Control Specialist</td>
                                    <td>Blue</td>
                                </tr>
                                <!-- row 2 -->
                                <tr>
                                    <th>2</th>
                                    <td>Hart Hagerty</td>
                                    <td>Desktop Support Technician</td>
                                    <td>Purple</td>
                                </tr>
                                <!-- row 3 -->
                                <tr>
                                    <th>3</th>
                                    <td>Brice Swyre</td>
                                    <td>Tax Accountant</td>
                                    <td>Red</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
