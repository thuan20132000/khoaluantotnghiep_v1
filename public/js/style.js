



/**
* author: Thuan
* created at 15/07/2020
* description: function to select All item in list need to delete
*/
function selectAllCheckbox(name){

    $(`#${name}-selectAllCheckbox`).on('click',function(){
        $(`input:checkbox[name="${name}[]"]`).prop('checked',this.checked);
    });

}
selectAllCheckbox('category');
selectAllCheckbox('occupation');
selectAllCheckbox('user');
selectAllCheckbox('job');




    /**
     * author: Thuan
     * created at 15/07/2020
     * description: function to select All item in list need to delete
     */
    function deleteAllCheckbox(name){

        $(`#${name}-deleteAllCheckbox`).on('click',function(){
            var destroyItems = [];
            $.each($(`input[name='${name}[]']:checked`), function() {
                destroyItems.push($(this).val());
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

                var request = $.ajax({
                    url: `${name}`,
                    method: "DELETE",
                    data: { ids : destroyItems },
                });

                request.done(function( msg ) {
                    console.log('data '+msg);
                    if(msg.status == true){
                        setTimeout(() => {
                            location.reload();
                        }, 900);
                        toastr.success('Delete Successfully')

                    }
                });

                request.fail(function( jqXHR, textStatus ) {
                    alert( "Request failed: " + textStatus );
                });


        })


    }

    deleteAllCheckbox('category');
    deleteAllCheckbox('occupation');
    deleteAllCheckbox('user');
    deleteAllCheckbox('job');





