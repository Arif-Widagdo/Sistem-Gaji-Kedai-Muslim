<x-app-dashboard title="{{ __('Dashboard') }}">

    <!-- Info boxes -->
    <div class="row">
        <div class="col-12 col-sm-4">
          <div class="info-box">
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-user-tie"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">{{ __('User Position') }}</span>
                <span class="info-box-number">{{ $positions->count() }}</span>
              </div>
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-12 col-sm-4">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-boxes"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">{{ __('Production') }}</span>
                <span class="info-box-number">
                  {{ number_format($prodcution) }} Item
                </span>
              </div>
            
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix hidden-md-up"></div>
        <!-- /.col -->
        <div class="col-12 col-sm-4">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">{{ __('User') }}</span>
              <span class="info-box-number">{{ $users->count() }}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->




    <div class="row">
        <div class="col-md-8">
            <div class="card card-outline card-purple">
                <div class="card-header">
                    <h3 class="card-title text-bold">{{ __('Monthly Salary Recap Report') }}</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                          <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                          <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="d-flex">
                        <p class="d-flex flex-column">
                            <span class="text-bold text-lg"> Rp. {{ number_format($sallaryPrev,2,',','.') }}</span>
                            <span>{{ __('Salary Expenditures in the Previous Month') }}</span>
                        </p>
                    </div>
                    <!-- /.d-flex -->
                    <div class="position-relative mb-4">
                        <canvas id="sallary-chart" height="250"></canvas>
                    </div>
                </div>
                <!-- ./card-body -->
            </div>
        </div>



        <div class="col-md-4">
              <!-- DONUT CHART -->
              <div class="card card-purple">
                <div class="card-header">
                  <h3 class="card-title text-bold">{{ __('Monthly Production Report') }}</h3>
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                      <i class="fas fa-times"></i>
                    </button>
                  </div>
                </div>
                <div class="card-body">
                  <canvas id="productChart" style="min-height: 350px; height: 350px; max-height: 350px; max-width: 100%; "></canvas>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
        </div>
    </div>
    
    
    <!-- /.row -->
    @section('scripts')
    <!-- OPTIONAL SCRIPTS -->
    <script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
    <script>
        /* global Chart:false */
            var ticksStyle = {
                fontColor: '#495057',
                fontStyle: 'bold'
            }

            var mode = 'index'
            var intersect = true

            var $sallaryChat = $('#sallary-chart')
            // eslint-disable-next-line no-unused-vars
            var sallaryChat = new Chart($sallaryChat, {
                type: 'bar',
                data: {
                    labels: [
                      "{{ __('January') }}", 
                      "{{ __('February') }}",
                      "{{ __('March') }}",
                      "{{ __('April') }}",
                      "{{ __('May') }}",
                      "{{ __('June') }}",
                      "{{ __('July') }}",
                      "{{ __('August') }}",
                      "{{ __('September') }}",
                      "{{ __('October') }}",
                      "{{ __('November') }}",
                      "{{ __('December') }}",
                       ],
                    datasets: [{
                            backgroundColor: '#6F42C1',
                            borderColor: '#6F42C1',
                            data: [
                                {{ $salJan  }},
                                {{ $salFeb  }},
                                {{ $salMar  }},
                                {{ $salApr  }},
                                {{ $salMei  }},
                                {{ $salJun  }},
                                {{ $salJul  }},
                                {{ $salAug  }},
                                {{ $salSep  }},
                                {{ $salOct  }},
                                {{ $salNov  }},
                                {{ $salDes  }},
                            ]
                        },
                    ]
                },
                options: {
                    maintainAspectRatio: false,
                    tooltips: {
                        mode: mode,
                        intersect: intersect
                    },
                    hover: {
                        mode: mode,
                        intersect: intersect
                    },
                    legend: {
                        display: false
                    },
                    scales: {
                        yAxes: [{
                            // display: false,
                            gridLines: {
                                display: true,
                                lineWidth: '4px',
                                color: 'rgba(0, 0, 0, .2)',
                                zeroLineColor: 'transparent'  
                            },
                            ticks: $.extend({
                                beginAtZero: true,

                                // Include a dollar sign in the ticks
                                callback: function (value) {
                                    if (value >= 1000) {
                                        value /= 1000
                                        value += 'k'
                                    }
                                    return value
                                    // return 'Rp.' + value
                                }
                            }, ticksStyle)
                        }],
                        xAxes: [{
                            display: true,
                            gridLines: {
                                display: false
                            },
                            ticks: ticksStyle
                        }]
                    }
                }
            });



            //-------------
            //- DONUT CHART -
            //-------------
            // Get context with jQuery - using jQuery's .get() method.
            var productChartCanvas = $('#productChart').get(0).getContext('2d')
            var productData        = {
            labels: [
                "{{ __('January') }}", 
                "{{ __('February') }}",
                "{{ __('March') }}",
                "{{ __('April') }}",
                "{{ __('May') }}",
                "{{ __('June') }}",
                "{{ __('July') }}",
                "{{ __('August') }}",
                "{{ __('September') }}",
                "{{ __('October') }}",
                "{{ __('November') }}",
                "{{ __('December') }}",
            ],
            datasets: [
                {
                data: [
                    {{ $prodJan }},
                    {{ $prodFeb }},
                    {{ $prodMar }},
                    {{ $prodApr }},
                    {{ $prodMei }},
                    {{ $prodJun }},
                    {{ $prodJul }},
                    {{ $prodAug }},
                    {{ $prodSep }},
                    {{ $prodOct }},
                    {{ $prodNov }},
                    {{ $prodDes }}
                ],
                backgroundColor : [
                    '#007bff',
                    '#6610f2', 
                    '#6f42c1', 
                    '#e83e8c', 
                    '#dc3545', 
                    '#fd7e14',
                    '#ffc107',
                    '#28a745', 
                    '#20c997', 
                    '#17a2b8', 
                    '#fff', 
                    '#6c757d'
                    ],
                }
            ]
            }
            var donutOptions     = {
            maintainAspectRatio : false,
            responsive : true,
            }
            //Create pie or douhnut chart
            // You can switch between pie and douhnut using the method below.
            new Chart(productChartCanvas, {
            type: 'doughnut',
            data: productData,
            options: donutOptions
            })


    </script>
    @endsection



</x-app-dashboard>
