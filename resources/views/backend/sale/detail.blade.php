@extends('backend.app')
@section("title")
{{ __('Sale Detail') }}
@endsection

@section("style")
<style type="text/css">
  
</style>
@endsection

@section('content')
<div class="kt-subheader   kt-grid__item" id="kt_subheader">
  <div class="kt-container  kt-container--fluid ">
    <div class="kt-subheader__main">
      <h3 class="kt-subheader__title">{{ __("Ref No")." #".@$sale->ref_no }}</h3>

      <span class="kt-subheader__separator kt-subheader__separator--v"></span>
      <div class="kt-subheader__breadcrumbs">
        <span class="kt-subheader__breadcrumbs-separator"></span>
        <a href="{{ route("administrator.sale-detail", $sale->id) }}"
         class="kt-subheader__breadcrumbs-link {{ request("action") == "" || request("action") == "information"? "text-danger" : "" }}"
         title="{{ __("Information") }}">
         {{ __("Information") }}
       </a>
       @if($sale->type == Constants::TYPE_SALE)
       <span class="kt-subheader__separator kt-subheader__separator--v"></span>
       <span class="kt-subheader__breadcrumbs-separator"></span>
       <a href="{{ route("administrator.sale-detail", $sale->id) }}?action=contract"
         class="kt-subheader__breadcrumbs-link {{ request("action") == "contract"? "text-danger" : "" }}"
         title="{{ __("Contract") }}">
         {{ __("Contract") }}
       </a>
       <span class="kt-subheader__separator kt-subheader__separator--v"></span>
       <span class="kt-subheader__breadcrumbs-separator"></span>
       <a href="{{ route("administrator.sale-detail", $sale->id) }}?action=owner-paid"
         class="kt-subheader__breadcrumbs-link {{ request("action") == "owner-paid"? "text-danger" : "" }}"
         title="{{ __("Owner Paid") }}">
         {{ __("Owner Paid") }}
       </a>

       <span class="kt-subheader__separator kt-subheader__separator--v"></span>
       <span class="kt-subheader__breadcrumbs-separator"></span>
       <a href="{{ route("administrator.sale-detail", $sale->id) }}?action=staff-paid"
         class="kt-subheader__breadcrumbs-link {{ request("action") == "staff-paid"? "text-danger" : "" }}"
         title="{{ __("Staff Paid") }}">
         {{ __("Staff Paid") }}
       </a>
       @endif
     </div>
   </div>
 </div>
</div>

<br/>
<section class="content">
  <div class="container-fluid">
    <div class="card">
      @include("backend.partial.message")
      <div class="card-body">
        @if(request("action") == "owner-paid")
          @include("backend.sale.include.owner_paid")
        @elseif(request("action") == "staff-paid")
          @include("backend.sale.include.staff_paid")
        @elseif(request("action") == "contract")
          @include("backend.sale.include.contract")
        @else
          @include("backend.sale.include.information")
        @endif
      </div>
    </div>
  </div>

</section>
@endsection
@section("script")
<script type="text/javascript">
  $(function () {
    $('.kt-menu__item__sale').addClass(' kt-menu__item--active');
  })
</script>
@endsection