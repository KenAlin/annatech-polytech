<body ng-app="annatech" ng-controller="userContextCtrl">
    <nav>
        <div class="row nav-wrapper teal lighten-3">
            <div class="col s12">
                <a href="/" class="brand-logo"><img src="/content/img/logo_annatech_50.png"></a>
                <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="fa fa-bars"></i></a>
                <ul class="right hide-on-med-and-down">
                    <li><a href="/">Accueil</a></li>
                    <li><a href="/about">A propos</a></li>
                    <li ng-hide="logged_in"><a href="/utilisateur">Espace utilisateurs</a></li>
                    <li ng-show="logged_in"><a href="/utilisateur">Profil ({{username}})</a></li>
                </ul>
                <ul class="side-nav" id="mobile-demo">
                    <li><a href="/">Accueil</a></li>
                    <li><a href="/about">A propos</a></li>
                    <li ng-hide="logged_in"><a href="/utilisateur">Espace utilisateurs</a></li>
                    <li ng-show="logged_in"><a href="/utilisateur">Profil ({{username}})</a></li>
                </ul>
            </div>
        </div>
    </nav>