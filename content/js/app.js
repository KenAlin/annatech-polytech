var app = angular.module('annatech', []);

app.config(['$httpProvider', function($httpProvider) {
        $httpProvider.defaults.useXDomain = true;
        delete $httpProvider.defaults.headers.common['X-Requested-With'];
    }
]);

app.controller('sectionsCtrl', function($scope, $http) {
    $http.get("/api/section").then(function(response) {
        $scope.sections = response.data;
    });
});

app.controller('agendaCtrl', function($scope, $http) {
    $http.get("http://wave-it.fr/polytech/content/remote/exists?s="+page_section+page_annee).then(function(response) {
        $scope.agendaExists = response.data.reponse;
    });
});

app.controller('userContextCtrl', function($scope, $http, $rootScope) {
    $http.get("/api/user/infos").then(function(response) {
        $scope.logged_in = response.data.logged_in;        
        $scope.username = response.data.username;
        $scope.admin = response.data.admin;
        $scope.nbsujets = response.data.nbsujets;
    });
    $rootScope.$on('loggedIn', function () {
        $http.get("/api/user/infos").then(function(response) {
            $scope.logged_in = response.data.logged_in;        
            $scope.username = response.data.username;
            $scope.admin = response.data.admin;
            $scope.nbsujets = response.data.nbsujets;
        });
    });
});

app.controller('loginController', function($scope, $http, $rootScope) {
    $scope.user = {};
    $scope.submitLoginForm = function() {
        $http({
            method  : 'POST',
            url     : '/api/user/login/',
            data    : $scope.user,
            headers : {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'} 
        })
        .success(function(data) {
            if (data.error) {
                $scope.errorLoginForm = data.error;
            } else {
                $scope.message = data.message;
                if (data.success) {
                    $rootScope.$broadcast('loggedIn');
                }
            }
        });
    };
});

app.controller('newAccountController', function($scope, $http, $rootScope) {
    $scope.newuser = {};
    $scope.submitNewUserForm = function() {
        $http({
            method  : 'POST',
            url     : '/api/user/create/',
            data    : $scope.newuser,
            headers : {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'} 
        })
        .success(function(data) {
            if (data.error) {
                $scope.errorNewUserForm = data.error;
            } else if (data.success) {
                $scope.successNewUserForm = data.message;
            }
        });
    };
});

app.controller('changePwdController', function($scope, $http, $rootScope) {
    $scope.pwd = {};
    $scope.submitPwdForm = function() {
        $http({
            method  : 'POST',
            url     : '/api/user/changepassword/',
            data    : $scope.pwd,
            headers : {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'} 
        })
        .success(function(data) {
            if (data.error) {
                $scope.errorPwdForm = data.error;
            } else if (data.success) {
                $scope.successPwdForm = data.message;
            }
        });
    };
});

app.controller('uesCtrl', function($scope, $http) {
    $http.get("/api/section/"+page_section+"/"+page_annee)
    .then(function(response) {
        $scope.UEs = response.data;
    });
});

app.controller("matieresCtrl", function($scope, $http) {
    $scope.listMat = {};
    $scope.listMat.getList = function(id_ue) {
        var listing = $http.get("/api/matieres/"+id_ue);

        listing.success(function(data, status, headers, config) {
            $scope.listMat.fromAjax = data;
        });
        listing.error(function(data, status, headers, config) {
            $scope.listMat.fromAjax = "Impossible de récupérer les données pour le moment.";
        });
    }
});

app.controller('infosMatiereCtrl', function($scope, $http) {
    $http.get("/api/matiere/"+page_id_mat)
    .then(function(response) {
        $scope.infos = response.data[0];
    });
});

app.controller('listeSujetsCtrl', function($scope, $http, $rootScope) {
    $http.get("/api/sujets/"+page_id_mat)
        .then(function(response) {
            $scope.sujets = response.data;
    });
    
    $scope.open = function(id) {
        $('#modal_'+id).openModal();
        $rootScope.$broadcast('openedModal', id);
    }
    
    $rootScope.$on('supprSujet', function() {
        $http.get("/api/sujets/"+page_id_mat)
            .then(function(response) {
                $scope.sujets = response.data;
        });
    });
});

app.controller("correctionsCtrl", function($scope, $http, $rootScope) {
    $scope.listCorrections = {};
    $scope.listCorrections.getList = function(id_suj) {
            var listing = $http.get("/api/corrections/"+id_suj);
            $scope.id_suj = id_suj;

            listing.success(function(data, status, headers, config) {
                $scope.listCorrections.fromAjax = data;
            });
            listing.error(function(data, status, headers, config) {
                $scope.listCorrections.fromAjax = "Impossible de récupérer les corrections pour le moment.";
            });
        };
    $rootScope.$on('openedModal', function(event, id) {
        $scope.listCorrections.getList(id);
    });
    $scope.supprCorrection = function (id_cor) {
        var suppression = $http.get("/remote/delete/correction/"+id_cor);
        suppression.success(function(data, status, headers, config) {
            $scope.supprMessage = data.message;
            $scope.listCorrections.getList($scope.id_suj);
        });
        suppression.error(function(data, status, headers, config) {
            $scope.supprMessage = "Echec de la suppression.";
        });
    };
    $scope.supprSujet = function (id_sujet) {
        var suppressionSujet = $http.get("/remote/delete/sujet/"+id_sujet);
        suppressionSujet.success(function(data, status, headers, config) {
            if (data.success) {
                $('#modal_'+id_sujet).closeModal();
                $rootScope.$broadcast('supprSujet');
            }
            else {
                $scope.supprSujetMessage = "Echec de la suppression.";
            }
        });
        suppressionSujet.error(function(data, status, headers, config) {
            $scope.supprSujetMessage = "Problème serveur.";
        });
    };
});

app.controller('newSujetCtrl', function($scope, $http) {
    $scope.newSujet = new FormData();
    $scope.changeFile = function(files) {
        $scope.newSujet.append("file", files[0]);
    };
    $scope.submitNewSujetForm = function(id_mat) {
        $http({
            method  : 'POST',
            url     : '/api/upload/newsujet/'+id_mat,
            data    : $scope.newSujet,
            transformRequest : angular.identity,
            headers : {'Content-Type': 'undefined'}
        })
        .success(function(data) {
            if (data.error) {
                $scope.errorNewSujetForm = data.error;
            } else {
                $scope.message = data.message;
                if (data.success) {
                    $rootScope.$broadcast('newSujetIsPosted');
                }
            }
        });
    };
});