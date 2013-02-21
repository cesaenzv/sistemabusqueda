<script type="text/x-handlebars-template" id="template">
	<div>			
		<h3>{{criterio}}</h3>
		<ul>								
			{{#each convenciones}}
				<li>
					<div class="color" style="background-color:{{color}};"></div>
					<p>{{nombreCampo}}: {{cantidadRecursos}}</p>
				</li>	
			{{/each}}
		</ul>
	</div>
</script>