<?php

namespace App\Http\Controllers\Admin;

use App\Model\Commission\Commission;
use App\Model\Customer\Customer;
use App\Model\PaymentTransaction\PaymentTransaction;
use App\Model\Property\Property;
use App\Model\PropertyHasStaff;
use App\Model\Sale;
use App\Model\SaleDetail;
use App\Model\Staff\Staff;
use App\Model\Office\Office;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;

class SaleController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    $sales = Sale::with(["sale_detail", "sale_detail.property", "customer"])->orderBy("id", "DESC");

    $filter = $request->get("search");

    if(!empty($filter)) {
      $sales->where(function ($query) use($filter) {
        if($filter == 'sale' || $filter == 'rent') {
          // $query->where("type", 1);
          $query->whereHas("sale_detail", function ($query) use($filter) {
            return $query->whereHas("property", function ($query) use($filter) {
              return $query->where("listing_type", $filter);
            });
          });
        }
        else {
          $query->where("type", 2);
        }
      });
    }

    $sales = $sales->paginate(\Constants::LIMIT);
    return view("backend.sale.index", compact("sales"));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    $date = Carbon::parse(now());

    $latestSale = Sale::where('created_at', '>=', $date->startOfDay()->toDateTimeString())
    ->where('created_at', '<=', $date->endOfDay()->toDateTimeString())
    ->orderBy('created_at', 'desc')->count();
    $reference_no = substr($date->year, 2) . sprintf("%02d", $date->month) . sprintf("%02d", $date->day) . '-' . sprintf( "%03d", $latestSale+1 );

    $customers = Customer::orderBy('id', 'DESC')->get();
    $staffs = Staff::whereIn('type', [3,1,4])->get();
    $offices = Office::get();

    $properties = [];
    // $properties = Property::where('status', "<>", \Constants::PROPERTY_STATUS["solved"])
    // ->orderBy("id", "desc")
    // ->get();

    return view("backend.sale.form", compact("customers", "properties", "reference_no", "staffs", "offices"));
  }

  public function getPropertyData($property_id)
  {
    if(is_null($property_id)) {
      return ["status" => false, "message" => "Not Found!"];
    }

    $output = [];
    $commission = Commission::where([
      "property_id" => $property_id,
      "type" => \Constants::COMMISSION_OWNER_COMPANY
    ])->first();

    $property = Property::where("id", $property_id)->where('status', 3)->where('state', 1)->with([
      "owner",
      "owner.owner_id:id,name",
      "collector",
      "collector.staff_id:id,user_id,id_card",
      "collector.staff_id.user:id,name",
      "property_type_id"
    ])->with(["property_has_staff" => function($query) {
      $query->where("type", 3)->with("staff_id", "staff_id.user");
    }])->first();
    $property->data = json_decode($property->data);

    if(!empty($property->contracts)) {
      $property->contracts = $property->contracts->map(function($items) {
        $items->data = json_decode($items->data);
        return $items;
      });
    }
    // dd($property);

    if($property->listing_type == "sale") {
      $output['from_owner'] = (doubleval($property->price) * doubleval(@$commission->commission)) / 100;
    } 
    else {
      $output['from_owner'] = (doubleval($property->price) * doubleval(@$commission->commission));
    }

    //get staff commission
    $commissions = Commission::where(["property_id" => $property_id, "type" => \Constants::COMMISSION_STAFF_COMPANY])->get();

    $html = "";
    if(!is_null($commissions)) {
      foreach ($commissions as $value) {
        $total = (doubleval($output['from_owner']) * doubleval(@$value->commission)) / 100;
        $commission_type = \Constants::COMMISSION_TO[$value->to];
        $html .="<p class='$value->to'><b>". $commission_type .":</b> $ ".number_format($total,2)."</p>";
        $html .="<input type='hidden' class='$value->to' value='".$total."' name='".$commission_type."'/>";
      }
    }
    $output["staff_commission"] = $html;

    $sale = Sale::whereHas("sale_detail", function ($query) use($property_id){
      return $query->where('property_id', $property_id);
    })->where([
      "type" => \Constants::TYPE_DEPOSIT
    ])->first();
    $output["deposit"] = 0;
    if(!is_null($sale)) {
      $output["deposit"] = $sale->deposit;
    }

    $output['property'] = $property;

    return response()->json([
      "status" => 1, 
      "message" => "Success", 
      "data" => $output
    ]);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $request->validate([
      'ref_no'          => 'required|max:255',
      'sale_date'       => 'required',
      'customer'        => 'required',
      'property'        => 'required',
      'payment_method'  => 'required'
    ]);

    // dd($request);
    DB::beginTransaction();

    $tax = 0;
    if($request->tax > 0) {
      $tax = floatval($request->actual_price_commission * ($request->tax / 100));
    }
    $collector = 0;
    if($request->collector > 0) {
      $collector = floatval(($request->actual_price_commission - $tax) * ($request->collector / 100));
    }
    $seller = 0;
    if($request->seller > 0) {
      $seller = floatval(($request->actual_price_commission - $tax) * ($request->seller / 100));
    }
    $subTotal = floatval($request->actual_price_commission - ($tax + $collector + $seller));

    $type = $request->listing_type;
    $data = [
      'ref_no'      => $request->ref_no,
      "contract_id" => 0,
      "customer_id" => $request->customer,
      "staff_id"    => $request->staff ?? \Auth::user()->id,
      "office_id"   => $request->office,
      "date"        => date("Y-m-d", strtotime($request->sale_date)),
      "start_date"  => date("Y-m-d", strtotime($request->start_date)),
      "end_date"    => date("Y-m-d", strtotime($request->end_date)),
      "discount"    => 0,
      "amount"      => $request->actual_price,
      // "deposit" => ($type == \Constants::TYPE_SALE) ? floatval($request->get("deposit_amount")) : floatval($request->get("deposit")),
      "deposit"     => $request->deposit,
      "commission"  => $request->commission,
      "type"        => $type=='rent' ? 2 : 1,
      "sub_total"   => $subTotal,
      "note"        => $request->remark,
      'created_by'  => \Auth::user()->id,
    ];

    $data["data"] = [
      'actual_price_commission' => $request->actual_price_commission,
      'month_of_contract'       => $request->month_of_contract,
      'payment_method'          => $request->payment_method,
      'payment_note'            => $request->payment_note,
      'tax'                     => $request->tax,
      'collector'               => $request->collector,
      'seller'                  => $request->seller,
    ];
    if($request->hasFile("contract")) {
      $img = $request->file("contract");
      $extension = $img->getClientOriginalExtension();
      $has = md5(date('Y-m-d H:i:s') . rand(1, 100));
      $file_name = sha1($has) . "." . $extension;

      $path = base_path() . '/public' . config("global.contract_path");

      if (!is_dir($path)) {
        File::makeDirectory($path, 0777, true, true);
      }

      if($img->move($path, $file_name)) {
        $data["data"] = array_merge($data['data'], ['contract'=>$file_name]);
      }
    }
    $data["data"] = json_encode($data["data"]);
    // dd($data);
    $sale = Sale::create($data);

    if($sale) {
      $detail = SaleDetail::create([
        "sale_id"     => $sale->id,
        "property_id" => $request->property,
        "price"       => $request->price,
        "qty"         => 1
      ]);

      if($detail) {
        // if($type == \Constants::TYPE_SALE) {
        $status = \Constants::PROPERTY_STATUS["solved"];
        // } 
        // else {
        //   $status = \Constants::PROPERTY_STATUS["deposit"];
        // }

        Property::where([
          "id" => $request->property
        ])->update([
          "status" => $status,
          'state' => 0
        ]);
        DB::commit();
        if($type == \Constants::TYPE_SALE) {
          return redirect(route("administrator.sale-detail", $sale->id)."?action=owner-paid")->with("success", __("success-message"));
        } 
        else {
          return redirect(route("administrator.sale-listing"))->with("success", __("success-message"));
        }
      }
      DB::rollBack();
      return redirect()->back()->with("error", __("error-message"))->withInput($request->all());
    }

    DB::rollBack();
    return redirect()->back()->with("error", __("error-message"))->withInput($request->all());
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id, Request $request)
  {
    $sale =  Sale::with([
      "sale_detail", "sale_detail.property", "customer", "staff", "sale_detail.property.collector"
    ])->where(['id' => $id])->first();
    $sale->data = json_decode($sale->data);
    $sale->sale_detail->property->collector = collect($sale->sale_detail->property->collector)->map(function($item) {
      $item->staff = Staff::find($item->staff_id);
      return $item;
    });

    $sale->data->actual_price_commission = isset($sale->data->actual_price_commission) ? $sale->data->actual_price_commission : 0;
    $sale->data->tax_amount = ($sale->data->actual_price_commission * ($sale->data->tax / 100));
    $sale->data->collector_amount = (($sale->data->actual_price_commission - $sale->data->tax_amount) * ($sale->data->collector / 100));
    $sale->data->seller_amount = (($sale->data->actual_price_commission - $sale->data->tax_amount) * ($sale->data->seller / 100));
    $sale->data->balance = $sale->data->actual_price_commission - abs($sale->data->tax_amount + $sale->data->collector_amount + $sale->data->seller_amount);

    $action = $request->get("action");
    $owner_transaction = null;
    $staff_transaction = null;
    switch ($action) {
      case "owner-paid":
      $owner_transaction = PaymentTransaction::select(["*"])
      ->with("user")
      ->where(["type" => 1, "sale_id" => $id])
      ->get();
      break;
      case "staff-paid":
      $staff_transaction = PaymentTransaction::select(["*"])
      ->with("user", "staff", "staff.user")
      ->where(["type" => 2, "sale_id" => $id])
      ->get();
      default:
      break;
    }

    // dd($sale);
    return view("backend.sale.detail", compact("sale", "owner_transaction", "staff_transaction"));
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $item = Sale::with(['sale_detail'])->where('id', $id)->first();
    if(!$item) {
      return \Response::json([
        'success' => false,
      ], 500);
    }

    Property::where([
      "id" => $item->sale_detail->property_id
    ])->update([
      "status" => \Constants::PROPERTY_STATUS["published"]
    ]);

    if($item->delete()) {
      return \Response::json([  
        'success' => true,
      ], 200);
    }
  }

  public function suggestion(Request $request)
  {
    $propertyCode = $request->get('query');
    $output = [];

    $property = Property::where('status', 3)->where('state', 1)->where('code', "LIKE", "%{$propertyCode}%")->limit(20)->get()->map(function($item) {
      $item->suggestion = $item->code . ' - ' . $item->title;

      return $item;
    });
    // dd($property);

    return response()->json($property, 200, [
      'Content-Type' => 'application/json; charset=utf-8'
    ], JSON_UNESCAPED_UNICODE);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function storePayment(Request $request, $sale_id)
  {
    $save = PaymentTransaction::create([
      "amount" => $request->amount,
      "created_by" => auth()->id(),
      "sale_id" => $sale_id,
      "user_id" => auth()->id(),
      "description" => $request->get("description"),
      "type" => 1
    ]);

    if($save) {
      return redirect()->back()->with("success", __("success-message"));
    }

    return redirect()->back()->withErrors( __("error-message"))->withInput($request->all());
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function storeStaffPayment(Request $request, $sale_id)
  {
    $save = PaymentTransaction::create([
      "amount" => $request->amount,
      "created_by" => auth()->id(),
      "sale_id" => $sale_id,
      "user_id" => auth()->id(),
      "description" => $request->get("description"),
      "staff_id" => $request->get("staff"),
      "type" => 2
    ]);

    if($save){
      return redirect()->back()->with("success", __("success-message"));
    }

    return redirect()->back()->withErrors( __("error-message"))->withInput($request->all());
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function getStaffByType($type, $property_id)
  {
    $staff = PropertyHasStaff::with("staff_id", "staff_id.user")->where([
      'property_id' => $property_id,
      'type' => $type
    ])->get();

    $html = "<option value=''>". __("Please Select") ."</option>";
    if(!is_null($staff)) {
      foreach ($staff as $value) {
        $value = json_decode($value);
        $html .="<option value='". @$value->staff_id->id ."'>". @$value->staff_id->user->name ."</option>";
      }
    }

    return $html;
  }
}