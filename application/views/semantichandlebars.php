<script type="text/x-handlebars-template" id="resourceTemplate">

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




