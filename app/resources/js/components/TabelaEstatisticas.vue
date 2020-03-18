<template>
    <div>
      <div class="box-header">
        <div class="row">
          <div class="col-md-2">
            <h3 class="box-title">{{estatisticaTitulo}}</h3>
          </div>
          <div class="col-md-10">
            <form class="row">
              <div class="form-group col-md-3">
                <label for="title"> Min. de jogos ant. por time</label>
                  <select name="n_jogos" class="form-control" v-model="min_jogos">
                  <option value="">-</option>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                  <option value="6">6</option>
                  <option value="7">7</option>
                  <option value="8">8</option>
                  <option value="9">9</option>
                  <option value="10">10</option>
                </select>
              </div>
              <div class="form-group col-md-3">
                <label for="title"> Total Escanteios min.</label>
                <input type="text" name="total_escanteios" class="form-control" v-model="total_escanteios" >
              </div>
              <div class="form-group col-md-3">
                <label for="title"> Total Escanteios min. CASA</label>
                <input type="text"  name="total_escanteios_casa" class="form-control" v-model="total_escanteios_casa">
              </div>
              <div class="form-group col-md-3">
                <label for="title"> Total Escanteios min. FORA</label>
                <input type="text" name="total_escanteios_fora" class="form-control" v-model="total_escanteios_fora">
              </div>
            </form>         
          </div>
        </div>
      </div>
      <div class="box-body">
        <div class="table-responsive">
          <table class="table table-striped">
              <thead>
                  <tr>
                      <th>Ações</th>
                      <th id='liga' style="cursor:pointer" v-on:click="ordenaColuna('liga')">Liga</th>
                      <th id='data_h' style="cursor:pointer" v-on:click="ordenaColuna('data')">Hora</th>
                      <th id="data_d" style="cursor:pointer" v-on:click="ordenaColuna('data')">Data</th>
                      <th style="cursor:pointer" v-on:click="ordenaColuna('jogo')">Jogo</th>
                      <th v-if="admin==1">Over 9</th>
                      <th id="probabilidade" style="cursor:pointer" v-on:click="ordenaColuna('probabilidade')">Probabilidade</th>
                  </tr>
              </thead>
              <tbody>
                  <tr v-for=" jogo in lista ">
                      <td>
                        <modal-link tipo="button" nome="adicionar-gestao" icone="fa fa-usd" css="btn btn-info btn-xs" :item="jogo.id" :url="url_gestao"></modal-link>
                        <modal-link tipo="button" nome="adicionar-lista" icone="fa fa-plus" css="btn btn-warning btn-xs" :item="jogo.id" :url='url_lista'></modal-link>
                      </td>
                      <td>
                          {{jogo.liga.l}}
                      </td>
                      <td class="fuso_time">{{jogo.start | mudaParaHora(zona) }}</td>
                      <td class="fuso_data">{{jogo.start | mudaParaData(zona)}}</td>
                      <td><strong><a style="color: #000;" target="_blank" :href="url_jogo+'/'+jogo.id"> {{jogo.time_casa.nome}} x {{jogo.time_fora.nome}} </a></strong></td>
                      
                      <td v-if="admin==1"><span class="badge bg-green">{{jogo.over9}} %</span></td>
                      <td><span class="badge bg-green">{{jogo.probabilidade}} cantos</span></td>
                  </tr>
                  
              </tbody>
          </table> 
        </div>
         <button class="botao-carregar btn-info" v-if="numero >= final" @click.prevent="carregarPaginas">Carregar mais jogos <i class="fa fa-eye"></i></button>  
      </div> 
    </div>           
</template>

