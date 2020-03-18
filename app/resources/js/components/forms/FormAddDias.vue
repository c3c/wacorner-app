<template>
    <form @submit.prevent="formSubmit">
        <input type="hidden" name="_token" :value="token">
        <div class="form-group">
          <input type="text" name="dias" v-model="dias">
        </div>
    </form>
</template>

<script>
    export default {
        props: ['token','jogo_id','url'],
        data(){
          return{
            dias:'',
          }
        },
        methods: {
            formSubmit(e) {
                e.preventDefault();
                var currentObj = this;
                var user_id = this.$store.state.Listas.item;
                
                axios.post(this.url, {
                    user_id: user_id,
                    dias: currentObj.dias
                })
                .then(function (response) {
                    alert('Adicionado!');
                })
                .catch(function (error) {
                    console.log(error);
                });
            }
        }
        
    }
</script>
