<script type="text/javascript">

    (function () {
        //Initialize Select2 Elements
        $('.select2').select2();
        $('.select2-multiple').select2({multiple:true, placeholder:"{{ __('Please select') }}", tags: true});
    }).call(this);

    function btnSearch() {
        $('#form-search').submit();
    }

    function deleteItem(el){
        var obj = $(el);
        var url = obj.attr('data-url');
        var id = obj.attr('data-id');
        var msg_confirm = $('#confirm_delete').val();
        var _token = $('input[name="_token"]').val();

        $("#confirm_message").html(msg_confirm);
        $('#confirm_modal').modal()
            .one('click', '#ok', function() {

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
                        }else{
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