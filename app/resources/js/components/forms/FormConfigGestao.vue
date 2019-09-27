<template>
    <form @submit.prevent="formSubmit">
        <input type="hidden" name="_token" :value="token">
        <div class="form-group">
          <label for="title"> Banca Inicial</label>
            <input type="text" class="form-control" id="banca_inicial" :value="$store.state.Gestoes.banca_inicial">
        </div>
        <div class="form-group">
          <label for="title"> Stake (opcional)</label>
            <input type="text" class="form-control" id="stake" :value="$store.state.Gestoes.stake">
        </div>
    </form>
</template>

<script>
    export default {
        props: ['token'],
        data(){
          return{
          }
        },
        methods: {
            formSubmit(e) {
                $('#botao-salvar-config-gestao').text('Aguarde...').attr("disabled", true);
                e.preventDefault();
                var currentObj = this;    
                var banca_inicial =$("#banca_inicial").val();
                var stake =$("#stake").val();
                if(!stake){
                    stake = 0;
                }
                
                axios.post('./gestao/update', {
                    banca_inicial: banca_inicial.replace(',', '.'),
                    stake: stake.replace(',', '.'),
                    valor_investido: currentObj.$store.state.Gestoes.valor_investido,
                    lucro: currentObj.$store.state.Gestoes.lucro,
                })
                .then(function (response) {
                    swal ( "Sucesso..." ,  response.data.resultado , "success" );
                    currentObj.$store.dispatch('getGestao');
                    $('#botao-salvar-config-gestao').text('Salvar').attr("disabled", false);
                })
                .catch(function (error) {
                    console.log(error);
                    $('#botao-salvar-config-gestao').text('Salvar').attr("disabled", false);
                });
            }
        }
        
    }
</script>
