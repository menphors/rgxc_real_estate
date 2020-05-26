<?php
    $unpaid = floatval($sale->commission) - floatval($owner_transaction->sum("amount"));
?>
<div class="row">
    <div class="col-6"></div>
    <div class="col-6 font-weight-bold text-primary text-right">
        {{ __("Total Unpaid Commission") }}: $ {{ number_format($unpaid, 2) }}
    </div>
</div>
<br/>
<div class="row">
    <div class="col-12 text-right">
        @if($unpaid > 0)
            <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#kt_modal_4">
                <i class="fa fa-plus"></i>
                {{__("Add New")}}
            </a>
            @endif
    </div>
</div>
<div class="row">
    <div class="col-12">
        <table class="table table-hover">
            <thead>
                <th>{{ __("No") }}</th>
                <th>{{ __("Amount") }}</th>
                <th>{{ __("Description") }}</th>
                <th>{{ __("Created By") }}</th>
                <th>{{ __("Created At") }}</th>
            </thead>
            <tbody>
                @if(!is_null($owner_transaction))
                    @foreach($owner_transaction as $key => $value)
                        <tr>
                            <td>{{ str_pad($key + 1, 2, '0', STR_PAD_LEFT) }}</td>
                            <td>$ {{ number_format($value->amount, 2) }}</td>
                            <td>{{ $value->description }}</td>
                            <td>{{ @$value->user->name }}</td>
                            <td><i>{{ date("d-M-Y h:i A", strtotime($value->created_at)) }}</i></td>
                        </tr>
                        @endforeach
                    @endif
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" data-backdrop="false" id="kt_modal_4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="{{ route("administrator.store-payment", $sale->id) }}" method="post" id="owner-paid-form">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __("Owner Paid") }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                        <div class="form-group">
                            <label for="amount" class="form-control-label">{{ __("Amount") }} ($)<span class="text-danger">*</span></label>
                            <input type="number" class="form-control" placeholder="0.00" max="{{ $unpaid }}" id="amount" name="amount" required>
                        </div>
                        <div class="form-group">
                            <label for="description" class="form-control-label">{{ __("Description") }}:</label>
                            <textarea class="form-control" id="description" name="description"></textarea>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">
                        <i class="la la-long-arrow-left"></i> {{ __("Back") }}
                    </button>
                    <button type="submit" class="btn btn-info">
                        <i class="fa fa-save"></i>
                        {{ __("Save") }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@section("script")
    <script type="text/javascript">
        $(function () {
            $("#owner-paid-form").validate();
            $('#kt_modal_4').modal(`{{ count($errors) > 0 ? "show" : "hide" }}`);
        })
    </script>

    @endsection