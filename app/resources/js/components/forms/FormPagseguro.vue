<template>
    <div>
        <p><b>(*)</b>Campos obrigratórios caso esteja habilitado para preenchimento.</p>
        <p>Pagseguro pode cobrar tarifa dependendo do tipo de pagamento. Hash da sua compra: {{hash}}</p>
        <div v-if='erro' class="alert alert-danger">
                <p><span class="fa fa-thumbs-o-down"></span> {{erro}}</p>
        </div>
        <form method="GET" class="col-md-12" id="form-pagseguro" :action="acao">
            <div class="col-md-8">
                <div class="row ">
                    <div class="form-group col-md-4">
                        <input type="hidden" id="token" :value="hash" name="token"/>
                        <!-- <input type="hidden" id="card_token" value="" name="card_token"/>
                        <input type="hidden" id="bandeira" value="" name="bandeira"/> -->
                        <label>Plano*</label>
                        <select name="plano" id="tipo_plano" class="form-control" required v-model='plano'>
                            <option value="">Escolha o plano</option>
                            <option value="profissional">Profissional</option>
                        </select>
                    </div>
                    <div v-if="plano != 'gratis'" class="form-group col-md-4">
                        <label>Pagamento*</label>
                        <select name="tipo_pagamento" id="tipo_pagamento" class="form-control" v-model='tipo_pagamento' required>
                            <option value="">Escolha o tipo de pagamento</option>
                            <option value="boleto">Boleto</option>
                             <!--<option value="cartao">Cartão de credito</option>--> 
                        </select>
                    </div>
                    <div v-if="plano != 'gratis'" class="form-group col-md-4">
                        <label>Cupom de Desconto (opcional)</label>
                        <input type="text" name="cupom_desconto" id="cupom_desconto" class="form-control" v-model='cupom_desconto' required> <button class="btn btn-success btn-xs" @click.prevent="validar"> Validar Cupom</button>
                        <input type="hidden" name="desconto" v-model='desconto'>
                        <div v-if='desconto!=0' class="alert alert-info">
                                <p><span class="fa fa-thumbs-o-up"></span> {{desconto}}% de desconto</p>
                        </div>
                    </div>
                </div>
                <!-- <div class="row">
                    <div class="form-group col-md-6">
                        <label>Cidade*</label>
                        <input type="text" name="cidade" value="{{auth()->user()->cidade}}" class="form-control" disabled="true">
                    </div>
                
                    <div class="form-group col-md-6">
                        <label>Estado*</label>
                        <input type="text" name="estado" value="{{auth()->user()->estado}}" class="form-control" disabled="true" maxlength="2">
                    </div>
                </div> -->
                <!-- <div class="row">
                    <div class="col-md-10">
                        <div class="form-group">
                            <label>Rua*</label>
                            <input type="text" name="rua" value="{{auth()->user()->rua}}" class="form-control" disabled="true">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Nº*</label>
                            <input type="text" name="numero" value="{{auth()->user()->numero}}" class="form-control" disabled="true">
                        </div>
                    </div>
                </div> -->
            </div>

            <!-- <div class="col-md-6">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label>Bairro*</label>
                        <input type="text" name="bairro" value="{{auth()->user()->bairro}}" class="form-control" disabled="true">
                    </div>
                    <div class="form-group col-md-6">
                        <label>CEP*</label>
                        <input type="text" name="cep" value="{{auth()->user()->cep}}" class="form-control" disabled="true">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label>Data de nascimento*</label>
                        <input type="date" name="data_aniversario" value="{{auth()->user()->data_aniversario}}" class="form-control" disabled="true">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Nº do cartão de credito*</label>
                        <input type="string" name="cartao"  value="" id="cartao" class="form-control" disabled="true">
                    </div>
                </div>
            
                <div class="row">
                    <div class="form-group col-md-4">
                        <label>CVV (se existir)</label>
                        <input type="string" name="cvv"  value="" id="cvv" class="form-control" disabled="true">
                    </div>
                    <div class="form-group col-md-4">
                        <label>Mês de vencimento*</label>
                        <input type="string"  value="" name="validadeMes" id="validadeMes" class="form-control" disabled="true">
                    </div>
                    <div class="form-group col-md-4">
                        <label>Ano de vencimento*</label>
                        <input type="string"  value="" name="validadeAno" id="validadeAno" class="form-control" disabled="true">
                    </div>
                </div>
            </div> -->
            
        </form>
            <button class="btn btn-success" @click="formSubmit">Adquirir</button>   
            <hr>
        <div class="row">

            <div class="col-md-6">
                <h2>Como adquirir um plano?</h2>
                <iframe width="560" height="315" src="https://www.youtube.com/embed/-PHXVHEQV9Q" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
            <div class="col-md-6">
                <h2>Tirando dúvidas sobre os planos?</h2>
                <iframe width="560" height="315" src="https://www.youtube.com/embed/DoxezM1D-WI" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
        </div>   
    </div>           
</template>

<script>
    

    
                
    export default {
        mounted(){
        preloader(true);
        PagSeguroDirectPayment.setSessionId('{{ PagSeguro::startSession() }}');
        
           var vm = this;

            PagSeguroDirectPayment.onSenderHashReady(function(response){
                    vm.hash = response.senderHash;  
                    if(response.senderHash != ''){
                        preloader(false);
                    }    

                });
            
            
        },
        props: ['acao'],
        data(){
          return{
            plano: '',
            tipo_pagamento: '',
            hash:'',
            cupom_desconto:'',
            desconto:0,
            erro:'',
          }
        },
        methods:{
            formSubmit(){
                if(hash != ''){
                    $('#form-pagseguro').submit();
                }else{
                    alert('Por favor atualize a pagina!');
                    window.location.reload();
                }
            },
            validar(){
                var vm = this;
                axios.post('./venda/cupom/desconto/validar',{cupom_desconto: this.cupom_desconto}).then( res => {
                    
                    if(res.data.erro == 0){

                        vm.desconto = res.data.resultado.desconto;
                    }else{
                        vm.erro =res.data.erro;
                    }
                });
            }
        }     
    }
</script>
