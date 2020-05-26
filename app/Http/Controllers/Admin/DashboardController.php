<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Property\Property;
use App\Model\Sale;
use App\Model\Staff\Staff;
use App\Model\Customer\Customer;
use DB;
use \Carbon\Carbon;
use \Carbon\CarbonPeriod;

class DashboardController extends Controller
{ 
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    // colors
    $colors = [ "#fd397a", "#17a2b8", "#5867dd", "#0abb87", "#545b62", "#fd397a", "#5867dd" ];

    $totalSale = Sale::query();
    $totalProperty = Property::query();
    $totalStaff = Staff::query();
    $totalCustomer = Customer::query();

    if(!\Auth::user()->hasRole('administrator')) {
      $totalSale->where('created_by', \Auth::user()->id);
      $totalProperty->where('created_by', \Auth::user()->id);
      $totalStaff->where('created_by', \Auth::user()->id);
      $totalCustomer->where('created_by', \Auth::user()->id);
    }
    
    $lateProperties = Property::orderBy('id', 'desc');
    $lateSales = Sale::with(["sale_detail", "sale_detail.property"])->orderBy('id', 'desc');
    if(!\Auth::user()->hasRole('administrator')) {
      $lateProperties->where('created_by', \Auth::user()->id);
      $lateSales->where('created_by', \Auth::user()->id);
    }
    $lateProperties = $lateProperties->limit(6)->get();
    $lateSales = $lateSales->limit(6)->get();

    $properties = $this->totalProperties();
    $sales = $this->summarySale($colors);
    $total = [
      'staff' => $totalStaff->count(),
      'sale' => $totalSale->count(),
      'property' => $totalProperty->count(),
      'customer' => $totalCustomer->count()
    ];

    // return response()->json($sales);

    return view('backend.index', compact("properties", "sales", "colors", "lateProperties", "lateSales", "total"));
  }

  public function summarySale($color)
  {
    $startDate = '2019-07-01';
    $endDate = '2019-12-01';
    $period = CarbonPeriod::create($startDate, '1 month', $endDate);
    $semesterPeriod = [];
    $saleAmount = [];
    foreach($period as $month) {
      $semesterPeriod[] = $month->format('M');

      $sales = Sale::query();
      if(!\Auth::user()->hasRole('administrator')) {
        $sales->where('created_by', \Auth::user()->id);
      }
      $saleAmount[] = $sales->whereBetween('date', [
        Carbon::parse($month)->firstOfMonth()->toDateString(), Carbon::parse($month)->endOfMonth()->toDateString()
      ])->get()->sum('amount');
    }
    $data[] = [
      'label' => 'sale',
      'backgroundColor' => $color[3],
      'data' => $saleAmount
    ];

    return [
      'label' => $semesterPeriod,
      'datasets' => $data
    ];
  }

  public function totalProperties()
  {
    $properties = Property::groupBy('status');
    if(!\Auth::user()->hasRole('administrator')) {
      $properties->where('created_by', \Auth::user()->id);
    }

    $propertiesCount = $properties->get(['status', DB::raw("COUNT(id) AS total")])->map(function($property) {
      $status = [ "Pending", "Submitted", "Reviewed", "Published", "Solved", "Deposit", "Unpublished" ];
      return [
        'label' => __($status[$property->status]),
        'value' => $property->total,
      ];
    });

    return [
      'data' => $propertiesCount,
      'total' => $propertiesCount->sum('value')
    ];
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
        //
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
        //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
        //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
        //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
        //
  }
}