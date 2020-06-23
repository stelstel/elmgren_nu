
<div class="container-fluid footer-big mt-4">
		
	@if (Route::currentRouteName() == 'home')	
		<div class="row no-gutters mt-2">
			<div class="col">
				<p class="text-center">
					<a class="link-big-footer" data-toggle="collapse" href="#collapseKontakt" role="button" aria-expanded="false" aria-controls="collapseKontakt">
	          			Kontakt
	      			</a>
	      		</p>
	      		<div id="form-div-kontakt">
		      		<div class="collapse" id="collapseKontakt">
				        <div id="form-card-kontakt" class="card card-body text-white bg-light text-dark mt-2">
							<form method="post" action="{{ URL::route('submit') }}">
								{{ csrf_field() }}
								<div class="form-group">
									<label for="email-kontakt">Epostadress</label>
									<input type="email" class="form-control" id="email-kontakt" name="email" aria-describedby="emailHelp" required minlength="5" placeholder="Skriv din epostadress">
								</div>
								<div class="form-group">
									<label for="textarea">Meddelande</label>
									<textarea type="text" class="form-control" id="textarea" name="msg" rows="4" required minlength="3" maxlength="2024" placeholder="Skriv ditt meddelande"></textarea>
								</div>
								<div id="btn-form-kontakt">
									<button type="submit" class="btn btn-lg btn-outline-primary" name="submit">Skicka meddelande</button>
								</div>
							</form>
				        </div>
					</div>
				</div>
  			</div>
		</div>

		<div class="row no-gutters mt-2">
			<div class="col mx-auto">
					<p class="text-center">
						<a class="link-big-footer" data-toggle="collapse" href="#collapseCookie" role="button" aria-expanded="false" aria-controls="collapseExample">
							Cookieinformation
						</a>
					</p>
					<div class="collapse" id="collapseCookie">
						<div class="card card-body">
					    	<p>På vår webbplats används vanliga kakor och även så kallad localStorage.<br>Kakorna raderas efter besöket och vi kartlägger inte din aktivitet.<br>Du kan neka till kakor, granska vilka kakor som lagrats samt radera dessa med hjälp av funktioner i din webbläsare. Se webbläsarens dokumentation.<br>Utan de kakor som vi betecknat som nödvändiga i beskrivningen ovan kan du inte logga in och använda våra tjänster.
					    	</p>
					  	</div>
					</div>
			</div>
		</div>

		<div class="row no-gutters mt-1">
			<div class="col-sm-6 mx-auto">
				<p class="text-center"><a class="link-big-footer" href="{{ URL::route('home') }}">Till toppen av sidan</a></p>
				<p class="text-center"><a class="link-big-footer" href="{{ URL::route('home')  . '#de-senaste-fotona' }}">De senaste fotona</a></p>
				<p class="text-center"><a class="link-big-footer" href="{{ URL::route('home')  . '#alla-foton' }}">Alla foton</a></p>
			</div>

			<div class="col-sm-6 mx-auto">
				<p class="text-center"><a class="link-big-footer" href="{{ URL::route('home') . '#search-foton' }}">Sök foton</a></p>
				<p class="text-center"><a class="link-big-footer" href="{{ URL::route('home') . "#fodelsedagar" }}">Födelsedagar</a></p>
				<p class="text-center"><a class="link-big-footer" href="{{ URL::route('home') . "#epostadresser" }}">Epostadresser</a></p>
			</div>
		</div>
		
	@endif

	@if (Route::currentRouteName() == 'home')
		<div class="row no-gutters mt-1">
	@else
		<div class="row no-gutters mt-2">
	@endif
			<div class="col-sm-12 mx-auto">
				<div class="col-sm-6 mx-auto">
					<p class="text-center text-big-footer">webmaster@elmgren.nu</p>
				</div>
				<div class="col-sm-6 mx-auto">
					<p class="text-center text-big-footer">@ Stefan Elmgren 2002-2020</p>
				</div>
			</div>
		</div>
</div>
