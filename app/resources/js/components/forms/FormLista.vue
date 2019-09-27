<template>
    <form @submit.prevent="formSubmit">
        <input type="hidden" name="_token" :value="token">
        <input type="hidden" id='jogo_id' :value="$store.state.Listas.item">
        <div class="form-group">
          <label for="title"> Lista</label>
            <select class="form-control" v-model='selecionado'>
              <option v-for="lista in $store.state.Listas.listas" :value="lista.id">{{lista.nome}}</option>
            </select>
        </div>
    </form>
</template>

<script>
    export default {
        props: ['token','jogo_id','url_lista'],
        data(){
          return{
            selecionado: '',
            output: '',
          }
        },
        methods: {
            formSubmit(e) {
                e.preventDefault();
                var currentObj = this;
                var jogo_id = $("#jogo_id").val();
                var lista = currentObj.selecionado;
                if(lista){
                    axios.post(this.url_lista+'/jogo/add', {
                        jogo_id: jogo_id,
                        lista_id: currentObj.selecionado
                    })
                    .then(function (response) {
                        alert(response.data.resultado);
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
                }else{
                    alert('Primeiro você deve selecionar uma lista');
                }
            }
        }
        
    }
</script>
