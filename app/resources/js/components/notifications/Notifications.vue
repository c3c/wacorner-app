<template>
	
	<li class="dropdown messages-menu">
	    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
	      <i class="fa fa-bell-o"></i>
	      <span class="label label-warning">{{notifications.length}}</span>
	    </a>
	    <ul class="dropdown-menu">
	     
	      <li>
	        <!-- inner menu: contains the actual data -->
	        <ul class="menu-notificacao">
	            <notification v-if="notifications.length>0" v-for="notification in notifications" :key="notification.id" :notification="notification.data"></notification>
	            <h5 v-if="notifications.length<=0"><i class="fa fa-frown-o"></i> <em>Sem notificações</em></h5>
	        </ul>
	      </li>
	      <li class="footer"><a href="#" @click.prevent="markAsReadAll()">Limpar Notificações</a></li>
	    </ul>
	  </li>
</template>
<script>
	export default{
		created(){
			this.$store.dispatch('loadNotifications',this.url)
		},
		computed: {
			notifications(){
				return this.$store.state.Notifications.itens;
			}
		},
		props: ['url'],
		methods:{
			markAsReadAll(){
				this.$store.dispatch('markAsReadAll',this.url)
			}
		}
		
	}
</script>

<style type="text/css">

	.menu-notificacao{
		list-style: none;
		margin-top: 20px;
		margin-left: -30px;
		padding: auto;
	}

	.menu-notificacao h5{
		font-weight: bold;
		color: #000;
		padding: 5px;
		margin: 0;
	}
	.menu-notificacao li{
		margin: -9px 0px 0px -9px;
	}
	.menu-notificacao a{
		color: #00a65a;
	}
	.menu-notificacao li:hover{
		background: #F6F4F4  ;
	}
	
	.skin-green .main-header .navbar .dropdown-menu li a {
	    color: #00a65a;
	}

	.skin-green .main-header .navbar .dropdown-menu li a:hover {
	    color: #000;
	}

</style>