<script type="text/x-handlebars-template" id="formTemplate">
	<div id="steps">
		<form id="formElem" name="formMetadata" action="formc/saveFormData" method="post">
		<input type="hidden" id="id_europeana_term" name="id_europeana_term"></input>
			{{#each formM}}
				<fieldset class="step" id="{{formName}}">
					<legend>{{formName}}</legend>
					{{#each fieldForm}}

						{{#if optionsSelect}}
						<p>
						<label for="{{column_name}}">{{column_name}}</label>
						<select {{attribute}} name="{{column_name}}" id="{{column_name}}">
								{{#each optionsSelect}}
								{{{this}}}
								{{/each}}
						</select>
						</p>
							

						{{else}}
						
							<p>
								<label for="{{column_name}}">{{column_name}}:</label>				
								<{{tagType}} {{attribute}} name="{{column_name}}" id="{{column_name}}"/>
							</p>

						{{/if}}
					{{/each}}
				</fieldset>
			{{/each}}
			<div class="Confirm">
                <legend>Confirm</legend>					
                <p class="submit">
                    <button id="registerButton" type="submit">Enviar</button>
                </p>
            </div>
		</form>
	</div>
	<div id="navigation">
		<ul>
			{{#each formM}}
				<li {{listAttribute}}>
					<a href="#{{formName}}">{{formName}}</a>
				</li>
			{{/each}}
		</ul>			
	</div>
</script>