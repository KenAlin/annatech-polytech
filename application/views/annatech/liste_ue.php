<div class="row" ng-controller="agendaCtrl">
	<div class="col s12 center-align">
		<div class="card center-align">
			<div class="card-content">
				<h5>Liste des UEs en <?php echo $section; ?> (<?php echo $annee; ?>è année)</h5>
			</div>
			<div class="card-action" ng-show="agendaExists">
				<a href="http://wave-it.fr/polytech/<?php echo $section.$annee; ?>">Emploi du temps</a>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col s12" ng-controller="uesCtrl">
		<ul class="collapsible" data-collapsible="accordion" ng-controller="matieresCtrl">
			<li ng-repeat="ue in UEs">
				<div class="collapsible-header" ng-click="listMat.getList(ue.id_ue)">
					S{{ue.semestre}} - {{ue.nom_ue}}
				</div>
				<div class="collapsible-body">
					<div class="row row-inside-collapsible">
						<div class="col s12">
							<div class="chip" ng-repeat="mat in listMat.fromAjax">
								<a href="/matiere/{{ mat.id_mat }}">{{mat.nom_mat}}</a>
							</div>
						</div>
					</div>
				</div>
			</li>
		</ul>
	</div>
</div>

<script>
	var page_section = "<?php echo $section; ?>";
	var page_annee = <?php echo $annee; ?>;
</script>