<template>
	<div>
		 <div v-if='erro' class="alert alert-danger">
                <p>
					<span class="fa fa-thumbs-o-down"></span> {{erro}}
				</p>
        </div>
		<!--<div class="row">
	        <div class="form-group">
	            <label>Escolha seu país*:</label>
	            <br>
	            <input type="radio" v-model="pais" @click="limparValor" value="brasil" autocomplete="off" checked>  Brasil
	            <input type="radio" v-model="pais" @click="limparValor" value="outro" autocomplete="off"> Outro País
	        </div>
	    </div>-->
		<div class="row ">
			<div class="form-group">
			    <label>Plano*</label>
	            <select v-if="pais == 'BRL'"  class="form-control" v-model="plano" required>
	                <option v-if="profissional == false" value="29.99">Profissional - R$29,99</option>
	            </select>
			    <select v-if="pais != 'BRL'"  class="form-control" v-model="plano" required>
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
		<!--<h4><b>País:</b> {{pais.toLowerCase()}}</h4>-->
		<h4 v-if="pais == 'BRL'"><b>Valor Plano:</b> {{total}} reais</h4>
		<h4 v-if="pais != 'BRL'"><b>Valor Plano:</b> {{total}} dolares</h4>
		<div id="paypal-button-container"></div>
	</div>
</template>

<script>
	export default{
		mounted(){
			var vm = this;
			// Render the PayPal button
            paypal.Buttons({
                createOrder: function(data, actions) {
                preloader(true);
                var valor_plano = parseFloat(vm.total).toFixed(2);
                var pais = vm.pais;

                if( pais == 'EUA'){
                    var moeda = 'USD';
                }else{
                    var moeda = 'BRL';
                }
                // This function sets up the details of the transaction, including the amount and line item details.
                return actions.order.create({
                    purchase_units: [{
                    amount: {
                        currency_code: moeda,
                        value: valor_plano
                    }
                    }]
                });
                },
                onApprove: function(data, actions) {
                // This function captures the funds from the transaction.
                return actions.order.capture().then(function(details) {
                    // This function shows a transaction success message to your buyer.
                    if(details.status.toLowerCase() == 'approved' || details.status.toLowerCase() == 'completed'){
                        window.alert('Pagamento Aprovado, Plano será liberado logo em seguida!');
                        window.location.href = vm.url_obrigado_profissional;
                    } else if(details.status.toLowerCase() == 'created'){
                        window.alert('Por favor entre em contato, para podermos liberar seu plano caso tenha feito o pagamento.')
                    } else {
                        window.alert('Pagamento Falhou!');
                    }
                    preloader(false);
                });
                }

            }).render('#paypal-button-container');
		},
		props:[,'profissional','pais','url_obrigado_profissional','email'],
		data(){
			return {
				plano:'',
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
