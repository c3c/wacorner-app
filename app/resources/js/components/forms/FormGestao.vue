<template>
    <form @submit.prevent="formSubmit">
        <input type="hidden" name="_token" :value="token">
        <input type="hidden" id='jogo_id' :value="$store.state.Gestoes.jogo">
        <div class="form-group">
          <label for="title">  Estratégia</label>
            <select class="form-control" v-model='selecionado'>
              <option value="">Escolha a estratégia</option>
              <option v-for="estrategia in $store.state.Gestoes.estrategias" :value="estrategia.id">{{estrategia.nome}}</option>
            </select>
        </div>
        <div class="form-group">
            <label for="title"> Entrada</label>
            <input type="text" v-model="entrada" class="form-control">
        </div>
        <div class="form-group">
            <label for="title"> Odd</label>
            <input type="text" v-model="odd" class="form-control">
        </div>
        <div class="form-group">
            <label for="title"> Resultado</label>
            <select class="form-control" v-model='resultado'>
              <option value="pendente">💤 PENDENTE</option>
              <option value="green">✔️ GREEN</option>
              <option value="red">❌ RED</option>
            </select>
        </div>
    </form>
</template>

<script>
    export default {
        props: ['token','url_gestao','entrada'],
        data(){
          return{
            selecionado: '',
            odd:'1.7',
            resultado:'pendente',
          }
        },
        methods: {
            formSubmit(e) {
                e.preventDefault();
                var currentObj = this;
                var jogo_id = $("#jogo_id").val();
                
                if(this.entrada == '' || this.odd == '' || this.selecionado == ''){
                    alert('Erro: verifique os dados digitados!');
                }else{

                    axios.post(this.url_gestao+'/entrada/criar', {
                        jogo_id: jogo_id,
                        estrategia_id: currentObj.selecionado,
                        stake: currentObj.entrada.replace(',', '.'),
                        odd: currentObj.odd.replace(',', '.'),
                        resultado: currentObj.resultado
                    })
                    .then(function (response) {
                        alert(response.data.resultado);
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
                }
            }
        }
        
    }
</script>
