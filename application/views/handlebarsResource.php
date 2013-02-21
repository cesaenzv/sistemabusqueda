<script type="text/x-handlebars-template" id="resourceTemplate">
	{{#each resources}}
		<li>
			<div class="resourceBox">			
				<fieldset>										
					<legend>{{title}}</legend>
					<p>{{description}}</p>					
					<button>Ver mas</button>
					<div>PONER CALIFICACION</div>
				</fieldset>
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