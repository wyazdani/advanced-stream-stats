$(document).ready(function (){
    $('body').on('click','.popup',function (){
        var elem    =   $(this);
        var url     =   elem.attr('data-url');
        var type     =   elem.attr('data-type');
        $.ajax({
            type:'get',
            url:url,
            success:function(data) {
                $("#default_modal .modal-dialog").html(data);
                if(type && type==='small'){
                    $("#default_modal .modal-dialog").removeClass('modal-lg');
                }else{
                    $("#default_modal .modal-dialog").addClass('modal-lg');
                }
                $("#default_modal").modal("show");
            }
        });
    });
    $('body').on('submit','.create_form',function(event) {
        event.preventDefault();
        var elem    =   $(this);
        var url     =   elem.attr('data-url');
        var is_file     =   elem.attr('data-file');
        var is_multi_file     =   elem.attr('data-multi-files');
        var method     =   elem.attr('data-method');
        let type     =   elem.attr('data-type');

        var data    =   $(this)[0];
        var formData = new FormData(data);
        /*if (is_file=='yes'){
            var fileInput = document.getElementById('file-upload-input');
            var file = fileInput.files[0];
            formData.append('file', file);
        }
        if (is_multi_file=='yes'){
            var fileInputs = document.getElementById('file-upload-input-multiple');
            var files = fileInputs.files[0];
            formData.append('files', files);
        }*/
        $('span.input-error').remove();
        formData.append('_token', $('meta[name=csrf-token]').attr("content"));
        if (method){
            formData.append('_method', method);
        }
        $.ajax({
            type:'post',
            url:url,
            data        :   formData,
            processData: false,
            contentType: false,
            success:function(data) {
                if (type==='page'){
                    toast.success(data.message);
                }else{
                    if(data.status){
                        window.LaravelDataTables[data.tableId].ajax.reload( null, false );
                        $('#default_modal').modal('toggle');
                        toast.success(data.message);
                    }
                }

            },
            error: function (response, exception) {
                toast.error("Please resolve following errors");
                var errors = JSON.parse(response.responseText).errors;
                $.each(errors,function (name,error) {
                    if($('span.text-danger.'+name).length ==0){
                        $('.form-control[name="'+name+'"]').after('<span class="input-error '+name+'">'+error+'</span>');
                    }
                });
            },
        });
    });
    $('body').on('change','.is_active',function () {
        var elem    =   $(this);
        var url     =   elem.attr('data-url');
        var value     =   elem.attr('data-value');
        var id     =   elem.attr('data-id');
        $.ajax({
            type:'POST',
            url:url,
            data        :   {
                '_token'    :   $('meta[name=csrf-token]').attr("content"),
                value,id
            },
            success:function(data) {
                window.LaravelDataTables[data.tableId].ajax.reload( null, false );
                toast.success(data.message);
            }
        });
    });
    $('body').on('change','.toggle-panel', function() {
        var locale  =   this.value;
        $( ".panel-box" ).each(function( ) {
            var locale_val  =   $(this).attr('Index');
            $(this).addClass('d-none');
            /*console.log(`locale ${locale}`);
            console.log(`locale_val ${locale_val}`);*/
            if (locale_val==locale){
                $(this).removeClass('d-none');
            }
        });
        //console.log($('.panel-box').attr('Index'));
    });
    $('body').on('click','.btn-delete',function (e){
        var href = $(this).attr('href');
        e.preventDefault();
        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this file!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    swal("File has been deleted", {
                        icon: "success",
                    });
                    $.ajax({
                        type:'GET',
                        url:href,
                        processData: false,
                        contentType: false,
                        success:function(data) {
                            if(data.status){
                                window.LaravelDataTables[data.tableId].ajax.reload( null, false );
                                toast.success(data.message);
                            }
                        }
                    });
                } else {
                    swal("Your File is safe");
                }
            });
    });
    $('body').on('change','.maintenance_date', function() {
        let date = $(this).val();
        let url = $(this).attr('data-url');
        let target_class = $(this).attr('data-class');
        url = url.replace(':id', date);

        $.ajax({
            type:'get',
            url:url,
            success:function(data) {
                if(data.status){
                    $(target_class).prop('disabled', false);
                    $(target_class).empty();
                    $.each(data.data, function (i, item) {
                        $(target_class).append($('<option>', {
                            value: item.id,
                            text : item.time
                        }));
                    });
                }
            },
        });
    });

    $('body').on('click','.bulk-delete',function (){
        let arrayIds = [];
        let url     =   $(this).attr('data-url');

        $(".check-marked:checkbox:checked").each(function(){
            arrayIds.push($(this).val());
        });
        if (arrayIds.length===0){
            toast.warning('No Item Selected');
        }else{
            let formData = new FormData();
            formData.append('_token', $('meta[name=csrf-token]').attr("content"));
            for (let i = 0; i < arrayIds.length; i++) {
                formData.append('ids[]', arrayIds[i]);
            }
            $.ajax({
                type:'post',
                url:url,
                data        :   formData,
                processData: false,
                contentType: false,
                success:function(data) {
                    if(data.status){
                        window.LaravelDataTables[data.tableId].ajax.reload( null, false );
                        toast.success(data.message);
                    }
                }
            });
        }
    });
});
