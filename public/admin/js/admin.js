
    function checkList(){
        var checkboxes = document.getElementsByTagName('input');
        var check = null;
        var notAll = null;
            for (var i = 0; i < checkboxes.length; i++) {
                if(checkboxes[i].value != 'on'){
                    if (checkboxes[i].checked == true) {
                        check = 1;
                    }
                }
            }
            if(check == 1){
                $('.btnDeleteAll').show();
            }else{
                $('.btnDeleteAll').hide();
            }
            
    }
     function checkAll(ele) {
        var checkboxes = document.getElementsByTagName('input');
        if (ele.checked) {
            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].type == 'checkbox') {
                    checkboxes[i].checked = true;
                }
            }
            $('.btnDeleteAll').show();
        } else {
            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].type == 'checkbox') {
                    checkboxes[i].checked = false;
                }
            }
            $('.btnDeleteAll').hide();
        }
    }
     function btnDeleteAll() {
        $('#modalDeleteAll').modal('show');
     }
     function deleteAll(module) {
        var checkboxes = document.getElementsByTagName('input');
        var token = document.getElementById("token").value;
        var id = [];
            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].checked == true) {
                    if(checkboxes[i].value != 'on'){
                        id.push(checkboxes[i].value)
                    }
                }
            }
        $.ajax({
            type: "DELETE",
            url: module+"/delete/"+id,
            data:{
                '_token': token,
            },
            success: function( result ) {
                if(result == 1){
                    $('#modalDeleteAll').modal('hide');
                    $('#deleteSuccess').modal('show');
                    setTimeout(function(){
                        location.reload();
                    }, 1000);
                }else{
                }
            }   
        });
    }
    function cancelDelete(){
        $('#exampleModalScrollable').modal('hide');
        $('#modalDeleteAll').modal('hide');
    }
    function deleteFromTable(id){
        $('#exampleModalScrollable').modal('show');
        $('.confirmDelete').attr("id",id);
    }
    function deleteData(module) {
        var id = $('.confirmDelete').attr("id");
        var token = document.getElementById("token").value;
        $.ajax({
            type: "DELETE",
            url: module+"/delete/"+id,
            data:{
                '_token': token,
            },
            success: function( result ) {
                if(result == 1){
                    $('#exampleModalScrollable').modal('hide');
                    $('#deleteSuccess').modal('show');
                    setTimeout(function(){
                        location.reload();
                    }, 1000);
                }else{
                }
            }   
        });
    }
    
        // function formfocus() {
        //     $('html, body').animate({ // สร้างการเคลื่อนไหว
        //         scrollTop: $(document.body).offset().top // ให้หน้าเพจเลื่อนไปทำตำแหน่งบนสุด
        //     }, 500);
        //     setTimeout(function(){
        // 	    document.getElementById('productCode').focus();
        //     }, 500);
        // }
        // window.onload = formfocus;