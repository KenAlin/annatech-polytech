<div class="row">
	<div class="col s12">
		<h5>Liste des sujets en <?php echo $nom_mat; ?></h5>
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
				<p ng-show="infos.description">{{infos.description}}</p>
			</div>
			<div class="card-action sectionsLiens white-text" ng-style="{ 'background-color': '#' + infos.color}">
				<a href="/nouveausujet/{{infos.id_mat}}" ng-show="logged_in">Nouveau sujet</a>
			</div>
		</div>
	</div>
	
	<div class="col s12 m8 l9" ng-controller="listeSujetsCtrl">
		
		<div class="row">
			<div class="col s12 m6 l4" ng-hide="sujets.length">
				<div class="card red lighten-5">
					<div class="card-content">
						<span class="card-title">Pas de sujet</span>
						<p>Aucun sujet n'a été publié pour cette matière (pour l'instant ?).</p>
					</div>
				</div>
			</div>
			
			<div class="col s12 m6 l4" ng-repeat="sujet in sujets">
				<div class="card grey lighten-5">
					<div class="card-content">
						<span class="card-title">{{sujet.annee}}</span>
						<p>{{sujet.titre}}</p>
					</div>
					<div class="card-action">
						<a class="modal-trigger" ng-click="open(sujet.id_suj)">+ d'infos</a>
					</div>
				</div>
			</div>
			
			<div ng-repeat="sujet in sujets" id="modal_{{sujet.id_suj}}" class="modal" ng-controller="correctionsCtrl" ng-init="suppr = -1">
				<div class="modal-content">
					<h4>{{sujet.titre}} ({{sujet.annee}})</h4>
					<p ng-show="sujet.rattrapage == 'f'">Sujet de 1è session.</p>
					<p ng-hide="sujet.rattrapage == 'f'">Sujet de rattrapage.</p>
					<p>Les sujets présents sur le site AnnaTech sont fournis par les étudiants en l'état, sans garantie aucune.	AnnaTech n'est nullement responsable de l'utilisation qui en est faite. Si vous êtes l'auteur d'un sujet et souhaitez en demander le retrait, contactez l'administrateur par mail à l'adresse kevin@wave-it.fr.</p>
					<div>
						<p ng-show="!listCorrections.fromAjax.length">Aucune correction disponible pour ce sujet</p>
						<p ng-show="listCorrections.fromAjax.length === 1">Correction pour ce sujet :</p>
						<p ng-show="listCorrections.fromAjax.length > 1">Corrections pour ce sujet :</p>
						<p ng-show="supprMessage"><i>{{supprMessage}}</i></p>
						<ul ng-show="listCorrections.fromAjax.length">
							<li ng-repeat="cor in listCorrections.fromAjax">
								<a href="/content/files/{{cor.url}}" target="_blank">{{cor.titre}}</a>
								<a ng-show="admin" ng-click="suppr = cor.id_suj">(supprimer)</a>
								<a ng-show="admin && suppr == cor.id_suj" ng-click="suppr = -1">(supprimer : non)</a>
								<a ng-show="admin && suppr == cor.id_suj" ng-click="supprCorrection(cor.id_suj)">(supprimer : oui)</a> 
							</li>
						</ul>
					</div>
				</div>
				<div class="modal-footer">
					<a href="/content/files/{{sujet.url}}" target="_blank" class="modal-action modal-close btn waves-effect waves-blue">Télécharger (.pdf)</a>
					<a href="/nouvellecorrection/{{sujet.id_suj}}" target="_blank" class="modal-action modal-close waves-effect waves-blue btn-flat" ng-show="logged_in">Proposer une correction</a>
					<a class="modal-action waves-effect waves-blue btn-flat" ng-show="admin" ng-click="suppr = sujet.id_suj">Supprimer le sujet</a>
					<a class="modal-action waves-effect waves-blue btn-flat" ng-show="admin && suppr == sujet.id_suj" ng-click="suppr = -1">(supprimer : non)</a>
					<a class="modal-action waves-effect waves-blue btn-flat" ng-show="admin && suppr == sujet.id_suj" ng-click="supprSujet(sujet.id_suj)">(supprimer : oui)</a>
					<a class="modal-action waves-effect waves-blue btn-flat" ng-show="supprSujetMessage">{{supprSujetMessage}}</a>
				</div>
			</div>
			
		</div>
	</div>
</div>

<script>
	var page_id_mat = <?php echo $id_mat; ?>;
</script>