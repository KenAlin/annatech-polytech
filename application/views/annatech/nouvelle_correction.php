<div class="row">
	<div class="col s12">
		<h5>Nouveau correction en <?php echo $nom_mat; ?></h5>
	</div>
</div>

<div class="row" ng-controller="infosMatiereCtrl">
	<div class="col s12 m4 l3">
		<div class="card center-align">
			<div class="card-image">
				<img ng-src="/content/img/spe/thumb/{{ infos.ico }}">
			</div>
			<div class="card-content">
				<span class="card-title">{{infos.nom_mat}}</span>
              	<p>{{infos.nom_section}} - {{infos.annee}}è année</p>
				<p>** Poster une correction **</p>
			</div>
			<div class="card-action sectionsLiens white-text" ng-style="{ 'background-color': '#' + infos.color}">
				<a href="/matiere/{{infos.id_mat}}">Liste des sujets</a>
			</div>
		</div>
	</div>
	
	<div class="col s12 m8 l9">
		<div class="card">
			<div class="card-content">
				<h4>Poster une correction</h4>
              	<p>Utilisez ce formulaire pour proposer une correction. Soyez-sûr de ne poster aucun doublon, et de fournir un fichier (.pdf uniquement, maximum 6 Mo) de bonne qualité.</p>
				
				<?php if (isset($reponse) && $reponse == "error") { ?>  
				<div class="card red lighten-4">
					<div class="card-content">
						Erreur à la saisie - veuillez vérifier tous les champs. La correction doit être en format PDF, et doit peser moins de 6 Mo.
					</div>
				</div>
				<?php } ?>
				
				<?php if (isset($reponse) && $reponse == "success") { ?>  
				<div class="card green lighten-4">
					<div class="card-content">
						Correction envoyée avec succès !
					</div>
				</div>
				<?php } ?>
				
				<form method="post" id="formNewCorrection" action="/remote/upload/newcorrection/<?php echo $id_suj; ?>" enctype="multipart/form-data">
					<div class="file-field input-field">
						<div class="btn">
							<span>Correction (.pdf uniquement)</span>
							<input type="file" name="file">
						</div>
						<div class="file-path-wrapper">
							<input class="file-path validate" type="text">
						</div>
					</div>
					<div class="input-field">
						<input id="formTitle" type="text" name="titre" class="form-control">
						<label for="formTitle">Titre (ex. Examen final)</label>
					</div>
				</form>
				  
			</div>
			<div class="card-action right-align">
				<button class="btn waves-effect waves-light" type="submit" form="formNewCorrection" value="Submit">Envoyer</button>
			</div>
		</div>
	</div>
	
</div>

<script>
	var page_id_mat = <?php echo $id_mat; ?>;
	var page_id_suj = <?php echo $id_suj; ?>;
</script>