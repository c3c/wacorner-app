<template>
	<li>
		<a :href="notification.url">
		    <h5><i :class="'fa fa-'+notification.icone"></i> {{notification.titulo}}</h5>

		  	<p>{{notification.texto}}</p>
		  	<hr>
		</a>
	</li>
</template>

<script>
	export default{
		props:['notification'],
	}
</script>