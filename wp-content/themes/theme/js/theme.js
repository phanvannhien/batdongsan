jQuery('#tab-container').easytabs();


jQuery(document).ready(function($){
    // Advalidation custom method
    $('[data-tooltip!=""]').qtip({ // Grab all elements with a non-blank data-tooltip attr.
        content: {
            attr: 'data-tooltip' // Tell qTip2 to look inside this attr for its content
        },
        position: {
            //my: 'top left',  // Position my top left...
            at: 'bottom right', // at the bottom right of...
            //target: $('.selector') // my target
        }
    })
    // Validate form captcha
    jQuery.validator.addMethod('validate_captcha', function(value) {
        //alert(id);
        var isSuccess = false;
        jQuery.ajax({
            type: "POST",
            async: false, 
            url: url_ajax,
            data: {
                action: 'check_validate_captcha',
                value: value,
                prefix_captcha: jQuery('input[name="prefix_captcha"]').val()
            },
            success: function(data) {
                console.log(data);
                isSuccess = data === "1" ? true : false;
            }
        });
        return isSuccess;
    }, "Mã xác nhận chưa đúng");


    // validate email exits
    $.validator.addMethod('validateExistEmail', function(value) {
        //alert(id);
        var isSuccess = false;
        jQuery.ajax({
            type: "POST",
            async: false, 
            url: url_ajax,
            data: {
                action: 'checkExistEmail',
                value: value,
            },
            success: function(data) {
                isSuccess = data === "1" ? true : false;
            }
        });
        return isSuccess;
    }, "Email đã được đăng kí");


    // validate user exits
    jQuery.validator.addMethod('validateExistUsername', function(value) {
        //alert(id);
        var isSuccess = false;
        jQuery.ajax({
            type: "POST",
            async: false, 
            url: url_ajax,
            data: {
                action: 'checkExistUsername',
                value: value,
            },
            success: function(data) {
                isSuccess = data === "1" ? true : false;
            }
        });
        return isSuccess;
    }, "Tên đăng nhập đã được có");




    
});// end ready document



// FUNCTION 

// Get
function getQuanHuyen(_id){
    if(_id != '-1'){
       jQuery.ajax({
            type: "POST",
            url: url_ajax,
            data: 'mid='+ _id +'&action=getQuanHuyen',   
            success: function(data) {
                jQuery('select[name="sltquanhuyen"]').html(data); 
            }
        });
    }
    else{
        jQuery('select[name="sltquanhuyen"]').html(''); 
    }
}


// Get
function getSearchQuanHuyen(_id){
    if(_id != '-1'){
       jQuery.ajax({
            type: "POST",
            url: url_ajax,
            data: 'mid='+ _id +'&action=getSearchQuanHuyen',   
            success: function(data) {
                jQuery('ul#lst-sub-qh').html(data); 
            }
        });
    }
    else{
        jQuery('ul#lst-sub-qh').html(''); 
    }
}

function validateSelect(validateName,elementName){
    // Validate select
    jQuery.validator.addMethod(validateName, function(value) {
        //alert(id);
        var isSuccess = false;
        if(jQuery('select[name="'+elementName+'"]').val() != "-1"){
            isSuccess = true;
        }
        return isSuccess;
    }, "");
}

function loadRealGallery(attachIDs) {
    jQuery.ajax({
        type: "POST",
        url: url_ajax,
        data: {
            action: 'loadRealGallery',
            attachIDs: attachIDs
        },
        success: function(data) {
            jQuery("#all-attachment").after(data);
        }
    });
}

// Format number function when input

var format = function(num){
    var str = num.toString().replace("$", ""), parts = false, output = [], i = 1, formatted = null;
    if(str.indexOf(".") > 0) {
        parts = str.split(".");
        str = parts[0];
    }
    str = str.split("").reverse();
    for(var j = 0, len = str.length; j < len; j++) {
        if(str[j] != ",") {
            output.push(str[j]);
            if(i%3 == 0 && j < (len - 1)) {
                output.push(",");
            }
            i++;
        }
    }
    formatted = output.reverse().join("");
    return("$" + formatted + ((parts) ? "." + parts[1].substr(0, 2) : ""));
};

function loadQuanHuyenByTP(tpID,qhID,elementID){
    jQuery.ajax({
        type: "POST",
        url:url_ajax,
        data: {
            action: 'loadQuanHuyenByTP',
            tpID: tpID,
            qhID:qhID
        },
        success: function(data) {
            jQuery(elementID).html(data);
        }
    });
}