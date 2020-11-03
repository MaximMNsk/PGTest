

$(document).ready(
    ()=>{
        FillForm();

    }
);


function FillForm(){
    var d = $.Deferred();
    $.ajax({
        dataType: "json",
        type: "POST",
        url: 'get/',
        data: $.param( [] ),
        success: function( ans ){
            // console.info(ans);
            if(ans.length == 0){
                console.info('No users to sync');
                d.resolve;
            }else{
                $("#name").val(ans[0].firstName);
                $("#surname").val(ans[0].lastName);
                if(ans[0].email!==undefined) {
                    $("#email").val(ans[0].email);
                    $("#email").attr("disabled", true);
                } 
                $("#identifyer").val(ans[0].timekeeperIdentifier);
                $("#fullName").val(ans[0].firstName+" "+ans[0].lastName);
                // $("#rate").val("0");
                $("#id").val(ans[0].employeeId);
                d.resolve;
            }
        },
        error: function (jqXHR, exception) {
            AjaxError(jqXHR, exception);
            d.reject();
        }
    });
    return d;
}

function SaveData(){

}


$(document).ajaxStart(function () {
    Waiting( 'start' );
});

$(document).ajaxStop(function () {
    Waiting( 'stop' );
});


function Waiting( way ) {
    if( way=='start' ){
        $("body").append("<img src='../assets/img/loading-page.gif' id=\"waiting\" />");
        $("#waiting").css({
            "position": "fixed",
            "z-index":"20",
            "top":"35%",
            "left":"45%",
            "width":"10%"
        });
        $("body").attr("disabled", true);
    }else if( way=='stop' ){
        $("body").attr("disabled", false);
        $("#waiting").remove();
    }else{
        return false;
    }
}


function AjaxError(jqXHR, exception){
    var msg = '';
    if (jqXHR.status === 0) {
        msg = 'Can not connect.\n Verify Network.';
    } else if (jqXHR.status == 404) {
        msg = 'Requested page not found. [404]';
    } else if (jqXHR.status == 500) {
        msg = 'Internal Server Error [500].';
    } else if (exception === 'parsererror') {
        msg = 'Requested JSON parse failed.';
    } else if (exception === 'timeout') {
        msg = 'Time out error.';
    } else if (exception === 'abort') {
        msg = 'Ajax request aborted.';
    } else {
        msg = 'Uncaught Error.\n' + jqXHR.responseText;
    }
    alert( msg + '<br><br>' + jqXHR.responseText, 3 );

}