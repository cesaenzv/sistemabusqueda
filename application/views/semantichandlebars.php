<script type="text/x-handlebars-template" id="semanticResourceTemplate">
	<div class="imgCont">
		{{#each this.edmPreview}}
			<img src="{{this}}" width="60" height="60">
		{{/each}}			
	</div>
	<div class="metaCont">
		<a href="{{this.guid}}" target="_blank" class="title">
		{{#each this.title}}
			<h4>{{this}}</h4>
		{{/each}}
		</a>
	</div>	
</script>




<script type="text/x-handlebars-template" id="semanticFinder">
	<div>
	 	<a class="btnView" id="openSearcher"></a>
	 	<a class="btnView" id="closeSearcher"></a>
	</div>
	<div>
		<label for:"term">Termino:<input id="term" name="term" {{#if term}}value="{{term}}"{{/if}} placeholder="busqueda semantica"></label>
		
		<button type='submit'>Buscar</button>
		<br/>
		{{#if facets}}
			<label>
				Discriminar recurso por:
				<select id="facets">
					<option value="-1">Todos</option>
					{{#each facets}}						
						<option value="{{@index}}" {{#ifEq ../idSelected @index}}selected{{/ifEq}}>{{name}}</option>
					{{/each}}
				</select>
			</label>
			<br/>
		{{/if}}

		{{#if facetData}}
		<label>
			Tipo:
			<select id="facetData">
				<option value="-1">Todos</option>
				{{#each facetData}}
					<option value:"{{label}}">{{label}}</option>
				{{/each}}
			</select>	
		</label>
		{{/if}}
	</div>
	{{#if totalResults}}
	<div>
		<label>Total Resultados: <span>{{totalResults}}</span></label>
	</div>
	{{/if}}
</script>