<script type="text/x-handlebars-template" id="resourceTemplate">
	{{#each resources}}
		<li>
			<div class="resourceBox">
						
				<article>										
					<h4 class="resourceTitle">{{title}}</h4>
					<p>{{description}}</p>					
					<button class="ui-state-active">Ver mas</button>
					<div class="rating">PONER CALIFICACION</div>
				</article>
				<div class="data hidden">
					<span class="popupDesc">Description:</span>
					<p class="descParagraph">{{description}}</p>
					<img src="img/{{type}}.png" class="popupImg"/>
					<span class="popupDesc">Subject:</span>
					<div class="subject"><p>{{subject}}</p></div>
					<a href={{link}} target="_blank" class="popupLink">Ir a fuente...</a>
				</div>			
			</div>
		</li>
	{{/each}}
	<div id="popUp" title="Recurso">		
	</div>
</script>