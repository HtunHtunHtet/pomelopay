require( 'datatables.net-bs4' );

$(document).ready(function(){
    $('#transaction').DataTable();


    $(".delete-transaction-btn").click(function () {
        let transactionId =  $(this).data("transactionid");
        $('#transactionId').empty().html(transactionId);
        $("#transactionIdHidden").val(transactionId);
    })

})


//$('#deleteTransaction').modal();