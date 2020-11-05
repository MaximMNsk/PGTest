

$(document).ready(()=>{
    GetData();
    $(".alert").hide();
});

$(document).on("click", "#submit", ( evt )=>{
    evt.preventDefault();
    $.when( SetData() ).done(()=>{
        setTimeout(()=>{
            ClearForm();
            GetData();
        }, 3000);
    });
});


function GetData(){
    var d = $.Deferred();
    $.ajax({
        dataType: "json",
        type: "POST",
        url: 'get/',
        data: $.param( [] ),
        success: function( ans ){
            d.resolve();
            if(ans.success == 0 && ans.message==false){
                ShowMessage('danger', 'Troubles in a server side');
            }else if(ans.success == 0){
                ShowMessage('warning', ans.message);
            }else{
                FillForm( ans );
            }
        },
        error: function (jqXHR, exception) {
            AjaxError(jqXHR, exception);
            d.reject();
        }
    });
    return d;
}


function SetData(){
    var d = $.Deferred();
    $.ajax({
        dataType: "json",
        type: "POST",
        url: 'set/',
        data: $.param( [
            { name:"name", value:$("#name").val() },
            { name:"lastName", value:$("#lastName").val() },
            { name:"email", value:$("#email").val() },
            { name:"identifier", value:$("#identifier").val() },
            { name:"fullName", value:$("#fullName").val() },
            { name:"rate", value:$("#rate").val() },
            { name:"id", value:$("#id").val() },
        ] ),
        success: function( ans ){
            d.resolve();
            if(Array.isArray(ans)){
                ShowMessage('warning', ans[0].message);
            }else{
                if(ans.success == 0){
                    ShowMessage('warning', ans.message);
                }else{
                    ShowMessage('success', ans.message);
                }
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
        7000
    );
}

function FillForm( ans ){
    $("#name").val(ans.message[0].firstName);
    $("#lastName").val(ans.message[0].lastName);
    if(ans.message[0].email != null) {
        $("#email").val(ans.message[0].email);
        $("#email").prop("disabled", true);
    } else {
        $("#email").prop("disabled", false);
    }
    $("#identifier").val(ans.message[0].timekeeperIdentifier);
    $("#fullName").val(ans.message[0].firstName+" "+ans.message[0].lastName);
    // $("#rate").val("0");
    $("#id").val(ans.message[0].employeeId);
}

function ClearForm(){
    $("input").each((ndx, inpt)=>{
        $(inpt).val("");
    });
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
