var gruposApp = angular.module('gruposApp', []);

gruposApp.controller('GruposCtrl', function ($scope, $http) {
    
  $scope.matrimonios = [];
  $scope.solteros = [];
  $scope.bajan_poco = [];
  $scope.ausentes = [];

    $http.get(url_matrimonios_get).success(function(data){
          $scope.matrimonios = data;
    });
    
    $http.get(url_solteros_get).success(function(data){
          $scope.solteros = data;
    });
    
//    $http.get(web_url+'/bajan_poco.json').success(function(data){
//          $scope.bajan_poco = data;
//    });
    
    $http.get(url_ausentes_get).success(function(data){
          $scope.ausentes = data;
    });
  
  $scope.showMatrimonioForm = false;
  $scope.matrimonio_nuevo = {};
  $scope.addMatrimonio = function(){
        $http.post(url_matrimonios_post, {nombre:$scope.matrimonio_nuevo.nombre}).success(function(data){
            $scope.matrimonio_nuevo = {'id': data.id, 'nombre': data.nombre};
            $scope.matrimonios.push($scope.matrimonio_nuevo);
            $scope.matrimonio_nuevo = {};
        });
  };
  $scope.deleteMatrimonio = function(index){
        var id = $scope.matrimonios[index].id;
        $http.delete(url_matrimonios_delete+id).success(function(data){
            $scope.matrimonios.splice(index, 1);
        });
  };
  
  $scope.showSolteroForm = false;
  $scope.soltero_nuevo = {};
  $scope.addSoltero = function(){
        $http.post(url_solteros_post, {nombre:$scope.soltero_nuevo.nombre}).success(function(data){
            $scope.soltero_nuevo = {'id': data.id, 'nombre': data.nombre};
            $scope.solteros.push($scope.soltero_nuevo);
            $scope.soltero_nuevo = {};
        });
  };
  $scope.deleteSoltero = function(index){
        var id = $scope.solteros[index].id;
        $http.delete(url_solteros_delete+id).success(function(data){
            $scope.solteros.splice(index, 1);
        });
  };
  
  $scope.ausentarMatrimonio = function(index){
        var id = $scope.matrimonios[index].id;
        $http.post(url_hermanos_put+id, {ausente:1}).success(function(data){
            $scope.ausentes.push($scope.matrimonios[index]);
            $scope.matrimonios.splice(index, 1);
        });
  };
  $scope.ausentarSoltero = function(index){
        var id = $scope.solteros[index].id;
        $http.post(url_hermanos_put+id, {ausente:1}).success(function(data){
            $scope.ausentes.push($scope.solteros[index]);
            $scope.solteros.splice(index, 1);
        });
  };
  $scope.desAusentar = function(index){
        var id = $scope.ausentes[index].id;
        $http.post(url_hermanos_put+id, {ausente:0}).success(function(data){
            if(data.tipo === 'matrimonio') {
                $scope.matrimonios.push($scope.ausentes[index]);
            } else if(data.tipo === 'soltero') {
                $scope.solteros.push($scope.ausentes[index]);
            }
            $scope.ausentes.splice(index, 1);
        });
  };
  
  $scope.deleteAusente = function(index){
        var id = $scope.ausentes[index].id;
        $http.delete(url_ausentes_delete+id).success(function(data){
            $scope.ausentes.splice(index, 1);
        });
  };


  
  
  $scope.num_grupos = 6;
  $scope.numPersonas = function() {
      return 2*$scope.matrimonios.length + $scope.solteros.length + $scope.bajan_poco.length;
  }

  $scope.Math = window.Math;
  //$scope.num_personas_grupo = Math.floor($scope.num_personas / $scope.num_grupos);
  $scope.grupos = [];
  
  $scope.tabMenu = 0;
  
  $scope.setTabMenu = function(tab) {
      $scope.tabMenu = tab;
  };
  
  $scope.checkTabMenu = function(tab) {
      return tab === $scope.tabMenu;
  };
  
  $scope.hacerGrupos = function() {

    var num_grupos = $scope.num_grupos;
    var num_personas = $scope.numPersonas();
    var num_personas_grupo = Math.floor(num_personas / $scope.num_grupos);
    var matrimonios = $scope.matrimonios;
    var solteros = $scope.solteros;
    var bajan_poco = $scope.bajan_poco;

      var contador_personas_grupo = new Array();

      //Creamos num_grupos todavía sin personas
      var grupos = new Array();
      for(g=0;g<num_grupos;g++)
      {
        grupos.push(new Array());
        contador_personas_grupo[g] = 0;
      }

      //Metemos los matrimonios en los grupos que salgan al azar.
      for(m=0;m<matrimonios.length;m++)
      {
        var num_grupo = parseInt(Math.random() * num_grupos);
        grupos[num_grupo].push(matrimonios[m]);
        contador_personas_grupo[num_grupo] += 2;
      }

      //Vamos rellenando los grupos con hermanos solteros al azar
      var copia_solteros = solteros.slice();
      var copia_bajan_poco = bajan_poco.slice();
      var barajados = false;
      for(g=0;g<num_grupos;g++)
      {
        for(p=contador_personas_grupo[g];p<num_personas_grupo;p++)
        {
          s = parseInt(Math.random() * copia_solteros.length);
          grupos[g].push(copia_solteros[s]);
          copia_solteros.splice(s,1); //Elimina al hermano de la lista
          contador_personas_grupo[g] += 1;
          if(copia_solteros.length == 0)
          {
            copia_solteros = copia_bajan_poco;
            for(gaux=0;gaux<num_grupos;gaux++)
            {
              grupos[gaux] = shuffle(grupos[gaux]);
            }
            barajados = true;
          }
        }

      }

      //Los grupos ya están completos pero a lo mejor quedan hermanos sin grupo 
      if(copia_solteros.length == 0) 
      {
        copia_solteros = copia_bajan_poco;
        if(!barajados)
          for(gaux=0;gaux<num_grupos;gaux++)
            {
              grupos[gaux] = shuffle(grupos[gaux]);
            }
            barajados = true;
      }

      while(copia_solteros.length>0)
      {
        g = parseInt(Math.random() * num_grupos);
        if(contador_personas_grupo[g] == num_personas_grupo)
        {
          grupos[g].push(copia_solteros[0]);
          copia_solteros.splice(0,1);
          contador_personas_grupo[g] += 1;
          if(copia_solteros.length == 0) 
          {
            copia_solteros = copia_bajan_poco;
            if(!barajados)
            for(gaux=0;gaux<num_grupos;gaux++)
              {
                grupos[gaux] = shuffle(grupos[gaux]);
              }
              barajados = true;
          }
        }
      }
      $scope.grupos = grupos;

    }
  
});

