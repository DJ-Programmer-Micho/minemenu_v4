<!-- Begin Page Content -->
<div>
    <style>
        .dropdown-menu{
            transform: translate3d(-84px, 29px, 0px)!important;
        }
        
    </style>
    <!-- Page Heading -->
    {{-- <button wire:click="export" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
            class="fas fa-download fa-sm text-white-50"></i> </button> --}}
            <div class="d-sm-flex align-items-center justify-content-between my-4">
                <h1 class="h3 mb-0 text-white">Dashboard</h1>
                
                <div class="dropdown mr-1">
                    <button type="button" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false" data-offset="10,20">
                        {{ __('Generate Report') }}
                    </button>
                    <div class="dropdown-menu" style="background-color: #00000000; border: 0;">                        
                        @foreach ($filteredLocales as $locale)
                        <button wire:click="export('{{ $locale }}')" class="btn btn-primary w-100 my-1" style="color: #ffffff; background-color: #4e73df; border-color: #ffffff;">
                            <i class="fas fa-language fa-sm fa-fw mr-2"></i> {{ __(strtoupper($locale)) }}
                        </button>
                        @endforeach
                    </div>
                </div>
            </div>

        
        

    {{-- </div> --}}
    <div class="row">
        <!-- Earnings (Monthly) Card Example -->
       
        <div class="col-md-6">
            <div class="card shadow mb-4 dash-card">
                <div class="card-header py-3 dash-card">
                    <h6 class="m-0 font-weight-bold text-white">Top 5 Registers Actions</h6>
                </div>
                <div class="card-body ">
                    <div class="table-responsive mt-1">
                        <table class="table table-striped table-hover table-sm text-white">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Profile</th>
                                    <th>Resturant Name</th>
                                    <th>Old Status</th>
                                    <th>New Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody class="text-white"  wire:ignore>
                                @forelse ($sortedTopUsersInfo as $item)
                                <tr>
                                    <td class="align-middle">
                                        {{$item['user_id']}}
                                    </td>
                                    <td class="align-middle">
                                        <img src="{{$item['background_avatar_img'] }}" alt="{{ $item['background_avatar_img'] }}" width="50" style="border-radius: 50%;">
                                    </td>
                                    <td class="align-middle">
                                        {{$item['user_name']}}
                                    </td>
                                    <td class="align-middle">
                                        <span class="text-danger">
                                            <b>{{$item['old_plan_id'][1]}}</b>
                                         </span>
                                    </td>
                                    <td class="align-middle">
                                        <span class="text-success">
                                            <b>{{$item["new_plan_id"][1]}}</b>
                                         </span>
                                    </td>
                                    <td class="align-middle">{{$item['date_time']}}</td>
                                </tr>
                                @empty
                                NO DATA
                                @endforelse
                            </tbody>
                        </table>
            
                    </div>
                </div>
            </div>
        </div>
  <div class="col-md-6">
    <div class="row">
        <div class="col-xl-4 col-md-6 mb-2">
            <div class="card border-left-primary shadow h-100 py-2 dash-card">
                <div class="card-body ">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-white text-uppercase mb-1">
                                {{__('Demo Subscription')}}
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-white">{{$totalDemoUsers}}</div>
                        </div>
                        <div class="col-auto">
                            <script src="https://cdn.lordicon.com/bhenfmcm.js"></script>
                            <lord-icon
                                src="https://cdn.lordicon.com/eszyyflr.json"
                                trigger="loop"
                                delay="1000"
                                colors="primary:#4e73df,secondary:#fff"
                                state="hover-nodding"
                                style="width:48px;height:48px">
                            </lord-icon>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-4 col-md-6 mb-2">
            <div class="card border-left-success shadow h-100 py-2 dash-card">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                {{__('1-Month Subscription')}})</div>
                            <div class="h5 mb-0 font-weight-bold text-white">{{$totalOneMonthUsers}}</div>
                        </div>
                        <div class="col-auto">
                            <script src="https://cdn.lordicon.com/bhenfmcm.js"></script>
                            <lord-icon
                                src="https://cdn.lordicon.com/eszyyflr.json"
                                trigger="loop"
                                delay="1000"
                                state="hover-jump"
                                colors="primary:#1cc88a,secondary:#fff"
                                style="width:48px;height:48px">
                            </lord-icon>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-4 col-md-6 mb-2">
            <div class="card border-left-warning shadow h-100 py-2 dash-card">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                {{__('6-Months Subscription')}}</div>
                            <div class="h5 mb-0 font-weight-bold text-white">{{$totalSixMonthUsers}}</div>
                        </div>
                        <div class="col-auto">
                            <script src="https://cdn.lordicon.com/bhenfmcm.js"></script>
                            <lord-icon
                                src="https://cdn.lordicon.com/eszyyflr.json"
                                trigger="loop"
                                delay="2000"
                                state="hover-glance"
                                colors="primary:#f6c23e,secondary:#fff"
                                style="width:48px;height:48px">
                            </lord-icon>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-4 col-md-6 mb-2">
            <div class="card border-left-danger shadow h-100 py-2 dash-card">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                {{__('12-Months Subscription')}}</div>
                            <div class="h5 mb-0 font-weight-bold text-white">{{$totalOneYearUsers}}</div>
                        </div>
                        <div class="col-auto">
                            <script src="https://cdn.lordicon.com/bhenfmcm.js"></script>
                            <lord-icon
                                src="https://cdn.lordicon.com/eszyyflr.json"
                                trigger="loop"
                                delay="2000"
                                colors="primary:#e74a3b,secondary:#fff"
                                state="hover-wave"
                                style="width:48px;height:48px">
                            </lord-icon>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-4 col-md-6 mb-2">
            <div class="card border-left-success shadow h-100 py-2 dash-card">
                <div class="card-body ">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                {{__('Active Users')}}</div>
                            <div class="h5 mb-0 font-weight-bold text-white">{{$totalActiveUsers}}</div>
                        </div>
                        <div class="col-auto">
                            <script src="https://cdn.lordicon.com/bhenfmcm.js"></script>
                            <lord-icon
                                src="https://cdn.lordicon.com/pithnlch.json"
                                trigger="loop"
                                colors="primary:#fff,secondary:#1cc88a"
                                state="loop"
                                style="width:48px;height:48px">
                            </lord-icon>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-4 col-md-6 mb-2">
            <div class="card border-left-danger shadow h-100 py-2 dash-card">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                {{__('De-Active Users')}}</div>
                            <div class="h5 mb-0 font-weight-bold text-white">{{$totalDeactiveUsers}}</div>
                        </div>
                        <div class="col-auto">
                            <script src="https://cdn.lordicon.com/bhenfmcm.js"></script>
                            <lord-icon
                                src="https://cdn.lordicon.com/dzydjxom.json"
                                trigger="loop"
                                delay="2000"
                                colors="primary:#e74a3b,secondary:#fff"
                                style="width:48px;height:48px">
                            </lord-icon>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-4 col-md-6 mb-2">
            <div class="card border-left-danger shadow h-100 py-2 dash-card">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                {{__('Expired Users')}}</div>
                            <div class="h5 mb-0 font-weight-bold text-white">{{$totalExpireUsers}}</div>
                        </div>
                        <div class="col-auto">
                            <script src="https://cdn.lordicon.com/bhenfmcm.js"></script>
                            <lord-icon
                                src="https://cdn.lordicon.com/moscwhoj.json"
                                trigger="loop"
                                colors="primary:#e74a3b,secondary:#fff"
                                style="width:48px;height:48px">
                            </lord-icon>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-4 col-md-6 mb-2">
            <div class="card border-left-info shadow h-100 py-2 dash-card">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                {{__('Pending Users')}}</div>
                            <div class="h5 mb-0 font-weight-bold text-white">{{$totalPendingUsers}}</div>
                        </div>
                        <div class="col-auto">
                            <script src="https://cdn.lordicon.com/bhenfmcm.js"></script>
                            <lord-icon
                                src="https://cdn.lordicon.com/kbtmbyzy.json"
                                trigger="loop"
                                delay="2000"
                                colors="primary:#36b9cc,secondary:#fff"
                                style="width:48px;height:48px">
                            </lord-icon>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
    </div>
   
    <!-- Content Row -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4 dash-card">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between dash-card">
                    <h6 class="m-0 font-weight-bold text-white">
                        {{__('Overview Statistic')}}
                    </h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="combinedChart"></canvas>
                        {{-- <canvas id="myAreaChart"></canvas> --}}
                    </div>
                    <div class="my-4">
                        <label for="yearSelect">{{__('Select Year:')}}</label>
                        <select id="yearSelect" class="form-control" 
                        wire:model="selectedYear" 
                        style="background-color: #303541; color: #fff;">
                        @if ($availableYears)
                            
                        @forelse ($availableYears as $year)
                        <option value="{{ $year }}">{{ $year }}</option>
                        @empty
                        <option value="">NO DATA</option>
                        @endforelse
                        @endif
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card shadow mb-4 dash-card">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between dash-card">
                    <h6 class="m-0 font-weight-bold text-white">
                        {{__('Overview Statistic')}}
                    </h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="combinedCountryChart"></canvas>
                        {{-- <canvas id="myAreaChart"></canvas> --}}
                    </div>
                    <div class="my-4">
                        <label for="yearSelect">{{__('Select Year:')}}</label>
                        <select id="yearSelect" class="form-control" 
                        wire:model="selectedYear" 
                        style="background-color: #303541; color: #fff;">
                        @if ($availableYears)
                            
                        @forelse ($availableYears as $year)
                        <option value="{{ $year }}">{{ $year }}</option>
                        @empty
                        <option value="">NO DATA</option>
                        @endforelse
                        @endif
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Content Column -->
        <div class="col-lg-12">

            <!-- Project Card Example -->

        </div>
        <!-- Content Column -->
        <div class="col-lg-6">

            <!-- Project Card Example -->
            <div class="card shadow mb-4 dash-card">
                <div class="card-header py-3 dash-card">
                    <h6 class="m-0 font-weight-bold text-white">Top 5 Categories Clicked</h6>
                </div>
                <div class="card-body">
                    @foreach($categoriesWithNames as $category)
                    @php
                        $clickCount = $topCategories->where('category_id', $category->id)->first()->click_count ?? 0;
                        $percentage = ($clickCount / $sumCategoryClick) * 100;
                    @endphp
                    <h4 class="small font-weight-bold text-white">{{ $category->translation->name }} <span class="float-right">{{ $clickCount }}</span></h4>
                    <div class="progress mb-4">
                        <div class="progress-bar bg-danger progress-bar-striped progress-bar-animated" role="progressbar" style="width: {{ $percentage + $sumCategoryClick}}%" aria-valuenow="{{ $clickCount }}" aria-valuemin="0" aria-valuemax="{{ $sumCategoryClick }}"></div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-lg-6">

            <!-- Project Card Example -->
            <div class="card shadow mb-4 dash-card">
                <div class="card-header py-3 dash-card">
                    <h6 class="m-0 font-weight-bold text-white">Top 5 Food Clicked</h6>
                </div>
                <div class="card-body">
                    @foreach($foodWithNames as $food)
                    @php
                        $clickCount = $topFood->where('food_id', $food->id)->first()->click_count ?? 0;
                        $percentage = ($clickCount / $sumFoodClick) * 100;
                    @endphp
                    <h4 class="small font-weight-bold text-white">{{ $food->translation->name }} <span class="float-right">{{ $clickCount }}</span></h4>
                    <div class="progress mb-4">
                        <div class="progress-bar bg-warning progress-bar-striped progress-bar-animated" role="progressbar" style="width: {{ $percentage + $sumFoodClick}}%" aria-valuenow="{{ $clickCount }}" aria-valuemin="0" aria-valuemax="{{ $sumFoodClick }}"></div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-lg-12 mb-4">


            <!-- Approach -->
            <div class="card shadow mb-4 dash-card">
                <div class="card-header py-3 dash-card">
                    <h6 class="m-0 font-weight-bold text-white">Development Approach</h6>
                </div>
                <div class="card-body text-white dash-card">
                    <div class="text-center">
                        <img class="img-fluid px-3 px-sm-4 mt-3 mb-4 rounded-circle" style="width: 10rem; object-fit:cover;"
                            src="https://i.ibb.co/7CdxCVJ/facebook-logo.jpg" alt="minemenulogo">
                    </div>
                    <p>Mine Menu Version 2 makes extensive use of Resturant utility in order to reduce
                        poor page performance. Custom Design are used to create
                        Great components to your Resturant.</p>
                    <p class="mb-0">Before working with this theme, you should become familiar with the
                        Mine Menu, especially the utility classes.</p>
                </div>
            </div>

        </div>
    </div>


