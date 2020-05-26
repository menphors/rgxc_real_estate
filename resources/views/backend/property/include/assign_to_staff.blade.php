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
            <tr>
                <th>#</th>
                <th>{{ __("Role") }}</th>
                <th>{{ __("Name") }}</th>
                <th>{{ __("Email") }}</th>
                <th>{{ __('Phone') }}</th>
                <th class="text-right">{{ __("Action") }}</th>
            </tr>
            </thead>
            <tbody>
                @if(@$staffs->count())
                    @foreach($staffs as $key => $staff)
                        <?php
                            $staff = json_decode($staff);

                        ?>
                        <tr>
                            <td>{{ str_pad($key + 1, 2, '0', STR_PAD_LEFT) }}</td>
                            <td>{{ @$staff->staff_id->user->name }}</td>
                            <td>
                                @if(!empty(@$staff->staff_id->user->user_has_role))
                                    @foreach(@$staff->staff_id->user->user_has_role as $role)
                                        <span class="badge badge-success">{{ @$role->role->role_type }}</span>
                                        @endforeach
                                    @endif
                            </td>
                            <td>{{ @$staff->staff_id->user->email }}</td>
                            <td>{{ @$staff->staff_id->user->phone }}</td>
                            <td class="text-right">
                                <a href="#" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-remove"
                                   data-staff_id="{{ @$staff->staff_id->id }}"
                                   data-property_id="{{ @$property->id }}"
                                   title="{{ __('Delete') }}">
                                    <i class="la la-trash text-danger"></i>
                                </a>

                                <form action="{{ route("administrator.property-remove-staff", [@$staff->staff_id->id, $property->id]) }}"
                                      method="post" id="{{ @$staff->staff_id->id . $property->id }}">
                                    @csrf
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    @endif
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="kt_modal_4" tabindex="-1" data-backdrop="false" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg" role="document">

        <form action="{{ route("administrator.property-add-staff", $property->id) }}" method="POST" id="staff-form">
            @csrf
            <input type="hidden" name="property_id" value="{{ $property->id }}"/>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __("Add Agent/Sale") }}</h5>
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

                    <div class="form-group">
                        <label for="staff_type">{{ __("Staff Type") }}</label>
                        <select name="staff_type" class="form-control" required>
                            <option value="">{{ __("Please Select") }}</option>
                            <option value="sale" {{ old("staff_type") == "sale" ? "selected" : "" }}>{{ __("Sale") }}</option>
                            <option value="agent" {{ old("staff_type") == "agent" ? "selected" : "" }}>{{ __("Agent") }}</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="staff">{{ __("Staff") }}</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">
                                <div class="kt-checkbox-list" style="padding-right: 17px!important;padding-bottom: 17px!important;">
                                    <label class="kt-checkbox kt-checkbox--success">
                                        <input type="checkbox" id="check-all" disabled name="check_all" value="1">
                                        <span></span>
                                    </label>
                                </div>
                                </span>
                            </div>
                            <select name="staff[]" class="form-control select2-multiple" style="width:90%;" multiple required>
                                <option value="">{{ __("Please Select") }}</option>
                            </select>
                        </div>
                        <div id="staff[]-error" class="error invalid-feedback"></div>

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

            $("select[name='staff']").select2();
            $("#check-all").click(function(){
                if($("#check-all").is(':checked') ){
                    $("select[name='staff[]'] > option").prop("selected","selected");
                    $("select[name='staff[]']").trigger("change");
                }else{
                    $("select[name='staff[]'] > option").removeAttr("selected");
                    $("select[name='staff[]']").trigger("change");
                }
            });

            $("#staff-form").validate();
            $('#kt_modal_4').modal(`{{ count($errors) > 0 ? "show" : "hide" }}`);
            $("select[name='staff_type']").trigger("change");
            $("select[name='staff_type']").change(function (e) {
                e.preventDefault();
                var value = $(this).find(":selected").val();
                if(value == ""){
                    return false;
                }
                $("#check-all").prop("checked", false);
                $("#check-all").removeAttr("disabled");
                var url = `{{ route("administrator.property-get-staff-by-role-type", ":type") }}`;
                url = url.replace(':type', value);

                $.get(url, function(data){

                    $("select[name='staff[]']").html(data);

                    $("select[name='staff[]']").val(`{{ old("staff[]") }}`).trigger("change");
                });
            }).change();

            $(".btn-remove").click(function (e) {
                e.preventDefault();
                var staff_id = $(this).data("staff_id");
                var property_id = $(this).data("property_id");

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
                        $("#"+staff_id+property_id).submit();
                    }

                });
            });

        });
        </script>
    @endsection