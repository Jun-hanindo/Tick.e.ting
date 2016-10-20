@section('scripts')

    <script>
    $(document).ready(function() {
        
        loadTextEditor();
        getDepartment();

        $('.addDepartment').on('click',function(){
            $('#modal-form').modal('show');
        });

        $('#modal-form').on('show.bs.modal', function (e) {
            $(".tooltip-field").remove();
            $(".form-group").removeClass('has-error');
            $('.error').removeClass('alert alert-danger');
            $('.error').html('');
            
            $("#button_save").unbind('click').bind('click', function () {
                saveDepartment();                
            });
            clearInput();
            saveTrailModal('Department Form');

        });

        $("#position").on('keyup', function(){
            // var q = $(this).val();

            // if(q.length >=3 ) {
            //     autocompletePosition(q);
            // } else {
            //     $("#suggesstion-box").hide();
            // }
        });

    });

    function getDepartment(){

        var uri = "{{route('list-combo-department')}}"

        $("#department").select2({
            ajax: {
                url: uri,
                dataType: 'json',
                type: "get",
                data: function (term, page) {
                    return {
                        q: term
                    };
                },
                results: function (data, page) {
                    return { results: data.results };
                },

            },
            initSelection: function (item, callback) {
                var id = item.val();
                var text = item.data('option');
                if(id > 0){

                    var data = { id: id, text: text };
                    callback(data);
                }
            },
            formatAjaxError:function(a,b,c){return"Not Found .."}
        });
    }

    function clearInput(){
        $("#name").val('');
    }

    function saveDepartment()
    {
        modal_loader();
        var name = $("#name").val();
        $.ajax({
            url: "{{ route('admin-post-department') }}",
            type: "POST",
            dataType: 'json',
            data: {'name':name},
            success: function (data) {
                HoldOn.close();
                $('#modal-form').modal('hide');
                $('.error').html('<div class="alert alert-success">' + data.message + '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>');
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

    function autocompletePosition(q)
    {
        $.ajax({
            url: "{{ route('admin-career-autocomplete-position') }}",
            type: "GET",
            dataType: 'json',
            data: {'position':q},
            success: function (response) {
                    setTimeout(function() {
                        $("#suggesstion-box").html('');
                        $("#suggesstion-box").show();
                        var results = response.data;
                        console.log(results);
                        $("#suggesstion-box").html(results.job)
                    }, 300);
                
            },
            error: function(response){
                
            }
        });
    }
    
    </script>
@endsection