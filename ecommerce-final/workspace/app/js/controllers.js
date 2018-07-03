angular.module('ecommerce.controllers', [])
    .controller('BemVindoController', function($scope, $http) {
        $scope.init = function() {

            $scope.listaCategorias = {}

            /* $http({
                 method: 'GET',
                 url: '/api/categoria/consultar.php?retornar_imagem=sim'
             }).then(function(response) {
                 $scope.listaCategorias = response.data;
             });*/

            $http.get('/api/categoria/consultar.php', {
                params: { retornar_imagem: 'sim' }
            }).then(function(response) {
                $scope.listaCategorias = response.data;
            });
        }
    })

    .controller('CategoriaController', function($scope, $http, $routeParams, $rootScope, $location) {

        $scope.listaCategorias = {};
        $scope.listaProdutos = {};

        $scope.init = function() {
            $http.get('/api/categoria/consultar.php')
                .then(function(response) {
                    $scope.listaCategorias = response.data;
                });

            $http.get('/api/produto/consultar.php', {
                params: { categoria: $routeParams.id, retornar_imagem: true }
            }).then(function(response) {
                $scope.listaProdutos = response.data;
            });
        }

        $scope.adicionarCarrinho = function(idCategoria, idProduto) {
            // Se não existe a lista, cria
            if ($rootScope.listaProdutosCarrinho == undefined) {
                $rootScope.listaProdutosCarrinho = [];
            }

            // Consultar na listagem de produtos o produto com o id informado
            $scope.listaProdutos.forEach(function(currentValue) {
                console.log("Exibiu o produto " + currentValue.id);

                if (currentValue.id == idProduto) {
                    var produtoCarrinho = buscarNoCarrinho(idProduto);

                    if (produtoCarrinho) {
                        produtoCarrinho.quantidade =
                            produtoCarrinho.quantidade = produtoCarrinho.quantidade = 1;
                    }
                    else {
                        currentValue.quantidade = 1;
                        $rootScope.listaProdutosCarrinho.push(currentValue);
                    }
                }
            });

            // redirecionar o usuario para a tela de carrinho
            $location.path('/categoria/' + idCategoria);

            Materialize.toast('Adicionado com sucesso', 1000, window.location.href = ("https://ecommerce-final-adrianofonseca1000.c9users.io/#!/carrinho"));
        }

        function buscarNoCarrinho(idProduto) {
            var retorno;

            $rootScope.listaProdutosCarrinho.forEach(function(currentValue) {
                if (currentValue.id == idProduto)
                    retorno = currentValue;
            });

            return retorno;
        }
    })

    .controller('CarrinhoController', function() {

    });
