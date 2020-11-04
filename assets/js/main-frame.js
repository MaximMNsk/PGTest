

$(document).ready(()=>{
    GetData();
    $(".alert").hide();
});

$(document).on("click", "#submit", ( evt )=>{
    $(".alert-warning").show(100);
    evt.preventDefault();
    
});


function GetData(){
    var d = $.Deferred();
    $.ajax({
        dataType: "json",
        type: "POST",
        url: 'get/',
        data: $.param( [] ),
        success: function( ans ){
            console.info(ans);
            if(ans.success == 0){
                ShowMessage('warning', ans.message);
                d.resolve;
            }else{
                FillForm( ans );
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

function ShowMessage(level, text){
    $(".alert-"+level).text(text).show(100);
    setTimeout(
        ()=>{ $(".alert-"+level).hide(100); },
        3000
    );
}

function FillForm( ans ){
    $("#name").val(ans.message[0].firstName);
    $("#lastname").val(ans.message[0].lastName);
    if(ans.message[0].email!==undefined) {
        $("#email").val(ans.message[0].email);
        $("#email").attr("disabled", true);
    } else {
        $("#email").removeAttr("disabled");
    }
    $("#identifyer").val(ans.message[0].timekeeperIdentifier);
    $("#fullName").val(ans.message[0].firstName+" "+ans.message[0].lastName);
    // $("#rate").val("0");
    $("#id").val(ans.message[0].employeeId);
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
        $("body").prepend("<div id=\"waiting\"><img src='../assets/img/loading-page.gif' id=\"waiting-img\" /></div>");
        $("#waiting").addClass('position-absolute w-100 h-100');
        $("#waiting-img").css( {"top":"20%", "left":"37%"} ).addClass('position-fixed w-25');
        // $("body").attr("disabled", true);
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

function ShowAlert(){

}