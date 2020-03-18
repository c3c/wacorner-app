<template>
    <div>
      <div class="box-header">
        <div class="row">
          <div class="col-md-2">
            <h3 class="box-title">{{estrategiaTitulo}}</h3>
          </div>
          <div class="col-md-10">
            <div class="form-inline">
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
            <label for="title"> Porcentagem min.</label>
              <select name="porcentagem" class="form-control" v-model="porcentagem">
                <option value="">-</option>
                <option value="10">10</option>
                <option value="20">20</option>
                <option value="30">30</option>
                <option value="40">40</option>
                <option value="50">50</option>
                <option value="60">60</option>
                <option value="70">70</option>
                <option value="80">80</option>
                <option value="90">90</option>
              </select>
            <label for="title"> Porcentagem min. CASA</label>
              <select name="porcentagem_casa" class="form-control" v-model="porcentagem_casa">
                <option value="">-</option>
                <option value="10">10</option>
                <option value="20">20</option>
                <option value="30">30</option>
                <option value="40">40</option>
                <option value="50">50</option>
                <option value="60">60</option>
                <option value="70">70</option>
                <option value="80">80</option>
                <option value="90">90</option>
              </select>
            <label for="title"> Porcentagem min. FORA</label>
              <select name="porcentagem_fora" class="form-control" v-model="porcentagem_fora">
                <option value="">-</option>
                <option value="10">10</option>
                <option value="20">20</option>
                <option value="30">30</option>
                <option value="40">40</option>
                <option value="50">50</option>
                <option value="60">60</option>
                <option value="70">70</option>
                <option value="80">80</option>
                <option value="90">90</option>
              </select>    
              </div>         
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
                      <th id="total" style="cursor:pointer" v-on:click="ordenaColuna('total')">Média Total</th>
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
                      <td ><span class="badge bg-green">{{jogo.ft}} cantos</span></td>
                      <td><span class="badge bg-green">{{jogo.probabilidade}}%</span></td>
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

            axios.get(this.url).then(res => {
                 this.jogos = res.data;
                }).finally(res => {
                    preloader(false);
            });    


        },
        props:['url','url_lista','estrategia','url_jogo','zona','url_gestao'],
        data(){
            return{
                jogos:[],
                ordemAuxCol:'probabilidade',
                ordemAux:'desc',
                porcentagem:0,
                porcentagem_casa:0,
                porcentagem_fora:0,
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
        estrategiaTitulo: function(){
              if(this.estrategia == 'ht10'){
                return '10 minutos HT';
              } 
              if(this.estrategia == 'ht1020'){
                return '10 a 20 minutos HT';
              } 
              if(this.estrategia == 'ht35'){
                return '35 minutos HT';
              }
              if(this.estrategia == 'ht38'){
                return '38 minutos HT';
              }
              if(this.estrategia == 'ft75'){
                return '75 minutos FT';
              }
              if(this.estrategia == 'ft82'){
                return '82 minutos FT';
              }
              if(this.estrategia == 'ft88'){
                return '88 minutos FT';
              }
              return "Estratégia "+this.estrategia;
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
                return (res.liga.ativo == 1 && res.n_jogos_casa >= vm.min_jogos && res.n_jogos_fora>=vm.min_jogos && res.probabilidade >= vm.porcentagem && res.probabilidade_casa >= vm.porcentagem_casa && res.probabilidade_fora >= vm.porcentagem_fora);
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