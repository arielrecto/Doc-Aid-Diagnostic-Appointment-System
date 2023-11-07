<x-app-layout>
    <div class="main-screen">
        <x-patient-siderbar />
        <div class="flex w-full h-full">
            <div class="main-content">
                <x-patient.navbar />

                <div class="fl  ex flex-col gap-2 p-5 w-full h-full relative panel" x-data="familyIndex">
                    <div class="w-full h-24">
                        @if (Auth::user()->family === null)
                            <h1 class="w-full flex flex-row-reverse p-2">
                                <button class="btn btn-accent" @click="openToggle">Add Family</button>
                            </h1>
                        @else
                            <h1 class="text-lg font-bold capitalize">
                                family - {{ Auth::user()->family->name }}
                            </h1>
                        @endif
                    </div>
                    <div class="w-full shadow-sm hover:shadow-lg rounded-lg duration-700 h-96 flex flex-col gap-2">

                        @if (Auth::user()->family !== null)
                            <div class="w-full flex justify-end p-2">
                                <a href="{{ route('patient.family.members.create') }}">
                                    <button class="btn btn-accent">Add Family Member</button>
                                </a>
                            </div>
                        @endif
                        <div class="overflow-x-auto">
                            <table class="table">
                                <!-- head -->
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Sex</th>
                                        <th>Relationship</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- row 1 -->
                                    @forelse ($members as $member)
                                        <tr class="">
                                            <th>
                                                <a class="venobox" href="{{ $member->image }}" target="_blank">
                                                    <img src="{{ $member->image }}" alt="" srcset=""
                                                        class="object h-10 w-10 object-center">
                                                </a>
                                            </th>
                                            <td class="capitalize">{{ $member->full_name }}</td>
                                            <td>{{ $member->email }}</td>
                                            <td>{{ $member->sex }}</td>
                                            <td>{{ $member->relationship }}</td>
                                            <td><a
                                                    href="{{ route('patient.family.members.show', ['member' => $member->id]) }}">
                                                    <i class="fi fi-rr-eye text-primary"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td>No Family Member</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="h-64 w-1/2 absolute z-10 top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 shadow-lg rounded-lg bg-base-100"
                        x-show="toggle">
                        <form action="{{ route('patient.family.store') }}" method="post"
                            class="h-full w-full p-2 flex flex-col space-y-5">
                            @csrf
                            <h1 class="text-lg text-center w-full font-bold">Add Family</h1>
                            <div class="flex flex-col gap-2">
                                <label for="" class="text-sm font-semibold text-gray-500">Family Name</label>
                                <input type="text" placeholder="name" name="name"
                                    class="input input-bordered input-success w-full rounded-lg" />
                                @if (Session::has('message'))
                                    <p class="w-full text-xs text-error p-2">{{ Session::get('message') }}</p>
                                @endif
                            </div>
                            <div class="flex p-2 justify-end">
                                <button class="btn btn-accent">ADD</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('js')
        <script>
            function familyIndex() {
                return {
                    toggle: false,
                    openToggle() {
                        this.toggle = !this.toggle
                    }
                }
            }
        </script>
    @endpush
</x-app-layout>
