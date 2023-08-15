<x-app-layout>
    <div class="flex w-full h-screen max-h-screen overflow-hidden bg-base-100 gap-2">

        <x-admin.sidebar-new />

        <div class="flex-grow h-screen flex flex-col gap-2 px-4" x-data="dashboard">
            <x-admin.navbar-new />

            @if (Route::is('admin.dashboard'))
                <div class="w-full flex gap-2 text-primary bg-white p-4 rounded-lg shadow-md">
                    <div class="flex-grow flex flex-col gap-2">
                        <h1 class="font-bold text-4xl">
                            Welcome back, admin
                        </h1>
                        <p class="text-gray-500">
                            update last 7 days
                        </p>
                    </div>
                </div>
            @endif


            <div class="w-full flex flex-col p-4 bg-white shadow-lg h-4/6 overflow-auto shadow-md rounded-lg">
                <div class="grid grid-cols-3 grid-flow-row gap-2 ">
                    <div class="w-full h-36 bg-accent rounded-lg shadow-sm">
                    </div>
                    <div class="w-full h-36 bg-secondary-focus rounded-lg shadow-md">
                    </div>
                    <div class="w-full h-36 bg-warning shadow-md rounded-lg">
                    </div>
                </div>

                <div class="w-full flex py-5 gap-2" x-init="barChart()">
                    <div id="barChart"
                        class="flex-grow rounded-lg p-2 shadow-md border-2 border-secondary-focus">

                    </div>
                    <div class="w-1/4 rounded-lg shadow-md p-2"
                        x-init="calendar">
                        <div id="calendar" class="w-full text-xs h-full">

                        </div>
                    </div>
                </div>

                <div class="w-full rounded-lg shadow-md">
                    <div class="overflow-y-auto h-96">
                        <table class="table table-xs">
                            <thead class=" sticky ">
                                <tr>
                                    <th></th>
                                    <th>Patient</th>
                                    <th>Service</th>
                                    <th>Session Time</th>
                                    <th>location</th>
                                    <th>Last Login</th>
                                    <th>Favorite Color</th>
                                </tr>
                            </thead>
                            <tbody>

                                @forelse ($appointments as $appointment)
                                    <tr>
                                        <th>{{ $appointment->id }}</th>
                                        <th>{{ $appointment->patient }}</th>
                                        <td>{{ $appointment->service->name }}</td>
                                        <td>{{ $appointment->service->session_time }} min</td>
                                        <td>Canada</td>
                                        <td>12/16/2020</td>
                                        <td>Blue</td>
                                    </tr>
                                @empty
                                    <tr>

                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th>Patient</th>
                                    <th>Service</th>
                                    <th>Session Time</th>
                                    <th>location</th>
                                    <th>Last Login</th>
                                    <th>Favorite Color</th>
                                </tr>
                            </tfoot>
                        </table>
                        {{ $appointments->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>



    @push('js')
        <script>
            function dashboard() {
                return {
                    barChart() {

                        var options = {
                            series: [{
                                name: "sales",
                                data: [{
                                    x: '2019/01/01',
                                    y: 400
                                }, {
                                    x: '2019/04/01',
                                    y: 430
                                }, {
                                    x: '2019/07/01',
                                    y: 448
                                }, {
                                    x: '2019/10/01',
                                    y: 470
                                }, {
                                    x: '2020/01/01',
                                    y: 540
                                }, {
                                    x: '2020/04/01',
                                    y: 580
                                }, {
                                    x: '2020/07/01',
                                    y: 690
                                }, {
                                    x: '2020/10/01',
                                    y: 690
                                }]
                            }],
                            chart: {
                                type: 'bar',
                                height: 380,
                            },
                            colors: "#04ABA3",
                            xaxis: {
                                type: 'category',
                                labels: {
                                    formatter: function(val) {
                                        // return "Q" + dayjs(val).quarter()
                                        return "Q" + dayjs(val)
                                    }
                                },
                                group: {
                                    style: {
                                        fontSize: '10px',
                                        fontWeight: 700,
                                    },
                                    groups: [{
                                            title: '2019',
                                            cols: 4
                                        },
                                        {
                                            title: '2020',
                                            cols: 4
                                        }
                                    ]
                                }
                            },
                            title: {
                                text: 'Grouped Labels on the X-axis',
                            },
                            tooltip: {
                                x: {
                                    formatter: function(val) {
                                        return "Q" + dayjs(val).quarter() + " " + dayjs(val).format("YYYY")
                                    }
                                }
                            },
                        };

                        var chart = new ApexCharts(document.querySelector("#barChart"), options);
                        chart.render();
                    },
                    calendar() {
                        const calendarElement = document.getElementById('calendar');
                        const calendar = new FullCalendar.Calendar(calendarElement, {
                            initialView: 'dayGridMonth'
                        })
                        calendar.render()
                    }
                }
            }
        </script>
    @endpush
</x-app-layout>
