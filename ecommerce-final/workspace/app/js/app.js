angular.module('ecommerce', ['ngRoute', 'ecommerce.controllers'])
    .config(function($routeProvider) {
        $routeProvider
            .when('/', {
                templateUrl: '/app/pages/bemvindo.html',
                controller: 'BemVindoController'
            })
            .when('/categoria/:id', {
                templateUrl: '/app/pages/categoria.html',
                controller: 'CategoriaController'
            })
            .when('/carrinho', {
                templateUrl: '/app/pages/carrinho.html',
                controller: 'CarrinhoController'
            })
            .otherwise({
                redirectTo: '/'
            });
    });
