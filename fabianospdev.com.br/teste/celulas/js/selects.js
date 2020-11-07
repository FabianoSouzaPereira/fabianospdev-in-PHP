$(function(){
		  $('#estado').change(function(){
		    if( $(this).val() ) {
		      $('#cidades').hide();
		      $('.carregando').show();
		      $.getJSON(
		        'site/pesquisa.php',
		        {
		          uf: $(this).val(),
		          ajax: 'true'
		        }, function(j){
		          var options = '<option value=""></option>';
		          for (var i = 0; i < j.length; i++) {
		            options += '<option value="' +
		              j[i].uf + '">' +
		              j[i].nome + '</option>';
		          }
		          $('#cidades').html(options).show();
		          $('.carregando').hide();
		        });
		    } else {
		      $('#cidades').html(
		        '<option value="">-- Escolha um estado --</option>'
		      );
		    }
		  });
		});	

/*	$.ajax({ cache: false,
		url : 'site/pesquisa.php',
		method : "GET",
		data : {
			uf : estado
		},

		success : function(data) {

			$('#cidades').append("<option>n</option>"); 
			
		}
    });
}
*/