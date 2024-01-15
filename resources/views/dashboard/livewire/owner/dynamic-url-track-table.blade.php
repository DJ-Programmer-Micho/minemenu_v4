<div>

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    @include('dashboard.livewire.owner.dynamic-url-form')
    <div class="my-4">
        <div class="d-flex justidy-content-between mb-4">
            <h2 class="text-lg font-medium mr-auto">
                <b class="text-uppercase text-white">{{__('Dynamic URLs Table')}}</b>
            </h2>
            <div class="">
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#createAd">{{__('Add New QR Code AD')}}</button>
                {{-- <button type="button" class="btn btn-info" wire:click="export('{{$planFilter_send}}','{{$searchFilter_send}}','{{$dateRange_send}}')">{{__('Print Report')}}</button> --}}
            </div>
        </div>
        <div class="row m-0 p-0">
            <h6 class=" font-medium col-12 col-lg-2">
                <label class="text-white">{{__('Date Select')}}</label>
                <div id="reportrange"  class="form-control bg-white text-black" style="cursor: pointer; padding: 5px 10px; border: 1px solid #333; width: 100%">
                    <i class="fa fa-calendar"></i>&nbsp;
                    <span></span> <i class="fa fa-caret-down"></i>
                </div>
            </h6>

                <h6 class=" font-medium col-12 col-lg-2">
                    <label class="text-white">{{__('Name Search')}}</label>
                    <input type="search" wire:model="searchFilter" class="form-control bg-white text-black w-100"
                        placeholder="Search..." style="width: 250px; border: 1px solid var(--primary)" />
                </h6>

                <h6 class=" font-medium col-12 col-lg-2">
                    <label class="text-white">{{__('Plan Select')}}</label>
                    <select wire:model="planFilter" class="form-control bg-white text-black w-100">
                        <option value="" default>All</option>
                        <option value="1">DEMO</option>
                        <option value="2">1 - MONTH</option>
                        <option value="3">6 - MONTHs</option>
                        <option value="4">12 - MONTHs</option>
                    </select>
                </h6>


           
                <h6 class=" font-medium col-12 col-lg-2">
                    <label class="text-white">{{__('Reset Filter')}}</label>
                    <button class="btn btn-dark form-control py-0" wire:click="resetFilter()">Reset</button>
                </h6>



 
        </div>
        </div>
        {{-- @if (session()->has('message'))
        <h5 class="alert alert-success">{{ session('message') }}</h5>
        @endif --}}
        <div class="table-responsive">
            <table class="table table-striped table-hover table-sm table-dark">
                <thead>
                    <tr>
                        @foreach ($cols_th as $col )
                        <th>{{ __($col) }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @forelse ($items as $index => $item )
                    <tr>
                        @foreach ($cols_td as $col)
                        <td class="align-middle">
                            @if($col === 'id')
                                {{$index +1 }}
                                {{-- @elseif ($col === 'name')
                                <span>{{ $item->name }}</span>
                                @elseif ($col === 'status')
                                <span class="{{ $item->status == 1 ? 'text-success' : 'text-danger' }}">
                                   <b>{{ $item->status == 1 ? __('Active') : __('Non-Active') }}</b>
                                </span>
                                @elseif ($col === 'vision')
                                <span class="{{ $item->vision == 1 ? 'text-info' : 'text-danger' }}">
                                   <b>{{ $item->vision == 1 ? __('Show') : __('Hide') }}</b>
                                </span> --}}
                                {{-- @elseif ($col === 'new_plan_id') <!-- Add this condition -->
                                <span class="text-success">
                                    <b>{{ $planNames[$item->new_plan_id] }}</b>
                                </span> --}}
                                @elseif ($col === 'Action') <!-- Add this condition -->
                                {{-- <button class="btn btn-info mx-1 mb-1" onclick="checkBusiness('{{$general_link.$item->user->name}}')"><i class="far fa-eye"></i></button> --}}
                                <button class="btn btn-primary m-1" type="button" data-toggle="modal" data-target="#updateAd" wire:click="editAd({{ $item->id }})" ><i class="far fa-edit"></i></button>
                                <a href="{{ $item->redirect_url }}" target="_blank" rel="noopener noreferrer">
                                    <button class="btn btn-secondary mx-1"><i class="fas fa-link"></i></button>
                                </a>
                                <button type="button" data-toggle="modal" data-target="#deleteAd" wire:click="deleteAd({{ $item->id }})" class="btn btn-danger m-1"><i class="far fa-trash-alt"></i></button>

                                @else
                                {{ $item->$col }}
                                @endif
                        </td>
                        @endforeach
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ count($cols_th) + 1 }}">No Record Found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($items)
        <div class="dark:bg-gray-800 dark:text-white">
            {{ $items->links() }}
        </div>
        @endif

    </div>
