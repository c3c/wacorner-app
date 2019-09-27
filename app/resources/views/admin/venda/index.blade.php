@extends('adminlte::page')

@section('js_header')

  @if(auth()->check())
      @if(auth()->user()->user_id != null)  
        <script>
          fbq('track', 'InitiateCheckout');
        </script>
      @endif
  @endif  


	<script type="text/javascript" src="https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script>
@stop

@section('content')


<div class="box">
    	<div class="box-header">
    			<h3 class="box-title">Adquira um plano <div id="hash"></div> </h1>
    		<div class="box-body">
    			<div class="alert alert-info">@if(auth()->user()->ativo())
    				Data de expiração: {{date('d/m/Y',strtotime(auth()->user()->data_expiracao))}} @else NENHUM PLANO ATIVO @endif </div>
    			
    			@include('admin.includes.alerts')
    			<form-pagseguro acao="{{route('venda.compra')}}"></form-pagseguro>
    		</div>
    	</div>
    </div>





@stop

@section('js')
	


	<!-- 

    <script>
        //hash
		
		

        function gera_bandeira(){
        	
        	PagSeguroDirectPayment.getBrand({
				cardBin: document.getElementById('cartao').value,
					success: function(response) {
						
					},
					error: function(response) {
						alert('Procurando bandeira do cartão!');
					},
					complete: function(response) {
						document.getElementById('bandeira').value = response.brand.name;
						console.log(response.brand.name);
					}
			});
        }

        function gera_card_token(){
        	PagSeguroDirectPayment.createCardToken({
        	    cardNumber: document.getElementById('cartao').value,
        	    brand: document.getElementById('bandeira').value,
        	    cvv: document.getElementById('cvv').value,
        	    expirationMonth: document.getElementById('validadeMes').value,
        	    expirationYear: document.getElementById('validadeAno').value,
        	    success: function(response) {
        	        
        	    },
        	    error: function(response) {
        	    	if($document.getElementById('cvv').value!="" && $document.getElementById('bandeira').value!="" && $document.getElementById('validadeMes').value!="" && $document.getElementById('validadeAno').value!="" && $document.getElementById('cartao').value!=""){
        	    	    alert('Gerando token do cartão!');
        	    	}
        	    },
        	    complete: function(response) {
        	       document.getElementById("card_token").value = response.card.token;
        	        console.log(response.card.token);
        	    }
        	});
        }

		

        $( "#submit_basico" ).click(function() {
            var tipo = $("#tipo_pagamento option:selected").text();
			if(tipo == 'Cartão de credito'){
        		gera_bandeira();
        		gera_card_token();
        		PagSeguroDirectPayment.onSenderHashReady(function(response){
				    if(response.status == 'error') {
				        alert(response.message);
				    }else{

				    var hash = response.senderHash;

				   	document.getElementById("token").value = hash; 
                	setTimeout(function(){$( "#form_basico" ).submit();},10000);
                	}
				});
        		
        	}else{
        		
        	}

            
        });
        
   

		function tipoPlano() {
			var tipo = $("#tipo_plano option:selected").text();
			if(tipo == 'Grátis'){
				$('#tipo_pagamento').prop('disabled',true);
			}else{
				$('#tipo_pagamento').prop('disabled',false);
			}
		}


		function tipo() {
			var tipo = $("#tipo_pagamento option:selected").text();
			if(tipo == 'Cartão de credito'){
				$('input[name="data_aniversario"]').prop('disabled',false);
				$('input[name="rua"]').prop('disabled',false);
				$('input[name="numero"]').prop('disabled',false);
				$('input[name="bairro"]').prop('disabled',false);
				$('input[name="cidade"]').prop('disabled',false);
				$('input[name="estado"]').prop('disabled',false);
				$('input[name="cep"]').prop('disabled',false);
				$('input[name="cartao"]').prop('disabled',false);
				$('input[name="cvv"]').prop('disabled',false);
				$('input[name="validadeMes"]').prop('disabled',false);
				$('input[name="validadeAno"]').prop('disabled',false);

				alert('Os dados do seu cartão não seram salvos no nosso site, são passado diretamente para o PAGSEGURO!');
			}else{
				$('input[name="data_aniversario"]').prop('disabled',true);
				$('input[name="rua"]').prop('disabled',true);
				$('input[name="numero"]').prop('disabled',true);
				$('input[name="bairro"]').prop('disabled',true);
				$('input[name="cidade"]').prop('disabled',true);
				$('input[name="estado"]').prop('disabled',true);
				$('input[name="cep"]').prop('disabled',true);
				$('input[name="cartao"]').prop('disabled',true);
				$('input[name="cvv"]').prop('disabled',true);
				$('input[name="validadeMes"]').prop('disabled',true);
				$('input[name="validadeAno"]').prop('disabled',true);
			}
		}
	</script> -->
@stop