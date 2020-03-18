<template>
  <div>
  <canvas :id="id" height="300" width="500"></canvas>
  </div>
</template>
<script>

export default {
  created(){
  },
  props: {
    labels:{
      type:Array,
      default: null
    },
    jogos: {
      type: Array,
      default: null
    },
    id: {
      type: String,
      default:null
    }
  },
  computed:{
    dataCantos: function(){
     var aux_favor = [];
      var aux_contra = [];
      var aux_total = [];
      var inicio = 0; 
      var fim = 5; 
      for(var x =0; x<this.labels.length; x++){
        for(var k = 0; k<this.jogos.length;k++){
          for(var i = 0; i<this.jogos[k].eventos.length;i++){
   
            if(parseInt(this.jogos[k].eventos[i].t)>inicio && parseInt(this.jogos[k].eventos[i].t)<=fim){
              if(this.id == 'time_casa'){
                if(parseInt(this.jogos[k].eventos[i].casa) == 1){
                  
                  aux_favor[x]  = aux_favor[x] ? aux_favor[x]+1 : 1;
                  
                }else{
                  aux_contra[x]  = aux_contra[x] ? aux_contra[x]+1 : 1;
                }
              }else{
                if(parseInt(this.jogos[k].eventos[i].casa) != 1){
                  
                  aux_favor[x]  = aux_favor[x] ? aux_favor[x]+1 : 1;
                  
                }else{
                  aux_contra[x]  = aux_contra[x] ? aux_contra[x]+1 : 1;
                }
              }
              

              aux_total[x]  =aux_total[x] ? aux_total[x]+1 : 1;
            }
          }
        }
        inicio = fim;
        fim +=5;
        if(!aux_favor[x]){
          aux_favor[x] = 0;
        }
        if(!aux_contra[x]){
          aux_contra[x] = 0;
        }
        if(!aux_total[x]){
          aux_total[x] = 0;
        }
      } 

      return [{label:'Favor',data: aux_favor,backgroundColor:'#87ceeb'},{label:'Contra',data: aux_contra,backgroundColor:'#fa7f72'},{label:'Total',data: aux_total,backgroundColor:'green'}];
    }
  },
  mounted () {
    var ctx = document.getElementById(this.id).getContext('2d');
    var data = {
      labels: this.labels,
      datasets: this.dataCantos
    }
    var myChart = new Chart(ctx, {
      type: 'bar',
      data: data,
      // options: {
      //   // "hover": {
      //   //   "animationDuration": 0
      //   // },
      //   "animation": {
      //     "duration": 1,
      //     "onComplete": function() {
      //       var chartInstance = this.chart,
      //         ctx = chartInstance.ctx;

      //       ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
      //       ctx.textAlign = 'center';
      //       ctx.textBaseline = 'bottom';

      //       this.data.datasets.forEach(function(dataset, i) {
      //         var meta = chartInstance.controller.getDatasetMeta(i);
      //         meta.data.forEach(function(bar, index) {
      //           var data = dataset.data[index];
      //           ctx.fillText(data, bar._model.x, bar._model.y - 5);
      //         });
      //       });
      //     }
      //   },
        options:{
            title: {
                display: true,
                text: 'Número de cantos a cada 5 minutos'
            },
        },
        tooltips: {
          "enabled": false
        },
        scales: {
          yAxes: [{
            display: true,
            ticks: {
              stepSize: 2,
              max: Math.max(...data.datasets[0].data) + 10,
              display: true,
              beginAtZero: true
            }
          }],
          xAxes: [{

            gridLines: {
              
              display: true
            },
            ticks: {
              beginAtZero: true
            }
          }]
        }
      
    });
  }//Fim do mounted
}
</script>