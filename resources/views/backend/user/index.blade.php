@extends('backend.app')

@section("title")
    {{ __("Users") }}
@endsection

@section("breadcrumb")
    <li class="breadcrumb-item"><a href="{{ url('/administrator') }}">Home</a></li>
    <li class="breadcrumb-item active">{{ __("Users") }}</li>
@endsection

@section('content')
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="rows text-right">
            @if(Auth::user()->can('user.add'))
            <a href="{{ route('administrator.user.create') }}" class="btn btn-info btn-sm">
              <i class="fa fa-plus"></i>
              {{ __('Create New') }}
            </a>
            @endif
            <div class="clearfix">&nbsp;</div>
          </div>
          <div class="card">
            <div class="card-body table-responsive p-0">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>{{ __("Email") }}</th>
                    <th>{{ __("Name") }}</th>
                    <th>{{ __("Phone") }}</th>
                    <th>{{ __("Role") }}</th>
                    <th>{{ __("Status") }}</th>
                    <th class="text-right">{{ __("Action") }}</th>
                  </tr>
                </thead>
                <tbody>
                  @if($items->count())
                    @foreach($items as $key => $user)
                      <tr>
                        <td>{{ str_pad($key + 1, 2, '0', STR_PAD_LEFT) }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->phone }}</td>
                        <td>{{ $user->roles->first()->title ?? '' }}</td>
                        <td>
                          @if($user->status ==0)
                            <span class="badge badge-danger">{{ __("Inactive") }}</span>
                          @else
                            <span class="badge badge-info">{{ __("Active") }}</span>
                          @endif
                        </td>
                        <td class="text-right">
                          @if(Auth::id() != $user->id)
                            @if(isAdmin() || Auth::user()->can('user.edit'))
                            <a href="{{ route("administrator.user.change-password", $user->id) }}">
                              <i class="fa fa-unlock" aria-hidden="true"></i>
                            </a>
                            @endif
                            @if(isAdmin() || Auth::user()->can('user.edit'))
                            <a href="{{ route('administrator.user.edit', $user->id) }}">
                              <i class="fa fa-edit" aria-hidden="true"></i>
                            </a>
                            @endif
                            @if(isAdmin() || (Auth::user()->can('user.delete') && $user->is_default==0))
                            <a data-url="{!! url('/administrator/user') !!}" data-id="{!! $user->id !!}" class="text-danger delete-item" href="javascript:void(0);" onclick="deleteItem(this)">
                              <i class="fa fa-trash"></i>
                            </a>
                            @endif
                          @endif
                        </td>
                      </tr>
                    @endforeach
                  @else
                    <tr>
                      <td class="text-center" colspan="4">{{ __('No data available.') }}</td>
                    </tr>
                  @endif
                </tbody>
              </table>
            </div>
          </div>
          {!! $items->render() !!}
        </div>
      </div>
    </div>
  </section>
@endsection

@section('script')
  <script type="text/javascript">
    $( document ).ready(function() {
      $('.kt-menu__item__setting').addClass(' kt-menu__item--open');
      $('.kt-menu__item__user').addClass(' kt-menu__item--active');
    });

    function deleteItem(el){
      var obj = $(el);
      var url = obj.attr('data-url');
      var id = obj.attr('data-id');
      var msg_confirm = $('#confirm_delete').val();
      var _token = $('input[name="_token"]').val();

      $("#confirm_message").html(msg_confirm);
      $('#confirm_modal').modal().one('click', '#ok', function() {

        $("#confirm_modal").hide();
        $.ajax({
          type: "DELETE",
          dataType: 'json',
          url: url + '/' + id,
          data: {'_token':_token},
          beforeSend: function(){
            // $('.ajax-image-loading').css('display','block');
          },
          success: function(result){ 
            if(result.redirect_url){
              window.location.href = result.redirect_url;
            }
            else{
              if(result.message){
                alert(result.message);
              }
              window.location.href = url;
            }
          },
          error :function(request) {
            // $('.ajax-image-loading').css('display','none');
            if(request.responseJSON.nopermission) alert('No Permission');
          }
        });
      }); 
    };
  </script>
@endsection
