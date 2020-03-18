<template>
    <div>
        <div class="row">
            <div class="col-md-4">
              <h4><b> Nº de jogos:</b> {{numero}} jogos</h4>
              <div class="form-group">
                  <input type="text" placeholder="Buscar time ou liga" v-model="buscar" class="form-control">
              </div>
            </div>
            <div class="col-md-8">
              <h4>Selecione as colunas que deseja exibir:</h4>
                <label class="checkbox-inline">
                <input type="checkbox" id="ht10" value="ht10" v-model="colunasSelecionadas"> HT10
                </label>
                <label class="checkbox-inline">
                <input type="checkbox" id="ht35" value="ht35" v-model="colunasSelecionadas"> HT35
                </label>
                <label class="checkbox-inline">
                <input type="checkbox" id="ht38" value="ht38" v-model="colunasSelecionadas"> HT38
                </label>
                <label class="checkbox-inline">
                <input type="checkbox" id="ft75" value="ft75" v-model="colunasSelecionadas"> FT75
                </label>
                <label class="checkbox-inline">
                <input type="checkbox" id="ft82" value="ft82" v-model="colunasSelecionadas"> FT82
                </label>
                <label class="checkbox-inline">
                <input type="checkbox" id="ft88" value="ft88" v-model="colunasSelecionadas"> FT88
                </label>
                <label class="checkbox-inline">
                <input type="checkbox" id="ft" value="ft" v-model="colunasSelecionadas"> FT
                </label>
                <label class="checkbox-inline">
                <input type="checkbox" id="ht1020" value="ht1020" v-model="colunasSelecionadas"> 10 a 20min HT
                </label>
                <label class="checkbox-inline">
                <input type="checkbox" id="ht1" value="ht1" v-model="colunasSelecionadas"> Média 1ºT
                </label>
                <label class="checkbox-inline">
                <input type="checkbox" id="ht2" value="ht2" v-model="colunasSelecionadas">  Média 2ºT
                </label>
            </div>
        </div>
    
      <div class="table-responsive">
        <table id="tabela" class="table table-striped">
            <thead>
                <tr>
                    <th>Ações</th>
                    <th id='liga' style="cursor:pointer" v-on:click="ordenaColuna('liga')">Liga</th>
                    <th id='data_h' style="cursor:pointer" v-on:click="ordenaColuna('data')">Hora</th>
                    <th id="data_d" style="cursor:pointer" v-on:click="ordenaColuna('data')">Data</th>
                    <th style="cursor:pointer" v-on:click="ordenaColuna('Jogo')">Jogo</th>
                    <transition name="bounce">
                      <th v-if="checaColuna('ht10')" style="cursor:pointer" v-on:click="ordenaColuna('HT10')">Estratégia <br><i>HT10</i></th>
                    </transition>
                    <transition name="bounce">
                      <th v-if="checaColuna('ht1020')" style="cursor:pointer" v-on:click="ordenaColuna('HT1020')">Estratégia <br><i>HT1020</i></th>
                    </transition>
                    <transition name="bounce">
                      <th v-if="checaColuna('ht35')" style="cursor:pointer" v-on:click="ordenaColuna('HT35')">Estratégia <br><i>HT35</i></th>
                    </transition>
                    <transition name="bounce">
                      <th v-if="checaColuna('ht38')" style="cursor:pointer" v-on:click="ordenaColuna('HT38')">Estratégia <br><i>HT38</i></th>
                    </transition>
                    <transition name="bounce">
                      <th v-if="checaColuna('ft75')" style="cursor:pointer" v-on:click="ordenaColuna('FT75')">Estratégia <br><i>FT75</i></th>
                    </transition>
                    <transition name="bounce">
                      <th v-if="checaColuna('ft82')" style="cursor:pointer" v-on:click="ordenaColuna('FT82')">Estratégia <br><i>FT82</i></th>
                    </transition>
                    <transition name="bounce">
                      <th v-if="checaColuna('ft88')" style="cursor:pointer" v-on:click="ordenaColuna('FT88')">Estratégia <br><i>FT88</i></th>
                    </transition>
                    <transition name="bounce">
                      <th v-if="checaColuna('ht1')" style="cursor:pointer" v-on:click="ordenaColuna('ht1')">Média <br><i>1º Tempo</i></th>
                    </transition>
                    <transition name="bounce">
                      <th v-if="checaColuna('ht2')" style="cursor:pointer" v-on:click="ordenaColuna('ht2')">Média  <br><i>2º Tempo</i></th>
                    </transition>
                    <transition name="bounce">
                      <th v-if="checaColuna('ft')" style="cursor:pointer" v-on:click="ordenaColuna('Total')">Média Total</th>
                    </transition>
                </tr>
            </thead>
            <tbody>
                <tr v-for=" jogo in lista ">
                    <td>
                      <modal-link tipo="button" nome="adicionar-gestao" icone="fa fa-usd" css="btn btn-info btn-xs" :item="jogo.id" :url="url_gestao"></modal-link>
                      <modal-link tipo="button" nome="adicionar-lista" icone="fa fa-plus" css="btn btn-warning btn-xs" :item="jogo.id" :url='url_lista'></modal-link>
                    </td>
                    <td>{{jogo.liga.l}}</td>
                    <td>{{jogo.start | mudaParaHora(zona) }}</td>
                    <td>{{jogo.start | mudaParaData(zona)}}</td>
                    <td><strong><a style="color: #000;" target="_blank" :href="url_jogo+'/'+jogo.id"> {{jogo.time_casa.nome}} x {{jogo.time_fora.nome}} </a></strong></td>
                    <transition name="bounce">
                      <td v-if="checaColuna('ht10')"><span class="badge bg-green">{{jogo.ht10}}%</span></td>
                    </transition>
                    <transition name="bounce">
                      <td v-if="checaColuna('ht1020')"><span class="badge bg-green">{{jogo.ht1020}}%</span></td>
                    </transition>
                    <transition name="bounce">
                      <td v-if="checaColuna('ht35')"><span class="badge bg-green">{{jogo.ht35}}%</span></td>
                    </transition>
                    <transition name="bounce">
                      <td v-if="checaColuna('ht38')"><span class="badge bg-green">{{jogo.ht38}}%</span></td>
                    </transition>
                    <transition name="bounce">
                      <td v-if="checaColuna('ft75')"><span class="badge bg-green">{{jogo.ft75}}%</span></td>
                    </transition>
                    <transition name="bounce">
                      <td v-if="checaColuna('ft82')"><span class="badge bg-green">{{jogo.ft82}}%</span></td>
                    </transition>
                    <transition name="bounce">
                      <td v-if="checaColuna('ft88')"><span class="badge bg-green">{{jogo.ft88}}%</span></td>
                    </transition>
                    <transition name="bounce">
                      <td v-if="checaColuna('ht1')"><span class="badge bg-green">{{jogo.ht1}} cantos</span></td>
                    </transition>
                    <transition name="bounce">
                      <td v-if="checaColuna('ht2')"><span class="badge bg-green">{{jogo.ht2}} cantos</span></td>
                    </transition>
                    <transition name="bounce">
                      <td v-if="checaColuna('ft')"><span class="badge bg-green">{{jogo.ft}} cantos</span></td>
                    </transition>
                </tr>
            </tbody>
        </table>  
      </div>

        <button class="botao-carregar btn-info" v-if="numero >= final" @click.prevent="carregarPaginas">Carregar mais jogos <i class="fa fa-eye"></i></button>   
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
        props:['url','token','url_lista','url_jogo','zona','url_gestao'],
        data(){
            return{
                jogos:[],
                buscar:'',
                ordemAuxCol:'hora',
                ordemAux:'asc',
                n_jogos:0,
                colunasSelecionadas:['ht35','ft75','ft82','ft'],
                inicial:0,
                final:20,
                dados_por_pag:20,
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
          checaColuna(coluna){
            var aux = this.colunasSelecionadas.filter(res => {
              if(res == coluna){
                return true;
              }
              return false;
            });

            return aux.length>0;
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
          }
          if(coluna == 'data'){
            $('#data_h').css({"color": "#00a65a"});
            $('#data_d').css({"color": "#00a65a"});
            $('#liga').css({"color": "black"});
          }
          if(this.ordemAux.toLowerCase() == "asc"){
            this.ordemAux = 'desc';


          }else{
            this.ordemAux = 'asc';
          }
        }
      },
        computed:{
        lista:function(){
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
              if (a < b) { return 1;}
              if (a > b) { return -1;}
              return 0;
            });
          } 

          //FILTRO
         jogos_filtrados = jogos_filtrados.filter(res => {
                return (res.liga.ativo == 1 && res.n_jogos_casa > 0 && res.n_jogos_fora>0);
            });
         //FILTRO
        if(this.buscar){
            jogos_filtrados = jogos_filtrados.filter(res => {
                if( res.time_casa.nome.toLowerCase().indexOf(this.buscar.toLowerCase())>=0 || 
                    res.time_fora.nome.toLowerCase().indexOf(this.buscar.toLowerCase())>=0 || 
                    res.liga.l.toLowerCase().indexOf(this.buscar.toLowerCase())>=0){
                    return true;
                }
                return false;
            });
          }


          if(jogos_filtrados.length >=this.dados_por_pag){
            jogos_filtrados =  jogos_filtrados.splice(this.inicial,this.final);
          }

         

          return jogos_filtrados;
        },
        numero: function(){
            var jogos = this.jogos;
            jogos = jogos.filter(res => {
                return (res.liga.ativo == 1 && res.n_jogos_casa > 0 && res.n_jogos_fora>0);
            });
             if(this.buscar){
              jogos = jogos.filter(res => {
                  if( res.time_casa.nome.toLowerCase().indexOf(this.buscar.toLowerCase())>=0 || 
                      res.time_fora.nome.toLowerCase().indexOf(this.buscar.toLowerCase())>=0 || 
                      res.liga.l.toLowerCase().indexOf(this.buscar.toLowerCase())>=0){
                      return true;
                  }
                  return false;
              });
            }
            return jogos.length;
        }
      }     
    }
</script>

<style type="text/css">
  .bounce-enter-active {
  animation: bounce-in .5s;
}
.bounce-leave-active {
  animation: bounce-in .5s reverse;
}
@keyframes bounce-in {
  0% {
    transform: scale(0);
  }
  50% {
    transform: scale(1.5);
  }
  100% {
    transform: scale(1);
  }
}

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