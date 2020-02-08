var url = 'http://localhost/red_social/public/';
window.addEventListener("load", function(){
    
    $('.btn_like').css('cursor', 'pointer');
    $('.btn_dislike').css('cursor', 'pointer');

    function like(){
        $('.btn_dislike').unbind('click').click(function(){
            $(this).addClass('btn_like').removeClass('btn_dislike');
            $(this).attr('src', url+'imagenes/rojo.png');

            $.ajax({
               url: url+'Dar_like/'+$(this).data('id'),
               type:'get', 
               success:function(repuesta){
                   if(repuesta.like){
                    console.log('se ha dado like');
                   }else{
                    console.log(respuesta);
                   }
               
               } 
            });
            dislike();
        });
    }
  
    like();
    function dislike(){
        $('.btn_like').unbind('click').click(function(){
            $(this).addClass('btn_dislike').removeClass('btn_like');
            $(this).attr('src', url+'imagenes/gris.png');

            $.ajax({
                url: url+'Dar_dislike/'+$(this).data('id'),
                type:'get', 
                success:function(repuesta){
                    if(repuesta.like){
                     console.log('se ha dado dislike');
                    }else{
                     console.log(respuesta);
                    }
                
                } 
             });
            like();
        });
    }
    dislike();


    //Buscar//

    $('#buscardor').submit(function(){ 
        var buscador =$('#buscardor input[name=search]').val();
        $(this).attr('action', url+'/listado_usuarios/'+buscador);
    });


})