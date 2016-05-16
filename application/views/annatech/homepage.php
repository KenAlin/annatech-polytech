<div class="row" ng-controller="sectionsCtrl">
	<div class="col s12 m6 l3" ng-repeat="section in sections">
		<div class="card small center-align">
			<div class="card-image">
					<img ng-src="/content/img/spe/thumb/{{ section.ico }}">
					<span class="card-title black-text card-title-section">{{ section.nom_section }}</span>
			</div>
			<div class="card-content">
					<p>{{ section.nom_complet }}</p>
			</div>
			<div class="card-action sectionsLiens white-text" ng-style="{ 'background-color': '#' + section.color}">
				<a href="/section/{{ section.nom_section }}/3">3A</a>
				<a href="/section/{{ section.nom_section }}/4">4A</a>
				<a href="/section/{{ section.nom_section }}/5">5A</a>
			</div>
		</div>
	</div>
</div>