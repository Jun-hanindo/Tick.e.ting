@section('scripts')

    <script>
    $(document).ready(function() {
        
        loadTinyMce();

        $("#button_draft2").unbind('click').bind('click', function () {
            update();                
        });

    });

    function update()
    {
        
        var title = $("#title").val();
        var content = tinyMCE.get('content').getContent();
        var slug = $("#slug").val();
        var uri = "{{ URL::route('admin-post-update-manage-page', "::param") }}";
        uri = uri.replace('::param', slug);
        $.ajax({
            url: uri,
            type: "POST",
            dataType: 'json',
            data: {'title':title,"content":content, "status":"draft"},
            success: function (data) {
                $('.error').html('<div class="alert alert-success">' + data.message + '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>');  
            	location.reload();
            },
            error: function(response){
                HoldOn.close();
                if (response.status === 422) {
                    var data = response.responseJSON;
                    $.each(data,function(key,val){
                        $('<span class="text-danger tooltip-field"><span>'+val+'</span>').insertAfter($('#'+key));
                        $('.'+key).addClass('has-error');
                    });
                } else {
                    $('.error-modal').html('<div class="alert alert-danger">' +response.responseJSON.message + '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>');
                }
            }
        });
    }
    
    </script>
@endsection