<!-- /.container-fluid -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@push('rest_script')
<script>
     document.addEventListener('livewire:load', function () {
        console.log('Initial');

        var combinedChart;

        // Define chart options
        var chartOptions = {
            maintainAspectRatio: false,
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
                xAxes: [{
                    gridLines: {
                        display: true,
                        drawBorder: true,
                    },
                    ticks: {
                        fontColor: "#ffffff",
                        maxTicksLimit: 12,
                    },
                }],
                yAxes: [{
                    maxTicksLimit: 5,
                    padding: 10,
                    color: "white",
                    ticks: {
                        fontColor: "#ffffff",
                        maxTicksLimit: 12,
                        callback: function (value, index, values) {
                            return value.toFixed(1);
                            // return "$" + value.toFixed(2);
                        },
                    },
                    gridLines: {
                        color: "rgb(234, 236, 244)",
                        borderColor: "rgb(234, 236, 244)",
                        drawBorder: true,
                        borderDash: [2],
                        borderDashOffset: [2],
                    },
                }],
            },
            legend: {
                labels: {
                    fontColor: "#fff",
                }
            },
            plugins: {

                colors: {
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
                                label += "$" + context.parsed.y.toFixed(2);
                            }
                            return label;
                        },
                    },
                },
            },
        };

        function createOrUpdateChart($asd) {

            if (combinedChart) {
                combinedChart.destroy();
            }
            if($asd){
                var chartData = $asd
            } else {
                var chartData = {!! json_encode($chartData) !!}
            }
console.log({!! json_encode($chartData) !!});
            var labels = Object.keys(chartData.timePlan);
            var demoData = labels.map(month => chartData.demoPlan[month]?.count || 0);
            var planOneData = labels.map(month => chartData.planOne[month]?.count || 0);
            var planTwoData = labels.map(month => chartData.planTwo[month]?.count || 0);
            var planThreeData = labels.map(month => chartData.planThree[month]?.count || 0);

            // console.log(chartData);

            var ctx = document.getElementById("combinedChart").getContext('2d');
            combinedChart = new Chart(ctx, {
                type: "line",
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Demo Plan',
                            data: demoData,
                            borderColor: 'rgba(75, 192, 192, 1)',
                            backgroundColor: ['rgba(75, 192, 192, 0.1)','rgba(75, 192, 192, 0)'],
                            borderWidth: 2,
                            fill: true,
                        },
                        {
                            label: '1 Month Plan',
                            data: planOneData,
                            borderColor: 'rgba(28, 200, 138, 1)', // Change the color
                            backgroundColor: ['rgba(28, 200, 138, 0.1)','rgba(28, 200, 138, 0)'],
                            borderWidth: 2,
                            fill: true,
                        },
                        {
                            label: '6 Months Plan',
                            data: planTwoData,
                            borderColor: 'rgba(255, 206, 86, 1)', // Change the color
                            backgroundColor: ['rgba(255, 206, 86, 0.1)','rgba(255, 206, 86, 0)'],
                            borderWidth: 2,
                            fill: true,
                        },
                        {
                            label: '12 Months Plan',
                            data: planThreeData,
                            borderColor: 'rgba(255, 99, 132, 1)', // Change the color
                            backgroundColor: ['rgba(255, 99, 132, 0.1)','rgba(255, 99, 132, 0)'],
                            borderWidth: 2,
                            fill: true,
                        },
                    ],
                },
                options: chartOptions, // Reuse chart options
            });
        }

        // Initial chart creation
        createOrUpdateChart(null);

        document.addEventListener('chartDataUpdated', function ($asd) {
            console.log('Updated',$asd.detail);
            createOrUpdateChart($asd.detail); // Update the chart when data changes
        });
    });
