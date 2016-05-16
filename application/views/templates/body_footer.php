    <footer class="page-footer green lighten-1">
        <div class="container">
            <div class="row">
                <div class="col l6 s12">
                    <h5 class="white-text">AnnaTech</h5>
                    <p class="grey-text text-lighten-4">
                        Site de listing de sujet d'annales pour Polytech Montpellier.
                    </p>
                </div>
                <div class="col l4 offset-l2 s12">
                    <h5 class="white-text">Voir aussi</h5>
                    <ul>
                        <li><a class="grey-text text-lighten-3" href="#">A propos</a></li>
                        <li><a class="grey-text text-lighten-3" href="http://wave-it.fr/polytech/agenda">Agenda Polytech</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="footer-copyright">
            <div class="container">
                Kévin Servigé - IG3 2016
                <a class="grey-text text-lighten-4 right" href="http://wave-it.fr/">Wave-it</a>
            </div>
        </div>
    </footer>
    
    <script src="/content/js/vendor/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.6/js/materialize.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular.min.js"></script>

    <script>
        $(document).ready(function(){
            $(".button-collapse").sideNav();
            $(".modal-trigger").leanModal(
                in_duration: 100,
                ready: function() { 
                    var overlays = document.querySelectorAll(".lean-overlay");
                    setTimeout(function() {
                        for (var i = 0; i < overlays.length; i++) {
                            overlays[i].style.zIndex = 975;
                        }
                    }, 500);
                }
            );
        });
    </script>
    <script src="/content/js/app.js"></script>
    
    </body>
</html>