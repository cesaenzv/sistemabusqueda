<script type="text/x-handlebars-template" id="resourceTemplate">
	{{#each resources}}
		<li>
			<div class="resourceBox">			
				<article>										
					<h4 class="resourceTitle">{{title}}</h4>
					<p>{{description}}</p>					
					<button>Ver mas</button>
					<div class="rating">PONER CALIFICACION</div>
				</article>
				<div class="data hidden">
					<span>DESCRIPCION:</span>
					<p>{{description}}</p>
					<img src="img/{{eurotype}}.png"/>
					<span>SUBJECT:</span>
					<div class="subject">{{subject}}</div>
					<a href={{link}} target="_blank">Ir a fuente...</a>
				</div>			
			</div>
		</li>
	{{/each}}
	<div id="popUp" title="Recurso">		
	</div>
</script>