</script>
    <script>
        document.addEventListener('livewire:load', function () {
           console.log('Initial');
   
           var combinedCountryChart;
   
           // Define chart options
           var chartCountryOptions = {
               maintainAspectRatio: false,
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
                   xAxes: [{
                       gridLines: {
                           display: true,
                           drawBorder: true,
                       },
                       ticks: {
                           fontColor: "#ffffff",
                           maxTicksLimit: 12,
                       },
                   }],
                   yAxes: [{
                       maxTicksLimit: 5,
                       padding: 10,
                       color: "white",
                       ticks: {
                           fontColor: "#ffffff",
                           maxTicksLimit: 12,
                           callback: function (value, index, values) {
                               return value.toFixed(1);
                               // return "$" + value.toFixed(2);
                           },
                       },
                       gridLines: {
                           color: "rgb(234, 236, 244)",
                           borderColor: "rgb(234, 236, 244)",
                           drawBorder: true,
                           borderDash: [2],
                           borderDashOffset: [2],
                       },
                   }],
               },
               legend: {
                   labels: {
                       fontColor: "#fff",
                   }
               },
               plugins: {
   
                   colors: {
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
                                   label += "$" + context.parsed.y.toFixed(2);
                               }
                               return label;
                           },
                       },
                   },
               },
           };
   
           function createOrUpdateChart(countyAsd) {
    if (combinedCountryChart) {
        combinedCountryChart.destroy();
    }

    var chartCountryData;

    if (countyAsd) {
        chartCountryData = countyAsd;
    } else {
        chartCountryData = {!! json_encode($chartCountryData['timeCountry']) !!};
    }

    // Initialize arrays to store data for each country
    var dates = Object.keys(chartCountryData);
    var countries = [];
    var colors = [];
    // Iterate through labels (months)
    for (var date in chartCountryData) {
        if (chartCountryData.hasOwnProperty(date)) {
            var dateData = chartCountryData[date];

            // Handle empty data (set to 0)
            if (Object.keys(dateData).length === 0) {
                dateData = {};
            }

            // Extract countries and add them to the list if not already present
            for (var country in dateData) {
                if (dateData.hasOwnProperty(country) && countries.indexOf(country) === -1) {
                    countries.push(country);
                    colors.push(getRandomColor());
                }
            }
        }
    }

    // Sort countries alphabetically
    countries.sort();

    // Create datasets
    var datasets = countries.map(function (country, index) {
        var data = dates.map(function (date) {
            return chartCountryData[date][country] || 0;
        });

        return {
            label: country,
            data: data,
            // backgroundColor: 'rgba(75, 192, 192, 0.7)', // Adjust the background color as needed
            backgroundColor: colors[index], // Adjust the background color as needed
            borderWidth: 2,
            fill: true,
        };
    });

    // Create the chart
    var ctx = document.getElementById("combinedCountryChart").getContext('2d');
    combinedCountryChart = new Chart(ctx, {
        type: "bar",
        data: {
            labels: dates,
            datasets: datasets,
        },
        options: chartCountryOptions, // Reuse chart options
    });
}



   
           // Initial chart creation
           createOrUpdateChart(null);
   
           document.addEventListener('chartDataCountryUpdated', function ($countyAsd) {
               console.log('Updated',$countyAsd.detail);
               createOrUpdateChart($countyAsd.detail); // Update the chart when data changes
           });
       });

//        function getRandomColor() {
//     var letters = '0123456789ABCDEF';
//     var color = '#';
//     for (var i = 0; i < 8; i++) {
//         color += letters[Math.floor(Math.random() * 16)];
//     }
//     return color;
// }
var customHexColors = [
    '#4e73dfaa',
    '#6f42c1aa',
    '#e83e8caa',
    '#e74a3baa',
    '#fd7e14aa',
    '#f6c23eaa',
    '#1cc88aaa',
    '#36b9ccaa',
    // Add more colors as needed
];

function getRandomColor() {
    // Pick a random color from the customHexColors array
    var randomIndex = Math.floor(Math.random() * customHexColors.length);
    return customHexColors[randomIndex];
}
       </script>
@endpush
</div>