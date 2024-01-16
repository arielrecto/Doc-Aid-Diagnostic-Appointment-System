<x-app-layout>
    <div class="main-screen">
        <!-- <x-responsive-indicator/> -->
        <x-admin.sidebar-new />

        <div class="main-content" x-data="dashboard">
            <x-admin.navbar-new />

            @if (Route::is('admin.dashboard'))
                <div class="panel">
                    <div class="flex-grow flex flex-col gap-2">
                        <h1 class="page-title">
                            Welcome back, admin
                        </h1>
                        <p class="text-gray-500">
                            DATA PLACEHOLDER
                        </p>
                    </div>
                </div>
            @endif


            <div class="h-4/6 overflow-auto panel">
                <div class="grid grid-cols-3 grid-flow-row gap-2 ">
                    <div class="panel h-36 bg-accent">
                        <div class="w-full text-xl font-semibold capitalize text-white flex gap-2">
                            <i class="fi fi-rr-stats"></i>
                            <span>
                                sales
                            </span>
                        </div>

                        <span class="text-6xl font-bold text-white truncate max-w-[250px]">
                            &#8369 {{ $sales }}
                        </span>
                    </div>
                    <div class="panel h-36 bg-secondary-focus">
                        <div class="w-full text-xl font-semibold capitalize text-white flex gap-2">
                            <i class="ri-book-mark-line"></i>
                            <span>
                                Pending Appointments
                            </span>
                        </div>

                        <span class="text-6xl font-bold text-white truncate max-w-[250px]">
                            {{ $totalPendingAppointment }}
                        </span>
                    </div>
                    <div class="panel h-36 bg-warning">
                        <div class="w-full text-xl font-semibold capitalize text-white flex gap-2">
                            <i class="ri-book-mark-line"></i>
                            <span>
                                Total Services
                            </span>
                        </div>

                        <span class="text-6xl font-bold text-white truncate max-w-[250px]">
                            {{ $totalServices }}
                        </span>
                    </div>
                </div>

                <div class="w-full flex py-5 gap-2" x-init="barChartTwo({{ $monthlyTotal }})">
                    <div id="barChart" class="flex-grow rounded-lg p-2 shadow-md border-2 border-secondary-focus">

                    </div>
                    <div class="w-1/3 rounded-lg shadow-md p-2" x-init="calendar({{ $calendarAppointment }})">
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
                                    <th>No. Service</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                @forelse ($appointments as $appointment)
                                    <tr>
                                        <th>{{ $appointment->id }}</th>
                                        <th>{{ $appointment->patient }}</th>
                                        <td>{{ $appointment->subscribeServices()->count() }}</td>
                                        <td>{{ date('M-d-Y', strtotime($appointment->date)) }}</td>
                                        <td>
                                            <a
                                                href="{{ route('admin.appointment.show', ['appointment' => $appointment->id]) }}">
                                                <button class="text-blue-500 text-xs hover:scale-105 duration-700">
                                                    <i class="fi fi-rr-eye hover:font-bold"></i>
                                                </button>
                                            </a>
                                        </td>
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
                                    <th>No. Service</th>
                                    <th>Date</th>
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
                    barChartTwo(data) {
                        const monthlyData = Object.keys(data).map(item => ({
                            month: item,
                            total: data[item]
                        }))

                        console.log(monthlyData);
                        const totalData = monthlyData.map(item => item.total);
                        const totalLabel = monthlyData.map(item => item.month);
                        console.log(totalData)


                        var options = {
                            series: [{
                                name: 'Sales',
                                data: [...totalData]
                            }],
                            annotations: {
                                points: [{
                                    x: 'Bananas',
                                    seriesIndex: 0,
                                    label: {
                                        borderColor: '#775DD0',
                                        offsetY: 0,
                                        style: {
                                            color: '#fff',
                                            background: '#775DD0',
                                        },
                                        text: 'Bananas are good',
                                    }
                                }]
                            },
                            chart: {
                                height: 350,
                                type: 'bar',
                            },
                            plotOptions: {
                                bar: {
                                    borderRadius: 10,
                                    columnWidth: '50%',
                                }
                            },
                            dataLabels: {
                                enabled: false
                            },
                            stroke: {
                                width: 2
                            },

                            grid: {
                                row: {
                                    colors: ['#fff', '#f2f2f2']
                                }
                            },
                            xaxis: {
                                labels: {
                                    rotate: -45
                                },
                                categories: [...totalLabel],
                                tickPlacement: 'on'
                            },
                            yaxis: {
                                title: {
                                    text: 'Total Sales',
                                },
                            },
                            fill: {
                                type: 'gradient',
                                gradient: {
                                    shade: 'light',
                                    type: "horizontal",
                                    shadeIntensity: 0.25,
                                    gradientToColors: undefined,
                                    inverseColors: true,
                                    opacityFrom: 0.85,
                                    opacityTo: 0.85,
                                    stops: [50, 0, 100],
                                },
                            }
                        };

                        var chart = new ApexCharts(document.querySelector("#barChart"), options);
                        chart.render();
                    },
                    calendar(data) {

                        console.log(data);
                        const calendarElement = document.getElementById('calendar');
                        const calendar = new FullCalendar.Calendar(calendarElement, {
                            initialView: 'dayGridMonth',
                            events: this.calendarEventsMapping(data)
                        })
                        calendar.render()
                    },
                    calendarEventsMapping(eventData) {
                        const appointmentsPerDay = this.countEventPerDay(eventData)


                        const dataEvents = Object.keys(appointmentsPerDay).map(event => ({
                            title: `${appointmentsPerDay[event]} Appointment`,
                            start: new Date(event),
                            end: new Date(event),
                            allDay: true
                        }));

                        console.log(dataEvents)
                        return dataEvents
                    },
                    countEventPerDay(eventData) {
                        const appointmentsPerDay = {};

                        eventData.forEach(event => {
                            const dateKey = new Date(event.date).toISOString().split('T')[0];

                            if (appointmentsPerDay[dateKey]) {
                                appointmentsPerDay[dateKey]++;
                            } else {
                                appointmentsPerDay[dateKey] = 1;
                            }
                        });

                        return appointmentsPerDay;
                    }
                }
            }
        </script>
    @endpush
</x-app-layout>