gruposApp.directive('draggable', function() {
    return {
        // A = attribute, E = Element, C = Class and M = HTML Comment
        restrict:'A',
        link: function(scope, element, attrs) {
            element.draggable({
                revert:true
          });
        }
    }    
});

gruposApp.directive('droppable', function($compile) {
    return {
        restrict: 'A',
        link: function(scope,element,attrs){
            element.droppable({
                //accept: ".draggable",
                hoverClass: "drop-hover",
                drop:function(event,ui) {
                    $(this).append(ui.draggable);
                    var dragged = angular.element(ui.draggable).parent();
                    var dropped = angular.element(this);
                    console.log(dragged);
                    console.log(dropped[0].id);
                }
            });    
        }
        
    };
});






//function hacergruposminpersonas(num_personas_min)
//{
//  num_grupos = Math.floor(num_personas / num_personas_min);
//  hacergrupos(num_grupos);
//}

//function hacergrupos(num_grupos)
//{
//  
//  var contador_personas_grupo = new Array();
//  
//  num_personas_grupo = Math.floor(num_personas / num_grupos);
//
//  //Creamos num_grupos todavía sin personas
//  var grupos = new Array();
//  for(g=0;g<$scope.num_grupos;g++)
//  {
//    grupos.push(new Array());
//    contador_personas_grupo[g] = 0;
//  }
//  
//  //Metemos los matrimonios en los grupos que salgan al azar.
//  for(m=0;m<matrimonios.length;m++)
//  {
//    var num_grupo = parseInt(Math.random() * num_grupos);
//    grupos[num_grupo].push(matrimonios[m]);
//    contador_personas_grupo[num_grupo] += 2;
//  }
//  
//  //Vamos rellenando los grupos con hermanos solteros al azar
//  var copia_solteros = solteros.slice();
//  var copia_bajan_poco = bajan_poco.slice();
//  var barajados = false;
//  for(g=0;g<num_grupos;g++)
//  {
//    for(p=contador_personas_grupo[g];p<num_personas_grupo;p++)
//    {
//      s = parseInt(Math.random() * copia_solteros.length);
//      grupos[g].push(copia_solteros[s]);
//      copia_solteros.splice(s,1); //Elimina al hermano de la lista
//      contador_personas_grupo[g] += 1;
//      if(copia_solteros.length == 0)
//      {
//        copia_solteros = copia_bajan_poco;
//        for(gaux=0;gaux<num_grupos;gaux++)
//        {
//          grupos[gaux] = shuffle(grupos[gaux]);
//        }
//        barajados = true;
//      }
//    }
//  
//  }
//
//  //Los grupos ya están completos pero a lo mejor quedan hermanos sin grupo 
//  if(copia_solteros.length == 0) 
//  {
//    copia_solteros = copia_bajan_poco;
//    if(!barajados)
//      for(gaux=0;gaux<num_grupos;gaux++)
//        {
//          grupos[gaux] = shuffle(grupos[gaux]);
//        }
//        barajados = true;
//  }
//  
//  while(copia_solteros.length>0)
//  {
//    g = parseInt(Math.random() * num_grupos);
//    if(contador_personas_grupo[g] == num_personas_grupo)
//    {
//      grupos[g].push(copia_solteros[0]);
//      copia_solteros.splice(0,1);
//      contador_personas_grupo[g] += 1;
//      if(copia_solteros.length == 0) 
//      {
//        copia_solteros = copia_bajan_poco;
//        if(!barajados)
//        for(gaux=0;gaux<num_grupos;gaux++)
//          {
//            grupos[gaux] = shuffle(grupos[gaux]);
//          }
//          barajados = true;
//      }
//    }
//  }
//  
//
//  
//  //Dibujar los grupos en la pantalla
//  $("#grupos").empty();
//  for(g=0;g<grupos.length;g++)
//  {
//    id="grupo"+g;
//    var html = '<div id="'+id+'" class="grupo"></div>';
//    $("#grupos").append(html);
//    
//    for(h=0;h<grupos[g].length;h++)
//    {
//      html = '<div>'+grupos[g][h]+'</div>';
//      $("#"+id).append(html);
//    }
//  }
//  
//}


function shuffle(v){
    for(var j, x, i = v.length; i; j = parseInt(Math.random() * i), x = v[--i], v[i] = v[j], v[j] = x);
    return v;
}

