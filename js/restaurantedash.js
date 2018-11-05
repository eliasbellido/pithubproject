$(document).ready(function(){
    console.log('ready!');  


    $('#frmRest').on('submit', function(event){
        console.log('se presiono submit');
        
      //  event.preventDefault();
        
    });

    $("#editarbtn").click( function(){

        console.log('se presiono en editar rest');

        $("#nomRestaurante").prop('disabled',false);
        $("#descRestaurante").prop('disabled',false);
        $("#direcRest").prop('disabled',false);
        $("#tipoRest").prop('disabled',false);

        //btn
        //$("#grabarbtn").prop('hidden',false);
        $("#editarbtn").prop('hidden',true);


        

        

        

        
    });

    $('.editar_prod').on('click', function(event){
        console.log('se presiono en editar prod');
        var idProd = $(this).data('idprod');
        $(".modal-body #idProd").val( idProd );
        
        $.ajax({
            url:"./util/functionsHandler.php",
            method:"post",
            data:{prod_id:idProd},
            success:function(data){
                $(".editarprod-body").html(data);
            }

            
        });

        console.log(idProd);

      //  event.preventDefault();
        
    });

    $('body').on('submit', '#frmModalEditarProducto', function(e) {
        
 
        console.log('se hizo submit del modal!');

         $('#editarProductoModal').modal('hide');
        

    });

    $('#nuevoProductoModal').on('hidden.bs.modal',function(e){

        console.log("se cerrò modal nuevo");
        $("#fileSpan").text("Seleccione una imagen");
    });

    $('#customFile').on('change',function(e){

        var files = $(this)[0].files;

        if(files>1){
            $("#fileSpan").text(files.length + " archivos listos para cargar");
        }else{
            var filename = e.target.value.split('\\').pop();
            console.log("kk: "+filename);
            $("#fileSpan").text(filename);
        }
    });

    $('body').on('change','#customFileEdit',function(e){

        var files = $(this)[0].files;

        if(files>1){
            $("#fileSpanEdit").text(files.length + " archivos listos para cargar");
        }else{
            var filename = e.target.value.split('\\').pop();
            console.log("kk: "+filename);
            $("#fileSpanEdit").text(filename);
        }
    });



});

