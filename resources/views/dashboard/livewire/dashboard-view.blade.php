<!-- Begin Page Content -->
<div>

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-white">Dashboard</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-12 mb-3">
            <div class="row m-0 p-0 dash-card">
                <div class="col-12 col-xl-2 m-0 p-0">
                    <div class="card-profile text-center">
                        <img src="{{app('cloudfront').auth()->user()->settings->background_img_avatar}}"
                            alt="Responsive Image" class="img-fluid rounded-circle p-3" style="max-width: 150px">
                    </div>
                </div>
                <div class="col-md-10 m-0 p-0">
                    <div class="card-body dash-card border-0">
                        <div class="row text-white">
                            <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-4 mb-3">
                                {{-- <h5>Profile</h5> --}}
                                <p class="card-title">Restaurant Name: {{$profile['restName']}}</p>
                                <p class="card-title">Country: {{$profile['country']}}</p>
                            </div>
                            <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-4 mb-3">
                                {{-- <h5>Initial Information</h5> --}}
                                <p class="card-title">Name: {{$profile['name']}}</p>
                                <p class="card-title">Email: {{$profile['email']}}</p>
                                <p class="card-title">Phone: {{$profile['phone']}}</p>
                            </div>
                            <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-4 mb-3">
                                {{-- <h5>Menu Active Time</h3> --}}
                                <p class="card-title text-success">Start: {{$profile['create']}}</p>
                                <p class="card-title text-danger">Expire: {{$profile['expire']}}</p>
                                <p class="card-title text-info">Subsuription: 1 Year</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        

    {{-- </div> --}}

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2 dash-card">
                <div class="card-body ">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                {{__('Total Scans (Monthly)')}}</div>
                            <div class="h5 mb-0 font-weight-bold text-white">{{$visit_monthly}} / {{__('mo')}}</div>
                        </div>
                        <div class="col-auto">
                            <script src="https://cdn.lordicon.com/bhenfmcm.js"></script>
                            <lord-icon
                                src="https://cdn.lordicon.com/fqrjldna.json"
                                trigger="loop"
                                colors="primary:#4e73df,secondary:#fff"
                                state="loop"
                                style="width:48px;height:48px">
                            </lord-icon>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2 dash-card">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                {{__('Total Scans (Life-time')}})</div>
                            <div class="h5 mb-0 font-weight-bold text-white">{{$visit_lifetime}}</div>
                        </div>
                        <div class="col-auto">
                            <script src="https://cdn.lordicon.com/bhenfmcm.js"></script>
                            <lord-icon
                                src="https://cdn.lordicon.com/msoeawqm.json"
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
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2 dash-card">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                {{__('Total Categories')}}</div>
                            <div class="h5 mb-0 font-weight-bold text-white">{{$count_category}}</div>
                        </div>
                        <div class="col-auto">
                            <script src="https://cdn.lordicon.com/bhenfmcm.js"></script>
                            <lord-icon
                                src="https://cdn.lordicon.com/nocovwne.json"
                                trigger="loop"
                                delay="2000"
                                colors="primary:#f6c23e,secondary:#fff"
                                style="width:48px;height:48px">
                            </lord-icon>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2 dash-card">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                {{__('Total Food')}}</div>
                            <div class="h5 mb-0 font-weight-bold text-white">{{$count_food}}</div>
                        </div>
                        <div class="col-auto">
                            <script src="https://cdn.lordicon.com/bhenfmcm.js"></script>
                            <script src="https://cdn.lordicon.com/bhenfmcm.js"></script>
                            <lord-icon
                                src="https://cdn.lordicon.com/dnoiydox.json"
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
                            @foreach ($availableYears as $year)
                            <option value="{{ $year }}">{{ $year }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">

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
                        <div class="progress-bar bg-danger progress-bar-striped progress-bar-animated" role="progressbar" style="width: {{ $percentage }}%" aria-valuenow="{{ $clickCount }}" aria-valuemin="0" aria-valuemax="{{ $sumCategoryClick }}"></div>
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
                        <div class="progress-bar bg-warning progress-bar-striped progress-bar-animated" role="progressbar" style="width: {{ $percentage }}%" aria-valuenow="{{ $clickCount }}" aria-valuemin="0" aria-valuemax="{{ $sumFoodClick }}"></div>
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

            var visitsData = chartData.visits;
            var categoryClicksData = chartData.categoryClicks;
            var foodClicksData = chartData.foodClicks;

            var ctx = document.getElementById("combinedChart").getContext('2d');
            combinedChart = new Chart(ctx, {
                type: "line",
                data: {
                    labels: visitsData.map(item => item.month),
                    datasets: [
                        {
                            label: 'Visits',
                            data: visitsData.map(item => item.count),
                            borderColor: 'rgba(75, 192, 192, 1)',
                            backgroundColor: ['rgba(75, 192, 192, 0.1)','rgba(75, 192, 192, 0)'],
                            borderWidth: 2,
                            fill: true,
                        },
                        {
                            label: 'Category Clicks',
                            data: categoryClicksData.map(item => item.count),
                            borderColor: 'rgba(255, 99, 132, 1)', // Change the color
                            backgroundColor: ['rgba(255, 99, 132, 0.1)','rgba(255, 99, 132, 0)'],
                            borderWidth: 2,
                            fill: true,
                        },
                        {
                            label: 'Food Clicks',
                            data: foodClicksData.map(item => item.count),
                            borderColor: 'rgba(255, 206, 86, 1)', // Change the color
                            backgroundColor: ['rgba(255, 206, 86, 0.1)','rgba(255, 206, 86, 0)'],
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
@endpush
    </div>