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

    $('#competencia').on('change', (e)=>{
           let competencia = $(e.target).val();
           //console.log(competencia);
            $.ajax({
                type: "GET",
                url: "app.php",
                data:`competencia=${competencia}`,
                dataType:'json',
                success: (dados)=> {
                    $('#numero_vendas').html(dados.numero_vendas);
                    $('#total_vendas').html(dados.total_vendas);
                    $('#clientes_ativos ').html(dados.clientes_ativos);
                    $('#clientes_inativos ').html(dados.clientes_inativos);
                    $('#elogios').html(dados.elogio);
                    $('#reclamacoes').html(dados.reclamacoes);
                    $('#sugestoes').html(dados.sugestao);
                    $('#despesas').html(dados.despesa);
                    //console.log(dados.numero_vendas, dados.total_vendas);
                },
                console: (erro)=>{
                    console.log(erro);
                }
           });
    });
	
});