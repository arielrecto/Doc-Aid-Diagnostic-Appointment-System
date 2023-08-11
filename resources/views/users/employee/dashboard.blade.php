<x-app-layout>
    <div class="w-full flex h-screen">
        <x-employee.sidebar/>
        <div class="flex-grow">
            <div>
                <x-employee.navbar/>
            </div>
            <div class="px-2 pt-5">
                <div class="grid grid-cols-2 grid-flow-row gap-5">
                    <div class="w-full h-32 bg-accent shadow-sm duration-700 hover:shadow-lg rounded-lg">
                        total appointment today
                    </div>
                    <div class="w-full h-32 bg-base-100 shadow-sm duration-700 hover:shadow-lg rounded-lg">
                        total appointment in this month
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