<script>
    export default {
        mounted(){
            preloader(true);
            console.log(this.url)
            axios.get(this.url).then(res => {
                  console.log(res);
                 this.jogos = res.data;
                }).finally(res => {
                    preloader(false);
            });    


        },
        props:['url','url_lista','estatistica','url_jogo','zona','url_gestao','admin'],
        data(){
            return{
                jogos:[],
                ordemAuxCol:'probabilidade',
                ordemAux:'desc',
                total_escanteios:0,
                total_escanteios_casa:0,
                total_escanteios_fora:0,
                min_jogos:1,
                inicial:0,
                final:20,
                dados_por_pag:20,
                numero:'',
            }
        },
        filters:{
           mudaParaData: function(data,zona){
                var a = moment.tz(data, "America/Fortaleza");
                if(zona){
                    var b = a.tz(zona);
                }else{
                    var b = a.tz("America/Fortaleza");
                }
                
                return a.format('DD-MM-YYYY');
            },
            mudaParaHora: function(data,zona){
              var a = moment.tz(data, "America/Fortaleza");
              if(zona){
                  var b = a.tz(zona);
              }else{
                  var b = a.tz("America/Fortaleza");
              }

                return a.format('HH:mm');
            }
        },
        methods:{
          carregarPaginas(){
              
              this.final += this.dados_por_pag;
              
          },
          getMensagem(msg){
            alert(msg);
          },
          ordenaColuna: function(coluna){
          this.ordemAuxCol = coluna;
          if(coluna == 'liga'){
            $('#liga').css({"color": "#00a65a"});
            $('#data_h').css({"color": "black"});
            $('#data_d').css({"color": "black"});
            $('#total').css({"color": "black"});
            $('#probabilidade').css({"color": "black"});
          }
          if(coluna == 'data'){
            $('#data_h').css({"color": "#00a65a"});
            $('#data_d').css({"color": "#00a65a"});
            $('#liga').css({"color": "black"});
            $('#total').css({"color": "black"});
            $('#probabilidade').css({"color": "black"});
          }

          if(coluna == 'probabilidade'){
            $('#data_h').css({"color": "black"});
            $('#data_d').css({"color": "black"});
            $('#liga').css({"color": "black"});
            $('#total').css({"color": "black"});
            $('#probabilidade').css({"color": "#00a65a"});
          }

          if(coluna == 'total'){
            $('#data_h').css({"color": "black"});
            $('#data_d').css({"color": "black"});
            $('#liga').css({"color": "black"});
            $('#total').css({"color": "#00a65a"});
            $('#probabilidade').css({"color": "black"});
          }
          if(this.ordemAux.toLowerCase() == "asc"){
            this.ordemAux = 'desc';


          }else{
            this.ordemAux = 'asc';
          }
        }
      },
      computed:{
        estatisticaTitulo: function(){
              if(this.estatistica == 'ht1'){
                return 'Primeiro Tempo';
              } 
              if(this.estatistica == 'ht2'){
                return 'Segundo Tempo';
              } 
              if(this.estatistica == 'ft'){
                return 'Tempo Total';
              }
              
              return "Estratégia "+this.estatistica;
        },
        lista:function(){

          var vm = this;
          var ordem = this.ordemAux;
          var ordemCol = this.ordemAuxCol;
          ordem = ordem.toLowerCase();
          ordemCol = ordemCol.toLowerCase();
          var jogos_filtrados = this.jogos;

          if(ordem == "asc"){
           jogos_filtrados.sort(function(a,b){
                if(ordemCol == 'liga'){
                a = a.liga.l;
                b = b.liga.l;
                }
                if(ordemCol == 'data'){
                    a = a.start;
                    b = b.start;
                }
                if(ordemCol == 'probabilidade'){
                  a = a.probabilidade;
                  b = b.probabilidade;
                }

                if(ordemCol == 'total'){
                  a = a.ft;
                  b = b.ft;
                }
              if (a > b) { return 1;}
              if (a < b) { return -1;}
              return 0;
            });
          }else{
           jogos_filtrados.sort(function(a,b){
                if(ordemCol == 'liga'){
                a = a.liga.l;
                b = b.liga.l;
                }
                if(ordemCol == 'data'){
                    a = a.start;
                    b = b.start;
                }
                if(ordemCol == 'probabilidade'){
                  a = a.probabilidade;
                  b = b.probabilidade;
                }
                if(ordemCol == 'total'){
                  a = a.ft;
                  b = b.ft;
                }
              if (a < b) { return 1;}
              if (a > b) { return -1;}
              return 0;
            });
          }

        jogos_filtrados = jogos_filtrados.filter(res => {
                return (res.liga.ativo == 1 && res.n_jogos_casa >= vm.min_jogos && res.n_jogos_fora>=vm.min_jogos && res.probabilidade >= vm.total_escanteios && res.probabilidade_casa >= vm.total_escanteios_casa && res.probabilidade_fora >= vm.total_escanteios_fora);
            });

        this.numero = jogos_filtrados.length;
        if(jogos_filtrados.length >=this.dados_por_pag){
          jogos_filtrados =  jogos_filtrados.splice(this.inicial,this.final);
        }

          return jogos_filtrados;
        },
      }     
    }
</script>


<style type="text/css">

.botao-carregar {
    display: inline-block;
    padding: 6px 12px;
    margin-bottom: 0;
    font-size: 14px;
    font-weight: 400;
    line-height: 1.42857143;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    -ms-touch-action: manipulation;
    touch-action: manipulation;
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    background-image: none;
    border: 1px solid transparent;
    border-radius: 4px;
    width: 100%;
    height: 50px;
}
</style>