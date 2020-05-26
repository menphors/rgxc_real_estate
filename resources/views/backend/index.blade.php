@extends('backend.app')

@section("title")
{{__('Dashboard')}}
@endsection

@section('content')
<section class="content">
  <div class="container-fluid">
    <div class="kt-portlet">
      <div class="kt-portlet__body kt-portlet__body--fit">
        <div class="row row-no-padding row-col-separator-lg">
          <div class="col-md-3">
            <div class="kt-widget24">
              <div class="kt-widget24__details">
                <div class="kt-widget24__info">
                  <h4 class="kt-widget24__title">{{__('Staffs')}}</h4>
                  <span class="kt-widget24__desc">
                    <a href="{{ url('administrator/staff') }}" title="">{{__('View Detail')}}</a>
                  </span>
                </div>

                <span class="kt-widget24__stats kt-font-brand">{{ $total['staff'] }}</span>
              </div>

              <div class="progress progress--sm">
                <div class="progress-bar kt-bg-brand" role="progressbar" style="width: 80%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
            </div>
          </div>

          <div class="col-md-3">
            <div class="kt-widget24">
              <div class="kt-widget24__details">
                <div class="kt-widget24__info">
                  <h4 class="kt-widget24__title">{{__('Sales')}}</h4>
                  <span class="kt-widget24__desc">
                    <a href="{{ url('administrator/sale') }}" title="">{{__('View Detail')}}</a>
                  </span>
                </div>

                <span class="kt-widget24__stats kt-font-warning">{{ $total['sale'] }}</span>
              </div>

              <div class="progress progress--sm">
                <div class="progress-bar kt-bg-warning" role="progressbar" style="width: 80%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
            </div>
          </div>

          <div class="col-md-3">
            <div class="kt-widget24">
              <div class="kt-widget24__details">
                <div class="kt-widget24__info">
                  <h4 class="kt-widget24__title">{{ __('Properties') }}</h4>
                  <span class="kt-widget24__desc">
                    <a href="{{ url('administrator/property') }}" title="">{{__('View Detail')}}</a>
                  </span>
                </div>

                <span class="kt-widget24__stats kt-font-danger">{{ $total['property'] }}</span>
              </div>

              <div class="progress progress--sm">
                <div class="progress-bar kt-bg-danger" role="progressbar" style="width: 80%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
            </div>
          </div>

          <div class="col-md-3">
            <div class="kt-widget24">
              <div class="kt-widget24__details">
                <div class="kt-widget24__info">
                  <h4 class="kt-widget24__title">{{__('Customer')}}</h4>
                  <span class="kt-widget24__desc">
                    <a href="{{ url('administrator/customer') }}" title="">{{__('View Detail')}}</a>
                  </span>
                </div>

                <span class="kt-widget24__stats kt-font-success">{{ $total['customer'] }}</span>
              </div>

              <div class="progress progress--sm">
                <div class="progress-bar kt-bg-success" role="progressbar" style="width: 80%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-sm-6">
        <div class="kt-portlet kt-portlet--height-fluid">
          <div class="kt-widget14">
            <div class="kt-widget14__header">
              <h3 class="kt-widget14__title">{{ __('Summary Sales Revenue') }}</h3>
              <span class="kt-widget14__desc">{{__("Check out each month for sale revenue")}}</span>
            </div>
            <div class="kt-widget14__chart" style="height:234px;">
              <canvas id="kt_chart_daily_sales" style="display: block; width: 366px; height: 120px;" width="366" height="120" class="chartjs-render-monitor"></canvas>
            </div>
          </div>
        </div>
      </div>

      <div class="col-sm-6">
        <div class="kt-portlet kt-portlet--height-fluid">
          <div class="kt-widget14">
            <div class="kt-widget14__header">
              <h3 class="kt-widget14__title">{{__('Total Properties')}}: <b>{{ $properties['total'] }}</b></h3>
              <span class="kt-widget14__desc">{{__('Properties listing by status')}}</span>
            </div>
            <div class="kt-widget14__content">
              <div class="kt-widget14__chart">
                <div id="kt_chart_revenue_change" style="height: 150px; width: 150px;"></div>
              </div>       
              <div class="kt-widget14__legends">
                @foreach($properties['data'] as $key => $property)
                <div class="kt-widget14__legend">
                  <span class="kt-widget14__bullet" style="background-color:{{ $colors[$key] }}"></span>
                  <span class="kt-widget14__stats">{{$property['value']}} {{$property['label']}}</span>
                </div>
                @endforeach
              </div>     
            </div>   
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-sm-6">
        <div class="kt-portlet kt-portlet--height-fluid">
          <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
              <h3 class="kt-portlet__head-title">{{__('Latest Sales')}}</h3>
            </div>
          </div>
          <div class="kt-portlet__body">
            <div class="kt-widget4">
              @foreach($lateSales as $sale)
              <div class="kt-widget4__item">
                <span class="kt-widget4__icon">
                  <i class="flaticon-more-1"></i>
                </span>
                <a href="{{ route("administrator.sale-detail", $sale->id) }}" class="kt-widget4__title kt-widget4__title--light">{{ @$sale->ref_no }}</a>
                @if(@$sale->sale_detail->property->listing_type == "sale")
                <span class="kt-widget2__username badge badge-info">{{ __("Sale") }}</span>
                @else
                <span class="kt-widget2__username badge badge-danger">{{ __("Rent") }}</span>
                @endif
                <span class="kt-widget4__number kt-font-info">$ {{ number_format($sale->amount, 2) }}</span>
              </div>
              @endforeach
            </div>
          </div>
        </div>
      </div>

      <div class="col-sm-6">
        <div class="kt-portlet kt-portlet--tabs kt-portlet--height-fluid">
          <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
              <h3 class="kt-portlet__head-title">{{__('Latest Properties')}}</h3>
            </div>
            {{-- <div class="kt-portlet__head-toolbar">
              <ul class="nav nav-tabs nav-tabs-line nav-tabs-bold nav-tabs-line-brand" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" data-toggle="tab" href="#kt_widget4_tab1_content" role="tab">{{__('Today')}}</a>
                </li>
              </ul>
            </div> --}}
          </div>
          <div class="kt-portlet__body">
            <div class="tab-content">
              <div class="tab-pane active" id="kt_widget4_tab1_content"> 
                <div class="kt-widget4">
                  @foreach($lateProperties as $property)
                  <div class="kt-widget4__item">
                    <div class="kt-widget4__pic kt-widget4__pic--pic">
                      <img src="/metronic/themes/metronic/theme/default/demo6/dist/assets/media/users/100_4.jpg" alt="">   
                    </div>
                    <div class="kt-widget4__info">
                      <a href="{{ route("administrator.property-view", $property->id) }}" target="_blank" class="kt-widget4__username">{{ @$property->code }}</a>
                      <p class="kt-widget4__text">{{ $property->title }}</p>
                    </div>             
                    <?php
                    if(@$property->status == Constants::PROPERTY_STATUS["padding"]) {
                      echo "<span class='badge badge-danger'>". __("Pending")."</span>";
                    } 
                    elseif(@$property->status == Constants::PROPERTY_STATUS["submitted"]) {
                      echo "<span class='badge badge-info'>". __("Submitted")."</span>";
                    } 
                    elseif(@$property->status == Constants::PROPERTY_STATUS["reviewed"]) {
                      echo "<span class='badge badge-primary'>". __("Reviewed")."</span>";
                    } 
                    elseif(@$property->status == Constants::PROPERTY_STATUS["published"]) {
                      echo "<span class='badge badge-success'>". __("Published")."</span>";
                    } 
                    elseif(@$property->status == Constants::PROPERTY_STATUS["solved"]) {
                      echo "<span class='badge badge-dark'>". __("Solved")."</span>";
                    } 
                    elseif(@$property->status == Constants::PROPERTY_STATUS["deposit"]) {
                      echo "<span class='badge badge-secondary'>". __("Deposit")."</span>";
                    }
                    ?>
                  </div>
                  @endforeach
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

@section("script")
<script>
  $(document).ready(function() {
    var chartContainer = KTUtil.getByID('kt_chart_daily_sales');

    var chartData = {
      labels: {!! json_encode($sales['label']) !!},
      datasets: {!! json_encode($sales['datasets']) !!}
    };

    var chart = new Chart(chartContainer, {
      type: 'bar',
      data: chartData,
      options: {
        title: {
          display: false,
        },
        tooltips: {
          intersect: false,
          mode: 'nearest',
          xPadding: 10,
          yPadding: 10,
          caretPadding: 10
        },
        legend: {
          display: false
        },
        responsive: true,
        maintainAspectRatio: false,
        barRadius: 4,
        scales: {
          xAxes: [{
            ticks: {
              maxRotation: 90,
              minRotation: 80
            }
          }],
          yAxes: [{
            ticks: {
              beginAtZero: true
            }
          }]
        },
        layout: {
          padding: {
            left: 0,
            right: 0,
            top: 0,
            bottom: 0
          }
        }
      }
    });

    Morris.Donut({
      element: 'kt_chart_revenue_change',
      data: {!! json_encode($properties['data']) !!},
      colors: {!! json_encode($colors) !!},
    });
  });
</script>
@endsection