</div>
</div>

<canvas id="lineChart"></canvas>
@php
    // dd($lineChartData);
@endphp
</div>

@push('datePicker')
    
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script type="text/javascript">
$(function() {
    var start =  moment().startOf('year');
    var end = moment().endOf('year');
    
    function cb(start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        // Update Livewire component property
        @this.set('dateRange', start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
        // Emit Livewire event
        @this.emit('dateRangeSelected');
    }

    $('#reportrange').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
           'This Year': [moment().startOf('year'), moment().endOf('year')]
        }
    }, cb);
    cb(start, end);

});
</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  document.addEventListener('livewire:load', function () {
        var adsChartData;

        // Define chart options
        var chartLineOptions = {
            maintainAspectRatio: true,
            layout: {
                padding: {
                    left: 10,
                    right: 25,
                    top: 25,
                    bottom: 0,
                },
            },
            showLines: true,
            scales: {
                x: { // Use object syntax for scales
        gridLines: {
            color: '#ffffff', // Set the grid lines color for the x-axis to white
            display: true,
            drawBorder: true,
        },
        ticks: {
            fontColor: "#ffffff", // Set the font color for x-axis ticks to white
        },
    },
    y: { // Use object syntax for scales
        maxTicksLimit: 5,
        padding: 10,
        color: "white",
        ticks: {
            fontColor: "#ffffff",
            maxTicksLimit: 12,
            callback: function (value, index, values) {
                return value.toFixed(1);
            },
        },
        gridLines: {
            color: "rgb(234, 236, 244)",
            borderColor: "rgb(234, 236, 244)",
            drawBorder: true,
            borderDash: [2],
            borderDashOffset: [2],
        },
    },
            },
            legend: {
                labels: {
                    fontColor: "#fff",
                }
            },
            plugins: {
                colors: {
                    enabled: true,
                    forceOverride: true
                },
                tooltip: {
                    backgroundColor: "#333",
                    bodyFontColor: "#eee",
                    titleFontColor: "#eee",
                    borderColor: "#eee",
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: true,
                    intersect: true,
                    mode: "index",
                    caretPadding: 10,
                    callbacks: {
                        label: function (context) {
                            var label = context.dataset.label || "";
                            if (label) {
                                label += ": ";
                            }
                            if (context.parsed.y !== null) {
                                label += "QRC" + context.parsed.y.toFixed(0);
                            }
                            return label;
                        },
                    },
                },
            },
        };

        function createOrUpdateLineChart(lineChartData) {
            if (adsChartData) {
                adsChartData.destroy();
            }

            var dates = Object.keys(lineChartData[0].data);
            var datasets = lineChartData.map(function (entry, index) {
                return {
                    label: entry.label,
                    data: Object.values(entry.data),
                    borderColor: getRandomColor(index), // Pass index for color control
                    backgroundColor: getRandomColor(index, true), // Pass index for color control
                    borderWidth: 2,
                    fill: true,
                };
            });

            // Create the line chart
            var ctx = document.getElementById("lineChart").getContext('2d');
            adsChartData = new Chart(ctx, {
                type: "line",
                data: {
                    labels: dates,
                    datasets: datasets,
                },
                options: chartLineOptions,
            });
        }

        // Initial chart creation
        createOrUpdateLineChart({!! json_encode($lineChartData) !!});

        document.addEventListener('chartDataCountryUpdated', function ($asd) {
            createOrUpdateLineChart($asd.detail); // Update the chart when data changes
        });

        function getRandomColor(index) {
            var customHexColors = [
                '#fd7e14aa',
                '#4e73dfaa',
                '#6f42c1aa',
                '#e83e8caa',
                '#e74a3baa',
                '#f6c23eaa',
                '#1cc88aaa',
                '#36b9ccaa',
                // Add more colors as needed
            ];

            return customHexColors[index % customHexColors.length];
        }
    });
    </script>
@endpush
{{-- @endpush --}}