<template>
	<div>
		 <div v-if='erro' class="alert alert-danger">
                <p>
					<span class="fa fa-thumbs-o-down"></span> {{erro}}
				</p>
        </div>
		<div class="row">
	        <div class="form-group">
	            <label>Escolha seu país*:</label>
	            <br>
	            <input type="radio" v-model="pais" @click="limparValor" value="brasil" autocomplete="off" checked>  Brasil
	            <input type="radio" v-model="pais" @click="limparValor" value="outro" autocomplete="off"> Outro País 
	        </div>
	    </div>
		<div class="row ">
			<div class="form-group">
			    <label>Plano*</label>
	            <select v-if="pais == 'brasil'"  class="form-control" v-model="plano" required>
	                <option v-if="profissional == false" value="29.99">Profissional - R$29,99</option>
	            </select>
			    <select v-if="pais != 'brasil'"  class="form-control" v-model="plano" required>
			    	<option v-if="profissional == false" value="8">Profissional - $8</option>
			    </select>
		    </div>
		</div>
		<div class="row">
			<div class="form-group">
			    <label>Cupom de Desconto (opcional)</label>
			    <input type="text" name="cupom_desconto" id="cupom_desconto" class="form-control" v-model='cupom_desconto' required> <button class="btn btn-success btn-xs" @click.prevent="validar"> Validar Cupom</button>
			    <input type="hidden" name="desconto" v-model='desconto'>
			    <div v-if='desconto!=0' class="alert alert-info">
			            <p><span class="fa fa-thumbs-o-up"></span> {{desconto}}% de desconto</p>
			    </div>
			</div>
		</div>
		<h4><b>País:</b> {{pais.toLowerCase()}}</h4>
		<h4 v-if="pais == 'brasil'"><b>Valor Plano:</b> {{total}} reais</h4>
		<h4 v-if="pais != 'brasil'"><b>Valor Plano:</b> {{total}} dolares</h4>
		<div id="paypal-button-container"></div>
	</div>
</template>

<script>
	export default{
		mounted(){
			var vm = this;
			// Render the PayPal button
			paypal.Button.render({

			    // Set your environment

			    env: 'production', // sandbox | production

			    // Specify the style of the button

			    style: {
			        label: 'buynow',
			        fundingicons: true, // optional
			        branding: true, // optional
			        size:  'medium', // small | medium | large | responsive
			        shape: 'rect',   // pill | rect
			        color: 'gold',   // gold | blue | silver | black
			    },

			    // PayPal Client IDs - replace with your own
			    // Create a PayPal app: https://developer.paypal.com/developer/applications/create

			    client: {
			        sandbox:    'AZDxjDScFpQtjWTOUtWKbyN_bDt4OgqaF4eYXlewfBP4-8aqX3PiV8e1GWU6liB2CUXlkA59kJXE7M6R',
			        production: 'AakBLHEjmL1bP9uPQr2f1bF8DL8BDdiW2tZU3Oh-wS-rk7cgQkJfCsseW2YQ7Ujs79gEjyz5EX9c-O9c'
			    },

			    // Show the buyer a 'Pay Now' button in the checkout flow
			    commit: true,

			    // Wait for the PayPal button to be clicked

			    payment: function(data, actions) {
			        
			        var valor_plano = parseFloat(vm.total).toFixed(2);
			        var pais = vm.pais;
			        var email = vm.email;
			        if( pais == 'outro'){
			            var moeda = 'USD';
			        }else{
			            var moeda = 'BRL';
			        }
			        return actions.payment.create({
			            transactions: [{
			                    amount: { total: valor_plano, currency: moeda 
			                },
			                description: email+"",
			            }],
			        });
			    },

			    // Wait for the payment to be authorized by the customer

			    onAuthorize: function(data, actions) {
			        var valor_plano = parseInt(vm.total);
			       
			        return actions.payment.execute().then(function(data) {
			            if(data.state == 'approved'){
			                window.alert('Pagamento Aprovado, Plano será liberado logo em seguida!');
			                window.location.href = vm.url_obrigado_profissional;                    
			            }
			            if(data.state == 'failed'){
			                window.alert('Pagamento Falhou!');
			            }
			            if(data.state == 'created'){
			                window.alert('Por favor entre em contato, para podermos liberar seu plano caso tenha feito o pagamento.')
			            }                
			        });
			    }

			}, '#paypal-button-container');

		},
		props:[,'profissional','url_obrigado_profissional','email'],
		data(){
			return {
				plano:'',
				pais:'brasil',
				cupom_desconto:'',
				desconto:0,
				erro:'',
			}
		},
		methods:{
			limparValor: function(){
				this.plano = '';
				this.desconto = '';
				this.cupom_desconto = '';
			},
            validar(){
            	if(this.plano != ''){
	                var vm = this;
	                axios.post('./cupom/desconto/validar',{cupom_desconto: this.cupom_desconto}).then( res => {
	                    
	                    if(res.data.erro == 0){

	                        vm.desconto = res.data.resultado.desconto;
	                    }else{
	                        vm.erro = res.data.erro;
	                    }
	                });
            	}else{
            		this.erro = 'Escolha um plano antes!'
            	}
            }
		},
		computed:{
			total(){
				if(this.plano != ''){
					if(this.desconto == 0){
						return this.plano;
					}else{
						return this.plano - this.plano*this.desconto/100;
					}
				}
			}
		}
	}
</script>