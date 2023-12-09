$(document).ready(() => {
    $('#documentacao').on('click', ()=>{
        //console.log('documentacao clickado');
        //$('#pagina').load('documentacao.html');
       /* $.get("documentacao.html", (data) =>
             {
               // console.log(data);
               $('#pagina').html(data);
            }); */
            $.post("documentacao.html", (data) =>
             {
               // console.log(data);
               $('#pagina').html(data);
               });
    });

    $('#suporte').on('click', ()=>{
       // console.log('suporte clickado');
       //$('#pagina').load('suporte.html');
     //  $.get("suporte.html", (data) =>
      // {
         // console.log(data);
        // $('#pagina').html(data);
     // });
     $.post("suporte.html", (data) =>
       {
         // console.log(data);
         $('#pagina').html(data);
      });
    });
	
});