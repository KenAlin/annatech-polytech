<div class="row">
	<div class="col s12">
		<h5>Nouveau sujet en <?php echo $nom_mat; ?></h5>
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
				<p>** Poster un nouveau sujet **</p>
			</div>
			<div class="card-action sectionsLiens white-text" ng-style="{ 'background-color': '#' + infos.color}">
				<a href="/matiere/{{infos.id_mat}}">Liste des sujets</a>
			</div>
		</div>
	</div>
	
	<div class="col s12 m8 l9">
		<div class="card">
			<div class="card-content">
				<h4>Poster un nouveau sujet</h4>
              	<p>Utilisez ce formulaire pour poster un nouveau sujet. Soyez-sûr de ne poster aucun doublon, et de fournir un fichier (.pdf uniquement, maximum 6 Mo) de bonne qualité. Sont acceptés : sujets d'examen, de contrôle continu, de contrôle de groupe, de projet, de TP noté.</p>
				
				<?php if (isset($reponse) && $reponse == "error") { ?>  
				<div class="card red lighten-4">
					<div class="card-content">
						Erreur à la saisie - veuillez vérifier tous les champs. Le sujet doit être en format PDF, et doit peser moins de 6 Mo.
					</div>
				</div>
				<?php } ?>
				
				<?php if (isset($reponse) && $reponse == "success") { ?>  
				<div class="card green lighten-4">
					<div class="card-content">
						Sujet envoyé avec succès !
					</div>
				</div>
				<?php } ?>
				
				<form method="post" id="formNewSujet" action="{{'/remote/upload/newsujet/'+infos.id_mat}}" enctype="multipart/form-data">
					<div class="file-field input-field">
						<div class="btn">
							<span>Sujet (.pdf uniquement)</span>
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
					<div class="input-field">
						<input id="formAnnee" type="text" name="annee" class="form-control">
						<label for="formAnnee">Année (ex. 2015 pour 2015-2016)</label>
					</div>
					<div class="input-field">
						<input type="checkbox" id="formRattrapage" name="rattrapage" class="form-control">
						<label for="formRattrapage">Est un sujet de rattrapage</label>
					</div>
				</form>
				  
			</div>
			<div class="card-action right-align">
				<button class="btn waves-effect waves-light" type="submit" form="formNewSujet" value="Submit">Envoyer</button>
			</div>
		</div>
	</div>
	
</div>

<script>
	var page_id_mat = <?php echo $id_mat; ?>;
</script>