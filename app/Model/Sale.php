<?php

namespace App\Model;

use App\Model\Customer\Customer;
use App\Model\Staff\Staff;
use App\Model\Office\Office;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $table = "sales";

    protected $fillable = [
        "ref_no",
        "contract_id",
        "office_id",
        "customer_id",
        "staff_id",
        "date",
        "start_date",
        "end_date",
        "amount",
        "discount",
        "commission",
        "deposit",
        "status",
        "note",
        "data",
        "type",
        "sub_total",
        "created_by",
        "updated_by"
    ];

    public $timestamps = true;

    protected $primaryKey = "id";

    public function sale_detail()
    {
        return $this->hasOne(SaleDetail::class, "sale_id", "id");
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, "customer_id", "id");
    }

    public function staff()
    {
      return $this->belongsTo(Staff::class, "staff_id", "id");
    }

    public function office()
    {
      return $this->belongsTo(Office::class, "office_id", "id");
    }
}
