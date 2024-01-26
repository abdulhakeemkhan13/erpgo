@extends('layouts.admin')
@section('page-title')
    {{__('Dashboard')}}
@endsection
@push('script-page')
    <script>
        @if(\Auth::user()->can('show account dashboard'))
        (function () {
            var chartBarOptions = {
                series: [
                    {
                        name: "{{__('Income')}}",
                        data:{!! json_encode($incExpLineChartData['income']) !!}
                    },
                    {
                        name: "{{__('Expense')}}",
                        data: {!! json_encode($incExpLineChartData['expense']) !!}
                    }
                ],

                chart: {
                    height: 250,
                    type: 'area',
                    // type: 'line',
                    dropShadow: {
                        enabled: true,
                        color: '#000',
                        top: 18,
                        left: 7,
                        blur: 10,
                        opacity: 0.2
                    },
                    toolbar: {
                        show: false
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    width: 2,
                    curve: 'smooth'
                },
                title: {
                    text: '',
                    align: 'left'
                },
                xaxis: {
                    categories:{!! json_encode($incExpLineChartData['day']) !!},
                    title: {
                        text: '{{ __("Date") }}'
                    }
                },
                colors: ['#6fd944', '#ff3a6e'],


                grid: {
                    strokeDashArray: 4,
                },
                legend: {
                    show: false,
                },
                // markers: {
                //     size: 4,
                //     colors: ['#6fd944', '#FF3A6E'],
                //     opacity: 0.9,
                //     strokeWidth: 2,
                //     hover: {
                //         size: 7,
                //     }
                // },
                yaxis: {
                    title: {
                        text: '{{ __("Amount") }}'
                    },

                }

            };
            var arChart = new ApexCharts(document.querySelector("#cash-flow"), chartBarOptions);
            arChart.render();
        })();

        (function () {
            var options = {
                chart: {
                    height: 180,
                    type: 'bar',
                    toolbar: {
                        show: false,
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    width: 2,
                    curve: 'smooth'
                },
                series: [{
                    name: "{{__('Income')}}",
                    data: {!! json_encode($incExpBarChartData['income']) !!}
                }, {
                    name: "{{__('Expense')}}",
                    data: {!! json_encode($incExpBarChartData['expense']) !!}
                }],
                xaxis: {
                    categories: {!! json_encode($incExpBarChartData['month']) !!},
                },
                colors: ['#3ec9d6', '#FF3A6E'],
                fill: {
                    type: 'solid',
                },
                grid: {
                    strokeDashArray: 4,
                },
                legend: {
                    show: true,
                    position: 'top',
                    horizontalAlign: 'right',
                },
                // markers: {
                //     size: 4,
                //     colors:  ['#3ec9d6', '#FF3A6E',],
                //     opacity: 0.9,
                //     strokeWidth: 2,
                //     hover: {
                //         size: 7,
                //     }
                // }
            };
            var chart = new ApexCharts(document.querySelector("#incExpBarChart"), options);
            chart.render();
        })();

        (function () {
            var options = {
                chart: {
                    height: 140,
                    type: 'donut',
                },
                dataLabels: {
                    enabled: false,
                },
                plotOptions: {
                    pie: {
                        donut: {
                            size: '70%',
                        }
                    }
                },
                series: {!! json_encode($expenseCatAmount) !!},
                colors: {!! json_encode($expenseCategoryColor) !!},
                labels: {!! json_encode($expenseCategory) !!},
                legend: {
                    show: true
                }
            };
            var chart = new ApexCharts(document.querySelector("#expenseByCategory"), options);
            chart.render();
        })();

        (function () {
            var options = {
                chart: {
                    height: 140,
                    type: 'donut',
                },
                dataLabels: {
                    enabled: false,
                },
                plotOptions: {
                    pie: {
                        donut: {
                            size: '70%',
                        }
                    }
                },
                series: {!! json_encode($incomeCatAmount) !!},
                colors: {!! json_encode($incomeCategoryColor) !!},
                labels:  {!! json_encode($incomeCategory) !!},
                legend: {
                    show: true
                }
            };
            var chart = new ApexCharts(document.querySelector("#incomeByCategory"), options);
            chart.render();
        })();

        (function () {
            var options = {
                series: [{{ round($storage_limit,2) }}],
                chart: {
                    height: 350,
                    type: 'radialBar',
                    offsetY: -20,
                    sparkline: {
                        enabled: true
                    }
                },
                plotOptions: {
                    radialBar: {
                        startAngle: -90,
                        endAngle: 90,
                        track: {
                            background: "#e7e7e7",
                            strokeWidth: '97%',
                            margin: 5, // margin is in pixels
                        },
                        dataLabels: {
                            name: {
                                show: true
                            },
                            value: {
                                offsetY: -50,
                                fontSize: '20px'
                            }
                        }
                    }
                },
                grid: {
                    padding: {
                        top: -10
                    }
                },
                colors: ["#6FD943"],
                labels: ['Used'],
            };
            var chart = new ApexCharts(document.querySelector("#limit-chart"), options);
            chart.render();
        })();

        @endif
    </script>
@endpush
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('Account')}}</li>
@endsection
@section('content')



    <div class="row">
        <div class="col-sm-12">
            <div class="row">
                <div class="col-xxl-7">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">

                                <div class="col-lg-3 col-6">
                                    <div class="card mb-5 hover-border-primary">
              
                                        <div class="h-100 d-flex flex-column justify-content-between card-body align-items-center">
                                              <svg width="64px" height="64px" viewBox="0 0 1024 1024" fill="#0ec4cb" class="icon" version="1.1" xmlns="http://www.w3.org/2000/svg" stroke="#0ec4cb" stroke-width="0.01024"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M983.902 1023.894H40.098a7.994 7.994 0 0 1-7.998-8v-95.98c0-68.64 35.562-94.948 101.174-119.474 11.654-4.342 26.706-8.858 42.64-13.636 67.572-20.262 160.124-48.022 160.124-106.838 0-4.422 3.578-7.998 7.998-7.998s7.998 3.576 7.998 7.998c0 70.718-99.134 100.45-171.528 122.162-15.676 4.702-30.478 9.138-41.63 13.31-61.504 22.978-90.778 44.49-90.778 104.476v87.982h927.808v-87.982c0-59.986-29.276-81.498-90.792-104.476-11.138-4.172-25.95-8.61-41.618-13.31-72.39-21.712-171.528-51.444-171.528-122.162a7.994 7.994 0 0 1 7.998-7.998 7.992 7.992 0 0 1 7.998 7.998c0 58.816 92.544 86.576 160.124 106.838 15.934 4.78 30.992 9.294 42.63 13.636 65.626 24.528 101.182 50.834 101.182 119.474v95.98c0 4.422-3.578 8-7.998 8z" fill=""></path><path d="M512 719.958c-109.562 0-268.006-158.608-286.152-327.058a7.99 7.99 0 0 1 7.092-8.81c4.552-0.39 8.342 2.71 8.81 7.092 8.154 75.656 46.888 155.576 106.274 219.252 53.786 57.69 116.616 93.528 163.974 93.528 51.928 0 121.724-42.836 177.854-109.134a8.044 8.044 0 0 1 11.28-0.938 8.014 8.014 0 0 1 0.938 11.28c-59.034 69.732-133.644 114.788-190.07 114.788zM741.14 543.992a7.992 7.992 0 0 1-6.92-12.012c32.54-56.058 49.722-115.516 49.722-171.95a7.994 7.994 0 0 1 8-7.998 7.992 7.992 0 0 1 7.996 7.998c0 59.254-17.934 121.482-51.878 179.978a7.984 7.984 0 0 1-6.92 3.984z" fill=""></path><path d="M344.036 694.632a7.994 7.994 0 0 1-7.998-7.998v-68.766c0-4.422 3.578-7.998 7.998-7.998s7.998 3.576 7.998 7.998v68.766a7.994 7.994 0 0 1-7.998 7.998zM679.964 687.962a7.994 7.994 0 0 1-7.998-7.998v-62.08a7.994 7.994 0 0 1 7.998-7.998 7.992 7.992 0 0 1 7.998 7.998v62.08a7.992 7.992 0 0 1-7.998 7.998zM376.02 992.462c-0.874 0-1.756-0.14-2.632-0.454a8 8 0 0 1-4.92-10.186 151.48 151.48 0 0 1 16.894-33.976c28.276-42.524 75.618-67.924 126.638-67.924 11.358 0 22.668 1.25 33.62 3.732a8.006 8.006 0 0 1 6.06 9.562c-0.968 4.31-5.28 7.044-9.56 6.03a137.668 137.668 0 0 0-30.12-3.328c-45.654 0-88.012 22.73-113.312 60.786a135.646 135.646 0 0 0-15.114 30.4 8 8 0 0 1-7.554 5.358zM647.972 992.462a8.01 8.01 0 0 1-7.56-5.358 134.146 134.146 0 0 0-15.124-30.384 137.06 137.06 0 0 0-22.62-26.166 7.986 7.986 0 0 1-0.624-11.294c2.952-3.266 8.03-3.546 11.278-0.61a153.044 153.044 0 0 1 25.308 29.198 152.962 152.962 0 0 1 16.902 33.976 8.012 8.012 0 0 1-7.56 10.638zM496.004 991.9a7.996 7.996 0 0 1-5.656-13.654l143.97-143.968a7.996 7.996 0 1 1 11.31 11.308l-143.97 143.97a7.964 7.964 0 0 1-5.654 2.344zM823.936 328.038a7.994 7.994 0 0 1-7.998-8C815.938 152.45 679.59 16.102 512 16.102S208.064 152.45 208.064 320.04c0 4.422-3.578 8-8 8a7.994 7.994 0 0 1-7.998-8C192.066 143.63 335.592 0.106 512 0.106c176.4 0 319.934 143.526 319.934 319.934a7.994 7.994 0 0 1-7.998 7.998z" fill=""></path><path d="M200.064 759.95a7.994 7.994 0 0 1-7.998-8V320.04a7.994 7.994 0 0 1 7.998-7.998c4.422 0 8 3.578 8 7.998v431.91c0 4.422-3.578 8-8 8z" fill=""></path><path d="M823.936 759.95a7.994 7.994 0 0 1-7.998-8V320.04c0-4.42 3.576-7.998 7.998-7.998s7.998 3.578 7.998 7.998v431.91c0 4.422-3.576 8-7.998 8z" fill=""></path><path d="M201.682 375.864l-3.234-15.668c277.74-57.308 505.576-282.95 507.854-285.222l11.31 11.294c-2.294 2.312-233.41 231.296-515.93 289.596z" fill=""></path><path d="M820.874 344.988c-149.876-54.59-259.04-137.746-260.118-138.582l9.748-12.684c1.062 0.82 108.4 82.522 255.838 136.236l-5.468 15.03z" fill=""></path><path d="M603.982 607.98a8.018 8.018 0 0 1-7.938-6.984 8.002 8.002 0 0 1 6.938-8.95c1.482-0.188 149.718-19.762 184.336-84.664 10.216-19.106 9.374-39.976-2.532-63.792a8.004 8.004 0 0 1 3.578-10.732 8.012 8.012 0 0 1 10.732 3.578c14.2 28.4 14.98 54.808 2.342 78.492-38.524 72.164-190.024 92.176-196.458 92.988a7.138 7.138 0 0 1-0.998 0.064z" fill=""></path><path d="M577.986 623.976c-19.058 0-33.992-10.544-33.992-23.996 0-13.45 14.934-23.994 33.992-23.994s33.992 10.544 33.992 23.994c0 13.452-14.934 23.996-33.992 23.996z m0-31.992c-11.154 0-17.996 5.17-17.996 7.996 0 2.828 6.842 8 17.996 8s17.996-5.172 17.996-8c0-2.826-6.842-7.996-17.996-7.996z" fill=""></path><path d="M512 815.938c-155.264 0-195.068-81.14-196.686-84.594a7.992 7.992 0 0 1 3.85-10.636c3.976-1.876 8.734-0.156 10.616 3.826 0.398 0.812 37.938 75.406 182.22 75.406 144.876 0 176.244-74.204 176.526-74.954 1.64-4.092 6.312-6.108 10.404-4.452a8.016 8.016 0 0 1 4.468 10.388c-1.406 3.468-35.804 85.016-191.398 85.016z" fill=""></path></g></svg>
                                        
                                          <div class="text-center mb-0 sh-8 d-flex align-items-center lh-1-5">
                                              {{__('Total')}}
                                            <br />
                                            {{__('Customers')}}
                                          </div>
                                          <div class="display-6 text-primary">{{\Auth::user()->countCustomers()}}</div>
                                        </div>
                                      </div>
                                </div>
                                <div class="col-lg-3 col-6">
                                    <div class="card mb-5 hover-border-primary">
              
                                        <div class="h-100 d-flex flex-column justify-content-between card-body align-items-center">
                                      <svg fill="#0ec4cb" height="64px" width="64px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <g> <path d="M486.647,391.189c-51.2-26.948-90.359-41.899-125.133-47.812l3.789-5.205c1.485-2.039,1.988-4.634,1.374-7.083 l-7.919-31.684c21.222-29.935,33.775-67.328,33.775-102.784v-59.733C392.533,61.606,331.281,0.354,256,0.354 S119.467,61.606,119.467,136.887v59.733c0,35.456,12.553,72.849,33.775,102.784l-7.919,31.684 c-0.614,2.449-0.111,5.043,1.374,7.083l3.789,5.205c-34.773,5.914-73.933,20.864-125.133,47.812 C9.719,399.415,0,415.509,0,433.207v69.905c0,4.719,3.823,8.533,8.533,8.533h204.8h0.008l84.924-0.077 c0.137,0.009,0.265,0.077,0.401,0.077h204.8c4.71,0,8.533-3.814,8.533-8.533v-69.905C512,415.509,502.281,399.415,486.647,391.189 z M136.533,196.621v-59.733c0-65.877,53.589-119.467,119.467-119.467S375.467,71.01,375.467,136.887v59.733 c0,38.426-13.594,72.243-33.698,97.604c-0.307,0.29-0.691,0.478-0.947,0.802c-2.935,3.755-5.973,7.296-9.105,10.624 c-0.017,0.017-0.034,0.034-0.051,0.051c-2.065,2.202-4.233,4.156-6.374,6.161c-20.855,18.799-45.636,29.824-69.291,29.824 c-23.654,0-48.435-11.025-69.291-29.824c-2.142-2.005-4.309-3.959-6.374-6.161c-0.017-0.017-0.034-0.034-0.051-0.051 c-3.132-3.328-6.17-6.869-9.105-10.624c-0.256-0.324-0.64-0.512-0.947-0.802C150.127,268.864,136.533,235.046,136.533,196.621z M277.001,418.487h-42.001L256,371.23L277.001,418.487z M162.842,331.354l3.831-15.309c0.026,0.026,0.043,0.043,0.068,0.068 c20.617,22.426,46.857,38.229,76.442,41.822c0.009,0,0.026,0.009,0.043,0.009l-23.151,52.105L162.842,331.354z M222.882,494.571 l6.613-59.017h53.009l0.606,5.402l6.007,53.555L222.882,494.571z M291.925,410.048l-23.151-52.105 c0.009,0,0.026-0.009,0.043-0.009c29.585-3.593,55.825-19.396,76.442-41.822l0.068-0.068l3.823,15.309L291.925,410.048z"></path> </g> </g> </g></svg>              
                                          <div class="text-center mb-0 sh-8 d-flex align-items-center lh-1-5">
                                              {{__('Total')}}
                                            <br />
                                            {{__('Vendors')}}
                                          </div>
                                          <div class="display-6 text-primary">{{\Auth::user()->countVenders()}}</div>
                                        </div>
                                      </div>
                                </div>
                                <div class="col-lg-3 col-6">
                                    <div class="card mb-5 hover-border-primary">
              
                                        <div class="h-100 d-flex flex-column justify-content-between card-body align-items-center">
                                          <svg fill="#000000" width="64px" height="64px" viewBox="0 0 24 24" id="invoice-dollar-left" data-name="Line Color" xmlns="http://www.w3.org/2000/svg" class="icon line-color"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path id="secondary" d="M8,7H5.5A1.5,1.5,0,0,0,4,8.5H4A1.5,1.5,0,0,0,5.5,10h1A1.5,1.5,0,0,1,8,11.5H8A1.5,1.5,0,0,1,6.5,13H4" style="fill: none; stroke: #2ca9bc; stroke-linecap: round; stroke-linejoin: round; stroke-width:0.768;"></path><path id="secondary-2" data-name="secondary" d="M10,17h6m-4-4h4M6,7V6m0,8V13" style="fill: none; stroke: #2ca9bc; stroke-linecap: round; stroke-linejoin: round; stroke-width:0.768;"></path><path id="primary" d="M9,3H19a1,1,0,0,1,1,1V20a1,1,0,0,1-1,1H7a1,1,0,0,1-1-1V18" style="fill: none; stroke: #0ec4cb; stroke-linecap: round; stroke-linejoin: round; stroke-width:0.768;"></path></g></svg>               
                                         
                                          <div class="text-center mb-0 sh-8 d-flex align-items-center lh-1-5">
                                              {{__('Total')}}
                                            <br />
                                            {{__('Invoices')}}
                                          </div>
                                          <div class="display-6 text-primary">{{\Auth::user()->countInvoices()}}</div>
                                        </div>
                                      </div>
                                </div>
                                <div class="col-lg-3 col-6">
                                    <div class="card mb-5 hover-border-primary">
              
                                        <div class="h-100 d-flex flex-column justify-content-between card-body align-items-center">
                          <svg version="1.1" id="_x32_" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="64px" height="64px" viewBox="0 0 512 512" xml:space="preserve" fill="#0ec4cb" stroke="#0ec4cb" stroke-width="0.00512"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <style type="text/css">  .st0{fill:#0ec4cb;}  </style> <g> <path class="st0" d="M360,343.266c-6.5,0-11.75,5.25-11.75,11.734s5.25,11.75,11.75,11.75c6.469,0,11.734-5.266,11.734-11.75 S366.469,343.266,360,343.266z"></path> <path class="st0" d="M475.531,306.203h-3.781v-55.297c0-14.063-4.75-27-12.672-37.375L512,179.438l-4.172-6.813L402.656,1.172 L180.938,137.141H94c-50.531,0-91.594,39.875-93.797,89.828l-0.016,0.109L0,243.516v35.719v137.594c0,51.922,42.078,93.984,94,94 h318.25c34.109-0.016,61.75-27.656,61.75-61.766v-45.266h1.531c9.672-0.016,17.5-7.828,17.516-17.5v-62.594 C493.031,314.031,485.219,306.203,475.531,306.203z M397.344,23.156l92.688,151l-43.781,26.828 c-4.5-3.281-9.484-5.953-14.797-7.938l12.516-7.672c-4.656-14.594-0.484-30.797,10.906-41.156l-46.688-76.141 c-14.438,5.375-30.719,1.781-41.641-8.984L154.469,189.141h-27.688L397.344,23.156z M393.5,146.625 c-6.906,4.188-15.875,2.016-20.125-4.891c-4.188-6.813-2-15.875,4.813-20.047c6.906-4.266,15.969-2.094,20.125,4.813 C402.563,133.391,400.406,142.391,393.5,146.625z M301.563,153.938l-1.609-0.641c0,0-5.531-0.656-9.625,0.563 c-2.484,0.719-4.984,1.672-7.453,2.875l-4.422-7.141l-10.109,6.188l4.5,7.375c-1.047,0.875-2.094,1.766-2.969,2.734 c-2.094,2.328-3.688,4.813-4.734,7.531c-1.047,2.734-1.438,5.469-1.203,8.344c0.203,2.469,1.078,4.922,2.391,7.375h-31.984 c0.063-20.641,10.359-40.781,29.266-52.375c29.047-17.813,67.078-8.75,84.797,20.297c6.172,10.031,9.063,21.125,9.078,32.078 h-30.188c-0.484-1.203-1-2.391-1.734-3.594c-3.063-5.063-6.906-7.953-11.563-8.672c-4.656-0.797-10.031,0.406-16.297,3.453 l-8.422,4.25c-3.047,1.438-5.453,2.016-7.297,1.688s-3.359-1.453-4.484-3.375c-1.375-2.156-1.609-4.484-0.719-6.813 c0.797-2.406,3.031-4.656,6.484-6.828c2.734-1.672,5.453-2.891,8.344-3.766c2.813-0.875,6.828-0.563,6.828-0.563 c0.875-0.078,1.594-0.719,1.766-1.531l1.844-7.703L301.563,153.938z M457.969,449.063c-0.016,12.641-5.125,24.031-13.406,32.328 c-8.281,8.281-19.656,13.375-32.313,13.391H94c-21.547-0.016-40.984-8.719-55.125-22.828 c-14.125-14.141-22.813-33.578-22.828-55.125V279.234v-35.563l0.203-16.047c1.828-41.406,35.906-74.453,77.75-74.438h60.781 l-58.563,35.953l-23.422,0.016v16.047l337.359-0.016c12.578,0.063,23.906,5.141,32.156,13.391 c8.281,8.297,13.375,19.688,13.391,32.328v55.297H354.344c-13.469-0.016-25.688,5.469-34.5,14.297l-0.016,0.016 c-8.813,8.813-14.281,21.016-14.281,34.484s5.469,25.672,14.266,34.5l0.063,0.031l-0.031-0.016 c8.813,8.813,21.031,14.297,34.5,14.281h103.625V449.063z M477,386.297c0,0.781-0.656,1.453-1.469,1.453H354.344 c-9.125-0.016-17.109-3.609-23.141-9.578h-0.016c-5.969-6.031-9.578-14.047-9.594-23.172c0.016-9.109,3.625-17.141,9.594-23.156 c6.031-5.969,14.031-9.578,23.172-9.594h121.172c0.813,0,1.469,0.672,1.469,1.453V386.297z"></path> <rect x="108.578" y="231.313" class="st0" width="24.078" height="8.016"></rect> <rect x="333.219" y="231.313" class="st0" width="24.063" height="8.016"></rect> <path class="st0" d="M409.531,245.125l4.875-6.359c-6.063-4.672-13.719-7.453-21.969-7.453h-3.063v8.016h3.063 C398.891,239.328,404.781,241.484,409.531,245.125z"></path> <path class="st0" d="M54.484,227.5l-3.109,7.391c7.625,3.203,16.219,4.438,24.156,4.438h0.953v-8.016h-0.953 C68.438,231.313,60.781,230.156,54.484,227.5z"></path> <rect x="277.063" y="231.313" class="st0" width="24.063" height="8.016"></rect> <rect x="220.906" y="231.313" class="st0" width="24.063" height="8.016"></rect> <rect x="420.531" y="270.078" class="st0" width="8.016" height="24.063"></rect> <rect x="164.734" y="231.313" class="st0" width="24.078" height="8.016"></rect> <path class="st0" d="M39.563,442.203c1.766,6.984,6.203,15.813,13,22.516l5.609-5.734c-5.484-5.297-9.516-13.328-10.828-18.719 L39.563,442.203z"></path> <rect x="197.672" y="465.297" class="st0" width="24.078" height="8.031"></rect> <rect x="310" y="465.297" class="st0" width="24.063" height="8.031"></rect> <path class="st0" d="M428.547,437.219v-3.5h-8.016v3.5c0,6.313-2.063,12.094-5.563,16.781l6.438,4.797 C425.891,452.797,428.547,445.297,428.547,437.219z"></path> <rect x="85.344" y="465.297" class="st0" width="24.078" height="8.031"></rect> <rect x="253.828" y="465.297" class="st0" width="24.078" height="8.031"></rect> <rect x="366.156" y="465.297" class="st0" width="24.063" height="8.031"></rect> <rect x="141.516" y="465.297" class="st0" width="24.063" height="8.031"></rect> </g> </g></svg>              
                                          <div class="text-center mb-0 sh-8 d-flex align-items-center lh-1-5">
                                              {{__('Total')}}
                                            <br />
                                            {{__('Bills')}}
                                          </div>
                                          <div class="display-6 text-primary">{{\Auth::user()->countBills()}} </div>
                                        </div>
                                      </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-12">
                            <div class="card mb-5 hover-border-primary">
                                <div class="card-header">
                                    <h5>{{__('Income & Expense')}}
                                        <span class="float-end  text-primary">{{__('Current Year').' - '.$currentYear}}</span>
                                    </h5>

                                </div>
                                <div class="card-body">
                                    <div id="incExpBarChart"></div>
                                </div>
                            </div>
                        </div>
                
                        <div class="col-md-12">
                            <div class="card hover-border-primary">
                                <div class="card-header">
                                    <h5 class="mt-1 mb-0">{{__('Account Balance')}}</h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th>{{__('Bank')}}</th>
                                                <th>{{__('Holder Name')}}</th>
                                                <th>{{__('Balance')}}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @forelse($bankAccountDetail as $bankAccount)

                                                <tr class="font-style">
                                                    <td>{{$bankAccount->bank_name}}</td>
                                                    <td>{{$bankAccount->holder_name}}</td>
                                                    <td>{{\Auth::user()->priceFormat($bankAccount->opening_balance)}}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="4">
                                                        <div class="text-center">
                                                            <h6>{{__('there is no account balance')}}</h6>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-12">
                            <div class="card hover-border-primary">
                                <div class="card-header">
                                    <h5 class="mt-1 mb-0">{{__('Latest Income')}}</h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th>{{__('Date')}}</th>
                                                <th>{{__('Customer')}}</th>
                                                <th>{{__('Amount Due')}}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @forelse($latestIncome as $income)
                                                <tr>
                                                    <td>{{\Auth::user()->dateFormat($income->date)}}</td>
                                                    <td>{{!empty($income->customer)?$income->customer->name:'-'}}</td>
                                                    <td>{{\Auth::user()->priceFormat($income->amount)}}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="4">
                                                        <div class="text-center">
                                                            <h6>{{__('There is no latest income')}}</h6>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-12">
                            <div class="card hover-border-primary">
                                <div class="card-header">
                                    <h5 class="mt-1 mb-0">{{__('Latest Expense')}}</h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th>{{__('Date')}}</th>
                                                <th>{{__('Vendor')}}</th>
                                                <th>{{__('Amount Due')}}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @forelse($latestExpense as $expense)

                                                <tr>
                                                    <td>{{\Auth::user()->dateFormat($expense->date)}}</td>
                                                    <td>{{!empty($expense->vender)?$expense->vender->name:'-'}}</td>
                                                    <td>{{\Auth::user()->priceFormat($expense->amount)}}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="4">
                                                        <div class="text-center">
                                                            <h6>{{__('There is no latest expense')}}</h6>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-xxl-12">
                            <div class="card hover-border-primary">
                                <div class="card-header">
                                    <h5 class="mt-1 mb-0">{{__('Recent Invoices')}}</h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>{{__('Customer')}}</th>
                                                <th>{{__('Issue Date')}}</th>
                                                <th>{{__('Due Date')}}</th>
                                                <th>{{__('Amount')}}</th>
                                                <th>{{__('Status')}}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @forelse($recentInvoice as $invoice)
                                                <tr>
                                                    <td>{{\Auth::user()->invoiceNumberFormat($invoice->invoice_id)}}</td>
                                                    <td>{{!empty($invoice->customer)? $invoice->customer->name:'' }} </td>
                                                    <td>{{ Auth::user()->dateFormat($invoice->issue_date) }}</td>
                                                    <td>{{ Auth::user()->dateFormat($invoice->due_date) }}</td>
                                                    <td>{{\Auth::user()->priceFormat($invoice->getTotal())}}</td>
                                                    <td>
                                                        @if($invoice->status == 0)
                                                            <span class="p-2 px-3 rounded badge status_badge bg-secondary">{{ __(\App\Models\Invoice::$statues[$invoice->status]) }}</span>
                                                        @elseif($invoice->status == 1)
                                                            <span class="p-2 px-3 rounded badge status_badge bg-warning">{{ __(\App\Models\Invoice::$statues[$invoice->status]) }}</span>
                                                        @elseif($invoice->status == 2)
                                                            <span class="p-2 px-3 rounded badge status_badge bg-danger">{{ __(\App\Models\Invoice::$statues[$invoice->status]) }}</span>
                                                        @elseif($invoice->status == 3)
                                                            <span class="p-2 px-3 rounded badge status_badge bg-info">{{ __(\App\Models\Invoice::$statues[$invoice->status]) }}</span>
                                                        @elseif($invoice->status == 4)
                                                            <span class="p-2 px-3 rounded badge status_badge bg-primary">{{ __(\App\Models\Invoice::$statues[$invoice->status]) }}</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6">
                                                        <div class="text-center">
                                                            <h6>{{__('There is no recent invoice')}}</h6>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-12">
                            <div class="card hover-border-primary">
                                <div class="card-header">
                                    <h5 class="mt-1 mb-0">{{__('Recent Bills')}}</h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>{{__('Vendor')}}</th>
                                                <th>{{__('Bill Date')}}</th>
                                                <th>{{__('Due Date')}}</th>
                                                <th>{{__('Amount')}}</th>
                                                <th>{{__('Status')}}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @forelse($recentBill as $bill)
                                                <tr>
                                                    <td>{{\Auth::user()->billNumberFormat($bill->bill_id)}}</td>
                                                    <td>{{!empty($bill->vender)? $bill->vender->name:'' }} </td>
                                                    <td>{{ Auth::user()->dateFormat($bill->bill_date) }}</td>
                                                    <td>{{ Auth::user()->dateFormat($bill->due_date) }}</td>
                                                    <td>{{\Auth::user()->priceFormat($bill->getTotal())}}</td>
                                                    <td>
                                                        @if($bill->status == 0)
                                                            <span class="p-2 px-3 rounded badge bg-secondary">{{ __(\App\Models\Bill::$statues[$bill->status]) }}</span>
                                                        @elseif($bill->status == 1)
                                                            <span class="p-2 px-3 rounded badge bg-warning">{{ __(\App\Models\Bill::$statues[$bill->status]) }}</span>
                                                        @elseif($bill->status == 2)
                                                            <span class="p-2 px-3 rounded badge bg-danger">{{ __(\App\Models\Bill::$statues[$bill->status]) }}</span>
                                                        @elseif($bill->status == 3)
                                                            <span class="p-2 px-3 rounded badge bg-info">{{ __(\App\Models\Bill::$statues[$bill->status]) }}</span>
                                                        @elseif($bill->status == 4)
                                                            <span class="p-2 px-3 rounded badge bg-primary">{{ __(\App\Models\Bill::$statues[$bill->status]) }}</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6">
                                                        <div class="text-center">
                                                            <h6>{{__('There is no recent bill')}}</h6>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-xxl-5">
                    <div class="row">
                        <div class="col-12">
                            <div class="card hover-border-primary">
                                <div class="card-header">
                                    <h5 class="mt-1 mb-0">{{__('Cashflow')}}</h5>
                                </div>
                                <div class="card-body">
                                    <div id="cash-flow"></div>
                                </div>
                            </div>



                            <div class="card hover-border-primary">
                                <div class="card-header">
                                    <h5 class="mt-1 mb-0">{{__('Income Vs Expense')}}</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 col-6 my-2">
                                            <div class="d-flex align-items-start mb-2">
                                                <div class="sw-8 sh-8 rounded-xl d-flex justify-content-center align-items-center border border-primary ">

<svg fill="#0ec4cb" width="64px" height="64px" viewBox="-563.2 -563.2 2150.40 2150.40" xmlns="http://www.w3.org/2000/svg" stroke="#0ec4cb" stroke-width="0.01024"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M277.675 981.521c5.657 0 10.24-4.583 10.24-10.24V499.514c0-5.651-4.588-10.24-10.24-10.24h-81.92c-5.652 0-10.24 4.589-10.24 10.24v471.767c0 5.657 4.583 10.24 10.24 10.24h81.92zm0 40.96h-81.92c-28.278 0-51.2-22.922-51.2-51.2V499.514c0-28.271 22.924-51.2 51.2-51.2h81.92c28.276 0 51.2 22.929 51.2 51.2v471.767c0 28.278-22.922 51.2-51.2 51.2zm275.456-40.96c5.657 0 10.24-4.583 10.24-10.24V408.777c0-5.657-4.583-10.24-10.24-10.24h-81.92a10.238 10.238 0 00-10.24 10.24v562.504c0 5.657 4.583 10.24 10.24 10.24h81.92zm0 40.96h-81.92c-28.278 0-51.2-22.922-51.2-51.2V408.777c0-28.278 22.922-51.2 51.2-51.2h81.92c28.278 0 51.2 22.922 51.2 51.2v562.504c0 28.278-22.922 51.2-51.2 51.2zm275.456-40.016c5.657 0 10.24-4.583 10.24-10.24V318.974c0-5.651-4.588-10.24-10.24-10.24h-81.92c-5.652 0-10.24 4.589-10.24 10.24v653.251c0 5.657 4.583 10.24 10.24 10.24h81.92zm0 40.96h-81.92c-28.278 0-51.2-22.922-51.2-51.2V318.974c0-28.271 22.924-51.2 51.2-51.2h81.92c28.276 0 51.2 22.929 51.2 51.2v653.251c0 28.278-22.922 51.2-51.2 51.2zM696.848 40.96l102.39.154c11.311.017 20.494-9.138 20.511-20.449S810.611.171 799.3.154L696.91 0c-11.311-.017-20.494 9.138-20.511 20.449s9.138 20.494 20.449 20.511z"></path><path d="M778.789 20.571l-.307 101.827c-.034 11.311 9.107 20.508 20.418 20.542s20.508-9.107 20.542-20.418l.307-101.827C819.783 9.384 810.642.187 799.331.153s-20.508 9.107-20.542 20.418z"></path><path d="M163.84 317.682h154.184a51.207 51.207 0 0036.211-14.999L457.208 199.71a10.263 10.263 0 017.237-3.003h159.754a51.235 51.235 0 0036.198-14.976l141.13-141.13c7.998-7.998 7.998-20.965 0-28.963s-20.965-7.998-28.963 0L631.447 152.755a10.265 10.265 0 01-7.248 2.992H464.445a51.226 51.226 0 00-36.201 14.999L325.271 273.719a10.244 10.244 0 01-7.248 3.003H163.839c-11.311 0-20.48 9.169-20.48 20.48s9.169 20.48 20.48 20.48z"></path></g></svg>

                                                </div>
                                                <div class="ms-2">
                                                    <p class="text-primary text-pt mb-0">{{__('Income Today')}}</p>
                                                    <h4 class="mb-0 text-success">{{\Auth::user()->priceFormat(\Auth::user()->todayIncome())}}</h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-6 my-2">
                                            <div class="d-flex align-items-start mb-2">
                                                <div class="sw-8 sh-8 rounded-xl d-flex justify-content-center align-items-center border border-primary">

                                                    <svg width="64px" height="64px" viewBox="-4.8 -4.8 57.60 57.60" id="a" xmlns="http://www.w3.org/2000/svg" fill="#0ec4cb"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <defs> <style>.p{fill:none;stroke:#0ec4cb;stroke-linecap:round;stroke-linejoin:round;}</style> </defs> <g id="b"> <path id="c" class="p" d="M16.5169,14.3442l7.7047-4.801,10.2741,8.6883v12.5665l-5.9671,4.836v-11.8175l-12.0117-9.4722Z"></path> <path id="d" class="p" d="M26.0581,9.2578l5.8416-3.6121,10.4601,7.293-6.4328,4.9258"></path> <path id="e" class="p" d="M36.2041,28.6126l6.2959-5.1397"></path> <path id="f" class="p" d="M36.2041,25.9523l6.2959-5.1397"></path> <path id="g" class="p" d="M36.2041,23.292l6.2959-5.1397"></path> <path id="h" class="p" d="M36.2041,20.6317l6.2959-5.1397"></path> <path id="i" class="p" d="M35.3139,14.172l2.7236-2.077-1.865-1.2474-1.4987,1.1314"></path> <path id="j" class="p" d="M5.5,31.9538l13.5429,10.4006,7.4233-5.9106"></path> <path id="k" class="p" d="M5.5,29.2851l13.5429,10.4006,7.4233-5.9106"></path> <path id="l" class="p" d="M5.6039,26.6164l13.5429,10.4006,7.4233-5.9106"></path> <path id="m" class="p" d="M5.5892,23.9478l13.5429,10.4006,7.4233-5.9106"></path> <path id="n" class="p" d="M20.2345,23.7501c-.226,1.0274-1.6933,1.5535-3.2773,1.1753h0c-1.5841-.3783-2.685-1.5178-2.459-2.5451,.226-1.0274,1.6933-1.5535,3.2773-1.1753s2.685,1.5177,2.459,2.5451Z"></path> <path id="o" class="p" d="M15.0514,15.826l-9.2955,5.5946,13.3311,10.1174,7.6392-6.0147"></path> </g> </g></svg>
                                                </div>
                                                <div class="ms-2">
                                                    <p class="text-primary text-sm mb-0">{{__('Expense Today')}}</p>
                                                    <h4 class="mb-0 text-info">{{\Auth::user()->priceFormat(\Auth::user()->todayExpense())}}</h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-6 my-2">
                                            <div class="d-flex align-items-start mb-2">
                                                <div class="sw-8 sh-8 rounded-xl d-flex justify-content-center align-items-center border border-primary">

<svg width="64px" height="64px" viewBox="-215.04 -215.04 1454.08 1454.08" fill="#0ec4cb" class="icon" version="1.1" xmlns="http://www.w3.org/2000/svg" stroke="#0ec4cb"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M232.016 448.004c-4.42 0-8-3.578-8-8V168.022c0-4.422 3.578-8 8-8 4.422 0 8 3.578 8 8v271.982c0 4.422-3.578 8-8 8z" fill=""></path><path d="M536 448.004H232.016c-4.42 0-8-3.578-8-8 0-4.42 3.578-8 8-8H536c4.422 0 8 3.578 8 8 0 4.422-3.578 8-8 8zM264.014 384.008a8 8 0 0 1-5.656-13.656l95.994-95.994a8 8 0 1 1 11.312 11.312l-95.994 95.994a7.974 7.974 0 0 1-5.656 2.344z" fill=""></path><path d="M408.006 336.01a7.976 7.976 0 0 1-5.656-2.344l-47.998-47.998a8 8 0 1 1 11.312-11.312l47.998 47.998a8 8 0 0 1-5.656 13.656z" fill=""></path><path d="M408.006 336.01a8 8 0 0 1-5.656-13.656l127.994-127.992a8 8 0 1 1 11.312 11.312l-127.994 127.992a7.964 7.964 0 0 1-5.656 2.344z" fill=""></path><path d="M536 240.016c-4.422 0-8-3.578-8-8V200.02c0-4.422 3.578-8 8-8s8 3.578 8 8v31.998a7.994 7.994 0 0 1-8 7.998z" fill=""></path><path d="M536 208.018h-32c-4.422 0-8-3.578-8-8 0-4.422 3.578-8 8-8h32c4.422 0 8 3.578 8 8 0 4.422-3.578 8-8 8zM624.008 80.026h-224a8.002 8.002 0 0 1-6.656-3.562l-31.998-47.998a7.992 7.992 0 0 1 2.218-11.092 7.99 7.99 0 0 1 11.094 2.218l29.624 44.434h216.408l45.64-45.654a8 8 0 0 1 11.308 11.312l-47.98 47.998a8.004 8.004 0 0 1-5.658 2.344zM352.01 64.028H168.02c-4.42 0-8-3.578-8-8 0-4.42 3.578-8 8-8h183.99c4.42 0 8 3.578 8 8a7.998 7.998 0 0 1-8 8zM855.98 64.028h-183.988c-4.422 0-8-3.578-8-8 0-4.42 3.578-8 8-8h183.988c4.422 0 8 3.578 8 8 0 4.422-3.578 8-8 8z" fill=""></path><path d="M575.996 48.028h-127.992c-4.42 0-8-3.578-8-8 0-4.422 3.578-8 8-8h127.992c4.422 0 8 3.578 8 8 0 4.422-3.578 8-8 8zM823.98 879.976h-63.996c-4.422 0-8-3.578-8-7.998 0-4.422 3.578-8 8-8h63.996c4.422 0 8 3.578 8 8a7.994 7.994 0 0 1-8 7.998z" fill=""></path><path d="M759.984 943.972c-4.422 0-8-3.578-8-7.998v-63.996c0-4.422 3.578-8 8-8s8 3.578 8 8v63.996a7.994 7.994 0 0 1-8 7.998zM384.008 863.978c-79.394 0-143.992-64.59-143.992-143.99 0-79.402 64.598-143.992 143.992-143.992S528 640.586 528 719.988c0 79.4-64.598 143.99-143.992 143.99z m0-271.982c-70.574 0-127.992 57.418-127.992 127.992 0 70.572 57.418 127.992 127.992 127.992S512 790.56 512 719.988c0-70.574-57.418-127.992-127.992-127.992z" fill=""></path><path d="M384.008 895.976c-79.394 0-143.992-64.59-143.992-143.992a7.994 7.994 0 0 1 8-7.998c4.42 0 8 3.578 8 7.998 0 70.574 57.418 127.992 127.992 127.992S512 822.558 512 751.984c0-4.42 3.578-7.998 8-7.998s8 3.578 8 7.998c0 79.402-64.598 143.992-143.992 143.992z" fill=""></path><path d="M248.016 759.984c-4.422 0-8-3.578-8-8v-31.996c0-4.422 3.578-8 8-8 4.42 0 8 3.578 8 8v31.996c0 4.422-3.578 8-8 8zM520 759.984c-4.422 0-8-3.578-8-8v-31.996c0-4.422 3.578-8 8-8s8 3.578 8 8v31.996c0 4.422-3.578 8-8 8zM384.008 783.984c-35.288 0-63.996-28.704-63.996-63.996 0-35.296 28.708-63.996 63.996-63.996s63.996 28.7 63.996 63.996c0 35.294-28.71 63.996-63.996 63.996z m0-111.994c-26.468 0-47.998 21.53-47.998 47.998 0 26.466 21.53 47.996 47.998 47.996s47.998-21.53 47.998-47.996c-0.002-26.468-21.53-47.998-47.998-47.998z" fill=""></path><path d="M437.692 743.986a8.018 8.018 0 0 1-7.672-5.718c-6-20.186-24.92-34.28-46.012-34.28s-40.012 14.094-46.012 34.28c-1.266 4.234-5.672 6.624-9.954 5.39a8.012 8.012 0 0 1-5.39-9.954c8.006-26.92 33.232-45.716 61.356-45.716s53.348 18.796 61.356 45.716a8.012 8.012 0 0 1-5.39 9.954 8.336 8.336 0 0 1-2.282 0.328zM343.932 687.91a7.976 7.976 0 0 1-5.656-2.344l-56.074-56.074a7.996 7.996 0 1 1 11.31-11.31l56.076 56.074a7.996 7.996 0 0 1-5.656 13.654zM384.008 863.978c-4.42 0-8-3.578-8-8v-79.994c0-4.422 3.578-8 8-8s8 3.578 8 8v79.994a7.998 7.998 0 0 1-8 8zM791.984 671.99h-191.988c-4.422 0-8-3.578-8-8a7.994 7.994 0 0 1 8-7.998h191.988c4.422 0 8 3.578 8 7.998 0 4.422-3.578 8-8 8zM791.984 719.988h-191.988c-4.422 0-8-3.578-8-8s3.578-8 8-8h191.988c4.422 0 8 3.578 8 8s-3.578 8-8 8zM791.984 767.984h-191.988c-4.422 0-8-3.578-8-8s3.578-8 8-8h191.988c4.422 0 8 3.578 8 8s-3.578 8-8 8z" fill=""></path><path d="M679.988 815.98h-79.992c-4.422 0-8-3.578-8-7.998 0-4.422 3.578-8 8-8h79.992c4.422 0 8 3.578 8 8a7.994 7.994 0 0 1-8 7.998z" fill=""></path><path d="M791.984 256.016h-191.988c-4.422 0-8-3.578-8-8 0-4.42 3.578-8 8-8h191.988c4.422 0 8 3.578 8 8 0 4.422-3.578 8-8 8z" fill=""></path><path d="M791.984 304.012h-191.988c-4.422 0-8-3.578-8-8 0-4.422 3.578-8 8-8h191.988c4.422 0 8 3.578 8 8 0 4.422-3.578 8-8 8z" fill=""></path><path d="M791.984 352.01h-191.988c-4.422 0-8-3.578-8-8 0-4.42 3.578-8 8-8h191.988c4.422 0 8 3.578 8 8 0 4.422-3.578 8-8 8z" fill=""></path><path d="M679.988 400.006h-79.992c-4.422 0-8-3.578-8-8 0-4.422 3.578-8 8-8h79.992c4.422 0 8 3.578 8 8 0 4.422-3.578 8-8 8z" fill=""></path><path d="M168.02 975.972c-4.42 0-8-3.578-8-8V56.028c0-4.42 3.578-8 8-8 4.422 0 8 3.578 8 8v911.946a7.994 7.994 0 0 1-8 7.998z" fill=""></path><path d="M855.98 895.976c-4.422 0-8-3.578-8-8V56.028c0-4.42 3.578-8 8-8s8 3.578 8 8v831.95a7.994 7.994 0 0 1-8 7.998z" fill=""></path><path d="M775.984 975.972a8 8 0 0 1-5.656-13.656l79.996-79.996a8 8 0 1 1 11.312 11.312l-79.996 79.996a7.964 7.964 0 0 1-5.656 2.344z" fill=""></path><path d="M775.984 975.972H168.02c-4.42 0-8-3.578-8-8s3.578-8 8-8h607.964c4.422 0 8 3.578 8 8s-3.578 8-8 8z" fill=""></path><path d="M903.976 1023.968c-4.422 0-8-3.578-8-8V8.032c0-4.422 3.578-8 8-8s8 3.578 8 8v1007.938a7.994 7.994 0 0 1-8 7.998z" fill=""></path><path d="M903.976 1023.968H120.024c-4.422 0-8-3.578-8-8s3.578-8 8-8h783.952c4.422 0 8 3.578 8 8s-3.578 8-8 8z" fill=""></path><path d="M120.024 1023.968c-4.422 0-8-3.578-8-8V8.032c0-4.422 3.578-8 8-8 4.42 0 8 3.578 8 8v1007.938a7.994 7.994 0 0 1-8 7.998z" fill=""></path><path d="M903.976 16.03H120.024c-4.422 0-8-3.578-8-8 0-4.422 3.578-8 8-8h783.952c4.422 0 8 3.578 8 8 0 4.422-3.578 8-8 8z" fill=""></path><path d="M791.984 528H232.008c-4.42 0-8-3.578-8-8s3.578-8 8-8h559.976c4.422 0 8 3.578 8 8s-3.578 8-8 8z" fill=""></path></g></svg>
                                                </div>
                                                <div class="ms-2">
                                                    <p class="text-primary text-sm mb-0">{{__('Income This Month')}}</p>
                                                        <h4 class="mb-0 text-warning">{{\Auth::user()->priceFormat(\Auth::user()->incomeCurrentMonth())}}</h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-6 my-2">
                                            <div class="d-flex align-items-start mb-2">
                                                <div class="sw-8 sh-8 rounded-xl d-flex justify-content-center align-items-center border border-primary">

                                                    <svg width="64px" height="64px" viewBox="-5.28 -5.28 58.56 58.56" id="a" xmlns="http://www.w3.org/2000/svg" fill="#0ec4cb" stroke="#0ec4cb"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><defs><style>.f{fill:none;stroke:#0ec4cb;stroke-linecap:round;stroke-linejoin:round;}</style></defs><rect id="b" class="f" x="6.9608" y="13.065" width="7.5178" height="21.87"></rect><rect id="c" class="f" x="20.7926" y="18.5325" width="7.5178" height="16.4025"></rect><rect id="d" class="f" x="34.994" y="27.4172" width="7.5178" height="7.5178"></rect><path id="e" class="f" d="m4.5,34.9237l14.2938-11.4905,12.4763,4.4976,12.2299-9.4265"></path></g></svg>                                                    
                                                </div>
                                                <div class="ms-2">
                                                    <p class="text-primary text-sm mb-0">{{__('Expense This Month')}}</p>
                                                    <h4 class="mb-0 text-danger">{{\Auth::user()->priceFormat(\Auth::user()->expenseCurrentMonth())}}</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xxl-12">
                            <div class="card hover-border-primary">
                                <div class="card-header">
                                    <h5>{{__('Storage Limit')}}
{{--                                        <span class="float-end text-muted">{{__('Year').' - '.$currentYear}}</span>--}}
                                        <small class="float-end text-primary">{{ $users->storage_limit . 'MB' }} / {{ $plan->storage_limit . 'MB' }}</small>
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div id="limit-chart"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xxl-12">
                            <div class="card hover-border-primary">
                                <div class="card-header">
                                    <h5>{{__('Income By Category')}}
                                        <span class="float-end text-primary">{{__('Year').' - '.$currentYear}}</span>
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div id="incomeByCategory"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-12">
                            <div class="card hover-border-primary">
                                <div class="card-header">
                                    <h5>{{__('Expense By Category')}}
                                        <span class="float-end text-primary">{{__('Year').' - '.$currentYear}}</span>
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div id="expenseByCategory"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xxl-12">
                            <div class="card hover-border-primary">
                                <div class="card-body">

                                    <ul class="nav nav-pills mb-5" id="pills-tab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" href="#invoice_weekly_statistics" role="tab" aria-controls="pills-home" aria-selected="true">{{__('Invoices Weekly Statistics')}}</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" href="#invoice_monthly_statistics" role="tab" aria-controls="pills-profile" aria-selected="false">{{__('Invoices Monthly Statistics')}}</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="pills-tabContent">
                                        <div class="tab-pane fade show active" id="invoice_weekly_statistics" role="tabpanel" aria-labelledby="pills-home-tab">
                                            <div class="table-responsive">
                                                <table class="table align-items-center mb-0 ">
                                                    <tbody class="list">
                                                    <tr>
                                                        <td>
                                                            <h5 class="mb-0">{{__('Total')}}</h5>
                                                            <p class="text-primary text-sm mb-0">{{__('Invoice Generated')}}</p>

                                                        </td>
                                                        <td>
                                                            <h4 class="text-primary">{{\Auth::user()->priceFormat($weeklyInvoice['invoiceTotal'])}}</h4>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <h5 class="mb-0">{{__('Total')}}</h5>
                                                            <p class="text-primary text-sm mb-0">{{__('Paid')}}</p>
                                                        </td>
                                                        <td>
                                                            <h4 class="text-primary">{{\Auth::user()->priceFormat($weeklyInvoice['invoicePaid'])}}</h4>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <h5 class="mb-0">{{__('Total')}}</h5>
                                                            <p class="text-primary text-sm mb-0">{{__('Due')}}</p>
                                                        </td>
                                                        <td>
                                                            <h4 class="text-primary">{{\Auth::user()->priceFormat($weeklyInvoice['invoiceDue'])}}</h4>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="invoice_monthly_statistics" role="tabpanel" aria-labelledby="pills-profile-tab">
                                            <div class="table-responsive">
                                                <table class="table align-items-center mb-0 ">
                                                    <tbody class="list">
                                                    <tr>
                                                        <td>
                                                            <h5 class="mb-0">{{__('Total')}}</h5>
                                                            <p class="text-primary text-sm mb-0">{{__('Invoice Generated')}}</p>

                                                        </td>
                                                        <td>
                                                            <h4 class="text-primary">{{\Auth::user()->priceFormat($monthlyInvoice['invoiceTotal'])}}</h4>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <h5 class="mb-0">{{__('Total')}}</h5>
                                                            <p class="text-primary text-sm mb-0">{{__('Paid')}}</p>
                                                        </td>
                                                        <td>
                                                            <h4 class="text-primary">{{\Auth::user()->priceFormat($monthlyInvoice['invoicePaid'])}}</h4>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <h5 class="mb-0">{{__('Total')}}</h5>
                                                            <p class="text-primary text-sm mb-0">{{__('Due')}}</p>
                                                        </td>
                                                        <td>
                                                            <h4 class="text-primary">{{\Auth::user()->priceFormat($monthlyInvoice['invoiceDue'])}}</h4>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-12">
                            <div class="card hover-border-primary">
                                <div class="card-body">

                                    <ul class="nav nav-pills mb-5" id="pills-tab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" href="#bills_weekly_statistics" role="tab" aria-controls="pills-home" aria-selected="true">{{__('Bills Weekly Statistics')}}</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" href="#bills_monthly_statistics" role="tab" aria-controls="pills-profile" aria-selected="false">{{__('Bills Monthly Statistics')}}</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="pills-tabContent">
                                        <div class="tab-pane fade show active" id="bills_weekly_statistics" role="tabpanel" aria-labelledby="pills-home-tab">
                                            <div class="table-responsive">
                                                <table class="table align-items-center mb-0 ">
                                                    <tbody class="list">
                                                    <tr>
                                                        <td>
                                                            <h5 class="mb-0">{{__('Total')}}</h5>
                                                            <p class="text-primary text-sm mb-0">{{__('Bill Generated')}}</p>

                                                        </td>
                                                        <td>
                                                            <h4 class="text-primary">{{\Auth::user()->priceFormat($weeklyBill['billTotal'])}}</h4>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <h5 class="mb-0">{{__('Total')}}</h5>
                                                            <p class="text-primary text-sm mb-0">{{__('Paid')}}</p>
                                                        </td>
                                                        <td>
                                                            <h4 class="text-primary">{{\Auth::user()->priceFormat($weeklyBill['billPaid'])}}</h4>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <h5 class="mb-0">{{__('Total')}}</h5>
                                                            <p class="text-primary text-sm mb-0">{{__('Due')}}</p>
                                                        </td>
                                                        <td>
                                                            <h4 class="text-primary">{{\Auth::user()->priceFormat($weeklyBill['billDue'])}}</h4>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="bills_monthly_statistics" role="tabpanel" aria-labelledby="pills-profile-tab">
                                            <div class="table-responsive">
                                                <table class="table align-items-center mb-0 ">
                                                    <tbody class="list">
                                                    <tr>
                                                        <td>
                                                            <h5 class="mb-0">{{__('Total')}}</h5>
                                                            <p class="text-primary text-sm mb-0">{{__('Bill Generated')}}</p>

                                                        </td>
                                                        <td>
                                                            <h4 class="text-primary">{{\Auth::user()->priceFormat($monthlyBill['billTotal'])}}</h4>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <h5 class="mb-0">{{__('Total')}}</h5>
                                                            <p class="text-primary text-sm mb-0">{{__('Paid')}}</p>
                                                        </td>
                                                        <td>
                                                            <h4 class="text-primary">{{\Auth::user()->priceFormat($monthlyBill['billPaid'])}}</h4>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <h5 class="mb-0">{{__('Total')}}</h5>
                                                            <p class="text-primary text-sm mb-0">{{__('Due')}}</p>
                                                        </td>
                                                        <td>
                                                            <h4 class="text-primary">{{\Auth::user()->priceFormat($monthlyBill['billDue'])}}</h4>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-12">
                    <div class="card hover-border-primary">
                        <div class="card-header">
                            <h5>{{__('Goal')}}</h5>
                        </div>
                        <div class="card-body">
                            @forelse($goals as $goal)
                                @php
                                    $total= $goal->target($goal->type,$goal->from,$goal->to,$goal->amount)['total'];
                                    $percentage=$goal->target($goal->type,$goal->from,$goal->to,$goal->amount)['percentage'];
                                    $per=number_format($goal->target($goal->type,$goal->from,$goal->to,$goal->amount)['percentage'], Utility::getValByName('decimal_number'), '.', '');
                                @endphp
                                <div class="card border-success border-2 border-bottom-0 border-start-0 border-end-0">
                                    <div class="card-body">
                                        <div class="form-check">
                                            <label class="form-check-label d-block" for="customCheckdef1">
                                                <span>
                                                    <span class="row align-items-center">
                                                        <span class="col">
                                                            <span class="text-primary text-sm">{{__('Name')}}</span>
                                                            <h6 class="text-nowrap mb-3 mb-sm-0">{{$goal->name}}</h6>
                                                        </span>
                                                        <span class="col">
                                                            <span class="text-primary text-sm">{{__('Type')}}</span>
                                                            <h6 class="mb-3 mb-sm-0">{{ __(\App\Models\Goal::$goalType[$goal->type]) }}</h6>
                                                        </span>
                                                        <span class="col">
                                                            <span class="text-primary text-sm">{{__('Duration')}}</span>
                                                            <h6 class="mb-3 mb-sm-0">{{$goal->from .' To '.$goal->to}}</h6>
                                                        </span>
                                                        <span class="col">
                                                            <span class="text-primary text-sm">{{__('Target')}}</span>
                                                            <h6 class="mb-3 mb-sm-0">{{\Auth::user()->priceFormat($total).' of '. \Auth::user()->priceFormat($goal->amount)}}</h6>
                                                        </span>
                                                        <span class="col">
                                                            <span class="text-primary text-sm">{{__('Progress')}}</span>
                                                            <h6 class="mb-2 d-block">{{number_format($goal->target($goal->type,$goal->from,$goal->to,$goal->amount)['percentage'], Utility::getValByName('decimal_number'), '.', '')}}%</h6>
                                                            <div class="progress mb-0">
                                                                @if($per<=33)
                                                                    <div class="progress-bar bg-danger" style="width: {{$per}}%"></div>
                                                                @elseif($per>=33 && $per<=66)
                                                                    <div class="progress-bar bg-warning" style="width: {{$per}}%"></div>
                                                                @else
                                                                    <div class="progress-bar bg-primary" style="width: {{$per}}%"></div>
                                                                @endif
                                                            </div>
                                                        </span>
                                                    </span>
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <div class="card pb-0">
                                    <div class="card-body text-center">
                                        <h6>{{__('There is no goal.')}}</h6>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
