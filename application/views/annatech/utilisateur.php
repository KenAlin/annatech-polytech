<section>
	<?php if (isset($activate) && $activate) { ?>
	<div class="row">
		<div class="col s12">
			<?php if ($reply_activate == "error") { ?>
			<div class="card red lighten-4">
			<?php } else { ?>
			<div class="card green lighten-4">
			<?php } ?>
				<div class="card-content">
					<p><?php echo $message_activate; ?></p>
				</div>
			</div>
		</div>
	</div>	
	<?php } ?>
	
	
	<div class="row" ng-hide="logged_in">
		<div class="col s12 l6" ng-controller="loginController">			
			<div class="card">
				<div class="card-content">
					<span class="card-title">Se connecter</span>
					<p>Une connexion est requise. Veuillez saisir vos identifiants. Votre login est de la forme <i>prenom.nom</i>.</p>
					<form name="loginForm" id="loginForm" ng-submit="submitLoginForm()">
						<div class="row">
							<div class="col s12" ng-show="errorLoginForm">
								<div class="card red lighten-4">
									<div class="card-content">
										<p>{{errorLoginForm}}</p>
									</div>
								</div>
							</div>
							<div class="input-field col s12 m6">
								<input id="formLoginLogin" type="text" name="login" class="form-control" ng-model="user.login">
								<label for="formLoginLogin">Login</label>
							</div>
							<div class="input-field col s12 m6">
								<input id="formLoginMdp" type="password" name="pass" class="form-control" ng-model="user.password">
								<label for="formLoginMdp">Mot de passe</label>
							</div>
						</div>
					</form>
				</div>
				<div class="card-action">
					<button class="btn waves-effect waves-light" type="submit" value="submit" form="loginForm">Se connecter</button>
				</div>
			</div>
		</div>
		
		<div class="col s12 l6" ng-controller="newAccountController">			
			<div class="card">
				<div class="card-content">
					<span class="card-title">Créer un compte</span>
					<p>Un message de confirmation sera envoyé sur votre adresse <i>prenom.nom@polytech.univ-montp2.fr</i>. Le mot de passe utilisé sur AnnaTech est indépendant de celui utilisé pour Polytech Montpellier.</p>
					<form name="newAccountForm" id="newAccountForm" ng-submit="submitNewUserForm()">
						<div class="row">
							<div class="col s12" ng-show="errorNewUserForm && !successNewUserForm">
								<div class="card red lighten-4">
									<div class="card-content">
										<p>{{errorNewUserForm}}</p>
									</div>
								</div>
							</div>
							<div class="col s12" ng-show="successNewUserForm && !errorNewUserForm">
								<div class="card green lighten-4">
									<div class="card-content">
										<p>{{successNewUserForm}}</p>
									</div>
								</div>
							</div>
							<div class="input-field col s12 m6">
								<input id="formNewUserLogin" type="text" name="login" class="form-control" ng-model="newuser.login">
								<label for="formNewUserLogin">Nom de compte Polytech (forme prenom.nom)</label>
							</div>
							<div class="input-field col s12 m6">
								<input id="formNewUserMdp" type="password" name="pass" class="form-control" ng-model="newuser.password">
								<label for="formNewUserMdp">Mot de passe</label>
							</div>
						</div>
					</form>
				</div>
				<div class="card-action">
					<button class="btn waves-effect waves-light green" type="submit" value="submit" form="newAccountForm">Créer un compte</button>
				</div>
			</div>
		</div>
		
	</div>
	
	<div class="row" ng-show="logged_in">
		<div class="col s12">
			<div class="card">
				<div class="card-content">
					<span class="card-title">Votre compte</span>
					<p>Vous êtes connecté en tant que {{username}}.</p>
					<p ng-show="admin">Privilèges administrateur activés !</p>
					<p>Vous avez posté {{nbsujets}} sujet(s) et correction(s).</p>
				</div>
				<div class="card-action">
					<a href="/utilisateur/deconnexion">Se déconnecter</a>
				</div>
			</div>
		</div>
		
		<div class="col s12" ng-controller="changePwdController">
			<div class="card">
				<div class="card-content">
					<span class="card-title">Changer de mot de passe</span>
					<p>Votre nouveau mot de passe doit comporter au moins 8 caractères.</p>
					<form name="pwdForm" id="formChangePwd" ng-submit="submitPwdForm()">
						<div class="row">
							<div class="col s12" ng-show="errorPwdForm && !successPwdForm">
								<div class="card red lighten-4">
									<div class="card-content">
										<p>{{errorPwdForm}}</p>
									</div>
								</div>
							</div>
							<div class="col s12" ng-show="successPwdForm && !errorPwdForm">
								<div class="card green lighten-4">
									<div class="card-content">
										<p>{{successPwdForm}}</p>
									</div>
								</div>
							</div>
							<div class="input-field col s12 m4">
								<input id="formMdp" type="password" name="pass" class="form-control" ng-model="pwd.password">
								<label for="formMdp">Mot de passe actuel</label>
							</div>
							<div class="input-field col s12 m4">
								<input id="formNewMdp" type="password" name="newpass" class="form-control" ng-model="pwd.newpass">
								<label for="formNewMdp">Nouveau mot de passe</label>
							</div>
							<div class="input-field col s12 m4">
								<input id="formNewMdp2" type="password" name="newpass2" class="form-control" ng-model="pwd.newpass2">
								<label for="formNewMdp2">Confirmer le nouveau mot de passe</label>
							</div>
						</div>
					</form>
				</div>
				<div class="card-action">
					<button class="btn waves-effect waves-light" type="submit" value="submit" form="formChangePwd">Changer</button>
				</div>
			</div>
		</div>
		
		
	</div>
</section>