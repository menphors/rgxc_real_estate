<div class="card">
    <div class="card-body table-responsive p-0">
        @if($property->status != Constants::PROPERTY_STATUS["solved"])
            <div class="row" style="margin-top: 10px; margin-right: 10px">
                <div class="col-12 text-right">
                    <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#kt_modal_4">
                        <i class="fa fa-plus"></i>
                        {{ __("Add New") }}
                    </a>
                </div>
            </div>
        @endif
        <table class="table table-hover">
            <thead>
                <th>{{ __("Type") }}</th>
                <th>{{ __("To/From") }}</th>
                <th>{{ __("Amount") }}</th>
                @if($property->status != Constants::PROPERTY_STATUS["solved"])
                <th></th>
                    @endif
            </thead>
            <tbody>
            @if(!empty($commissions))
                @foreach($commissions as $commission)
                    <tr>
                        <td>
                            <span class="badge badge-success">{!! Constants::COMMISSION_TYPE[$commission->type] !!}</span>
                        </td>
                        <td>
                            @if($commission->type == Constants::COMMISSION_OWNER_COMPANY)
                                @if(!empty(@$property->owner))
                                    @foreach(@$property->owner as $owner)
                                       <span class="badge badge-primary">
                                           {{ @$owner->owner_id->name }}
                                       </span>
                                    @endforeach
                                    @endif
                                @else
                                <span class="badge badge-danger">
                                {{ @Constants::COMMISSION_TO[@$commission->to] }}
                                </span>
                            @endif
                        </td>
                        <td>
                            @if($commission->type == Constants::COMMISSION_OWNER_COMPANY)
                                @if(@$property->listing_type == "sale")
                                    {{ @$commission->commission . " %" }}
                                    @else
                                    {{ @$commission->commission . " /month" }}
                                    @endif
                            @else
                                {{ @$commission->commission . " %" }}
                            @endif
                        </td>
                        @if($property->status != Constants::PROPERTY_STATUS["solved"])
                            <td class="text-right">
                                <a href="#"
                                   data-id="{{ $commission->id }}"
                                   data-amount="{{ $commission->commission }}"
                                   data-type="{{ $commission->type }}"
                                   data-to="{{ $commission->to }}"
                                   title="{{ __('Edit') }}"
                                   class="btn btn-sm btn-clean btn-icon btn-icon-md btn-edit">
                                    <i class="la la-edit"></i>
                                </a>
                                <a href="#" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-remove"
                                   data-url="{{ route("administrator.property-delete-commission", $commission->id) }}" data-id="{!! $commission->id !!}"
                                    title="{{ __('Delete') }}">
                                    <i class="la la-trash text-danger"></i>
                                </a>
                            </td>
                            @endif
                    </tr>
                    @endforeach
                @endif

            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="kt_modal_4" tabindex="-1" data-backdrop="false" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg" role="document">

        <form action="{{ route("administrator.property-setup-commission") }}" method="POST" id="commission-form">
            @csrf
            <input type="hidden" name="property_id" value="{{ $property->id }}"/>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __("Setup Commission") }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    @if($errors->count())
                        <div class="alert alert-danger" role="alert">
                            @foreach ($errors->all() as $error)
                                <div class="alert-text">{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-12">
                            <input type="hidden" value="" name="hidden_type"/>
                            <label for="commission_type">{{ __("Commission Type") }}  <span class="text-danger">*</span></label>
                            <select name="commission_type" id="commission_type" class="form-control" required>
                                <option value="">{{ __("Please Select") }}</option>
                                @foreach(Constants::COMMISSION_TYPE as $key => $value)
                                    <option value="{{ $key }}" {{ $key == old("commission_type") ? "selected" : "" }}>{{ $value }}</option>
                                    @endforeach
                            </select>
                        </div>
                    </div>
                    <br/>
                    <div class="row block-company-staff" style="display: none!important;">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="commission_to">{{ __("Commission To") }} <span class="text-danger">*</span> </label>
                                <select name="commission_to" class="form-control" id="commission_to">
                                    @foreach(Constants::COMMISSION_TO as $key => $value)
                                        <option value="{{ $key }}" {{ $key == old("commission_to") ? "selected" : "" }}>{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="amount">{{ __("Amount") . " (".($property->listing_type == "sale" ? "%" :  __("Month")).")"}} <span class="text-danger">*</span> </label>
                                <input type="number" name="amount" value="{{ old("amount") }}" class="form-control" id="amount"/>
                            </div>
                        </div>
                    </div>

                    <div class="row block-owner-company" style="display: none!important;">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="owner_amount">{{ __("Amount") . " (".($property->listing_type == "sale" ? "%" :  __("Month")).")" }} <span class="text-danger">*</span> </label>
                                <input type="number" name="owner_amount" value="{{ old("owner_amount") }}" class="form-control" id="owner_amount"/>
                            </div>
                        </div>

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
            </div>
        </form>
    </div>
</div>

@section("script")
    <script type="text/javascript">
        $(function () {
            $('.kt-menu__item__property_block').addClass('kt-menu__item--open');
            $('.kt-menu__item__property').addClass('kt-menu__item--active');

            $("#commission-form").validate();
            $('#kt_modal_4').modal(`{{ count($errors) > 0 ? "show" : "hide" }}`);

            $(".btn-edit").click(function (e) {
                e.preventDefault();
                var id = $(this).data("id");
                var amount = $(this).data("amount");
                var type = $(this).data("type");
                var to = $(this).data("to");
                $("input[name='hidden_type']").val(type);
                $("select[name='commission_type']").val(type).trigger("change");
                $("select[name='commission_type']").attr("disabled", "disabled");
                $("input[name='amount']").val(amount).trigger("change");
                $("input[name='owner_amount']").val(amount).trigger("change");
                $("select[name='commission_to']").val(to).trigger("change");

                var url = `{{ route("administrator.property-update-commission", ":id") }}`;
                url = url.replace(':id', id);

                $("#commission-form").attr("action", url);
                $("#kt_modal_4").modal("show");
            });


            $(".btn-remove").click(function (e) {
                e.preventDefault();
                var commission_id = $(this).data("id");

                Swal.fire({
                    title: `{{ __("are-you-sure") }}`,
                    text: `{{ __('delete-confirm') }}`,
                    type: 'info',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: `{{ __("Yes") }}`,
                    cancelButtonText: `{{ __("Cancel") }}`
                }).then((result) => {
                    if (result.value) {
                        $("#"+commission_id).submit();
                    }

                });
            });

            $("select[name='commission_type']").trigger("change");
            $("select[name='commission_type']").change(function (e) {
                e.preventDefault();
                var commission_type = $(this).find(":selected").val();

                if(commission_type == `{{ Constants::COMMISSION_OWNER_COMPANY }}`){
                    $('.block-company-staff').hide();
                    $('.block-owner-company').show();
                    $("input[name='owner_amount']").attr("required", "required");
                    $("select[name='commission_to']").removeAttr("required");
                    $("input[name='amount']").removeAttr("required");
                }else if(commission_type == `{{ Constants::COMMISSION_STAFF_COMPANY }}`){

                    $('.block-company-staff').show();
                    $('.block-owner-company').hide();
                    $("select[name='commission_to']").attr("required", "required");
                    $("input[name='amount']").attr("required", "required");
                    $("input[name='owner_amount']").removeAttr("required");

                }else{
                    $('.block-company-staff').hide();
                    $('.block-owner-company').hide();

                    $("select[name='commission_to']").removeAttr("required");
                    $("input[name='amount']").removeAttr("required");
                    $("input[name='owner_amount']").removeAttr("required");
                }
            }).trigger("change");
        })
    </script>
    @endsection