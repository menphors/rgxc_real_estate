<div class="modal" id="confirm_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document" style="padding-top:8%;">
    <div class="modal-content">
      <div class="modal-header">
        <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> -->
        <h4 class="modal-title" id="myModalLabel">{{__('Confirmation Message')}}</h4>
      </div>
      <div class="modal-body">
        <h5 id="confirm_message"></h5>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" id="cancel">No</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal" id="ok">Ok</button>
      </div>
    </div>
  </div>
</div>

{!!Form::input('hidden','boxchecked', '0', ['id'=>'boxchecked'])!!}
{!!Form::input('hidden','message', __("Please first make a selection from the list."), ['id'=>'message'])!!}
{!!Form::input('hidden','confirm_hide', __('Are you sure you want to delete this item?'), ['id'=>'confirm_delete'])!!}
{!!Form::input('hidden','_token', csrf_token())!!}
