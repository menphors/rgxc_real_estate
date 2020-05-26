<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Staff\Staff;
use App\Model\Sale;
use App\Model\Property\Property;
use \Carbon\Carbon;

class ReportController extends Controller
{

  public function __construct()
  {
    //
  }

  public function properties(Request $request)
  {
    $status = [ "padding", "submitted", "reviewed", "published", "solved", "deposit", "unpublished" ];

    $properties = Property::query();
    if($request->startdate && $request->enddate) {
      $properties = $properties->with(["province_id", "district_id", "commune_id", "village_id", "owner", "owner.owner_id:id,name", "collector", "collector.staff:id,user_id,name,email,phone1,phone2", "collector.staff.user:id,name", "property_type_id"])
      ->where('created_at', '>', Carbon::parse($request->startdate)->startOfDay())
      ->where('created_at', '<', Carbon::parse($request->enddate)->endOfDay())
      ->latest()->get()->map(function($item) use($status) {
        $item->status = __(ucfirst($status[$item->status]));
        $item->data = json_decode($item->data);

        $other_service = (isset($item->data->other_service) && !empty($item->data->other_service)) ? array_map(function($item) {
          return config('data.admin.services.orther_service')[\LaravelLocalization::getCurrentLocale()][$item] ?? NULL;
        }, (array)$item->data->other_service) : ([]);
        $security = (isset($item->data->security) && !empty($item->data->security)) ? array_map(function($item) {
          return config('data.admin.services.security')[\LaravelLocalization::getCurrentLocale()][$item] ?? NULL;
        }, (array)$item->data->security) : ([]);
        $special = (isset($item->data->special) && !empty($item->data->special)) ? array_map(function($item) {
          return config('data.admin.services.specials')[\LaravelLocalization::getCurrentLocale()][$item] ?? NULL;
        }, (array)$item->data->special) : ([]);
        $item->data->amentities = implode(', ', array_merge($other_service, $security, $special));

        return $item;
      });
      // dd(@$properties[1]);
    }

    return view('backend.report.properties', compact('properties'));
  }

  public function sale(Request $request)
  {
    $startDate = $request->startdate ? Carbon::parse($request->startdate)->format('Y-m-d') : Carbon::now()->format('Y-m-d');

    $sales = Sale::with(["sale_detail", "sale_detail.property", "customer", "staff", "sale_detail.property.collector"])->where("date", ">=", $startDate);
    if($request->enddate) {
      $sales->where('date', '<=', Carbon::parse($request->enddate)->format("Y-m-d"));
    }
    if($request->staff) {
      $sales->where('staff_id', $request->staff);
    }
    $sales = $sales->get()->map(function($item) {
      $item->data = json_decode($item->data);

      $item->actual_price_commission = isset($item->data->actual_price_commission) ? $item->data->actual_price_commission : 0;
      $item->tax_amount = ($item->actual_price_commission * ($item->data->tax / 100));
      $item->collector_amount = (($item->actual_price_commission - $item->tax_amount) * ($item->data->collector / 100));
      $item->seller_amount = (($item->actual_price_commission - $item->tax_amount) * ($item->data->seller / 100));
      $item->balance = $item->actual_price_commission - abs($item->tax_amount + $item->collector_amount + $item->seller_amount);
      $item->sale_detail->property->collector = collect($item->sale_detail->property->collector)->map(function($collector) {
        $collector->staff = Staff::find($collector->staff_id);
        return $collector;
      });

      return $item;
    });

    $properties = $sales->map(function($sale) {
      $item = $sale->sale_detail->property;
      $item->actual_price_commission = $sale->actual_price_commission;
      return $item;
    })->groupBy('listing_type');

    $staffs = Staff::whereIn('type', [1,2,3,4])->orderBy('id', 'desc')->get(['id', 'name', 'id_card', 'type', 'user_id'])->map(function($item) {
      $item->type = staff_type($item->type);
      return $item;
    });

    $total = [
      'rental_price' => isset($properties['rent']) ? collect($properties['rent'])->sum('price') : 0,
      'sale_price' => isset($properties['sale']) ? collect($properties['sale'])->sum('price') : 0,
      'sale_commission' => isset($properties['sale']) ? collect($properties['sale'])->sum('actual_price_commission') : 0,
      'rental_commission' => isset($properties['rent']) ? collect($properties['rent'])->sum('actual_price_commission') : 0,
      'actual_commission' => $sales->sum('actual_price_commission'),
      'tax' => $sales->sum('tax_amount'),
      'sale' => $sales->sum('seller_amount'),
      'collector' => $sales->sum('collector_amount'),
    ];

    // dd($total);
    return view("backend.report.sale", compact('staffs', 'sales', 'total'));
  }

  public function commission(Request $request)
  {
    $startDate = $request->startdate ? Carbon::parse($request->startdate)->format('Y-m-d') : Carbon::now()->format('Y-m-d');

    $sales = Sale::with(["sale_detail", "sale_detail.property", "customer", "staff"])->where("date", ">=", $startDate);
    if($request->enddate) {
      $sales->where('date', '<=', Carbon::parse($request->enddate)->format("Y-m-d"));
    }
    if($request->staff) {
      $sales->where('staff_id', $request->staff);
    }
    $sales = $sales->get()->map(function($item) {
      $item->data = json_decode($item->data);

      $item->total_paid_commission = collect($item->data)->sum('actual_price_commission');
      return $item;
    });
    // $sales = Staff::has('sale')->get();

    $staffs = Staff::whereIn('type', [1,2,3,4])->orderBy('id', 'desc')->get(['id', 'name', 'id_card', 'type', 'user_id'])->map(function($item) {
      $item->type = staff_type($item->type);
      return $item;
    });

    // dd($sales);
    return view("backend.report.commission", compact('staffs', 'sales'));
  }
}
