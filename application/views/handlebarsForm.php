<script type="text/x-handlebars-template" id="formTemplate">
	<div id="steps">
		<form id="formElem" name="formMetadata" action="" method="post">
			{{#each formM}}
				<fieldset class="step">
					<legend>{{formName}}</legend>
					{{#each fieldForm}}
						<p>
							<label for="{{column_name}}">{{column_name}}:</label>				
							<input {{attribute}} type="{{column_type}}" name="{{column_name}}"/>
						</p>						
					{{/each}}
				</fieldset>
			{{/each}}
			<fieldset class="step">
                <legend>Confirm</legend>					
                <p class="submit">
                    <button id="registerButton" type="submit">Register</button>
                </p>
            </fieldset>
		</form>
	</div>
	<div id="navigation">
		<ul>
			{{#each formM}}
				<li {{listAttribute}}>
					<a href="#">{{formName}}</a>
				</li>
			{{/each}}
		</ul>			
	</div>
</script>