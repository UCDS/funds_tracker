angular.module('bank_accountsApp', ['ngRoute'])
  .config(function($routeProvider) {
    $routeProvider.when('/', {
      templateUrl: 'index.php/bank_account/bank_book_summary',
      controller: 'Bank_accountCtrl'
    });
    $routeProvider.otherwise({
      redirectTo: '/'
    });
  });
