(function () {
    'use strict';
    
    angular.module('app.cuestionarios')
    .controller('InputCtrl',['$scope','$http','$uibModal','logger',InputCtrl])
    .controller('InputModal',['$scope','$http','$uibModalInstance','preguntas','pregunta',InputModal]);
    
    function InputModal($scope,$http,$uibModalInstance,preguntas,pregunta){
        var opcion       = {respuesta:'',valor:''},
            index        = pregunta?preguntas.indexOf(pregunta):false,
            tmp_opciones = [];
            
        $scope.form = pregunta?pregunta:{opciones:[{respuesta:'',valor:''}]};
        
        
        if(pregunta.opciones == false)
        {
            pregunta.opciones.push({respuesta:'',valor:''});
        }
        
        
        $scope.save = function()
        {
            //$scope.form.opciones = $scope.opciones;
            console.log($scope.form.opciones);
            if(pregunta == false)
                preguntas.push($scope.form);
            else
            {
                //console.log(index);
                /*if(index > -1)
                {
                    preguntas[index] =  $scope.form;
                }*/
            }
            console.log(preguntas);
            $uibModalInstance.close();
        }
        $scope.remove_opciones = function(index)
        {
            tmp_opciones.push($scope.form.opciones[index]);
            $scope.form.opciones.splice(index,1);
        }
        $scope.add_opciones = function()
        {
            
            $scope.form.opciones.push({respuesta:'',valor:''});
            
            //console.log($scope.opciones);
        }
        
        $scope.cancel = function() {
                //En caso de cancelacion se carga nuevamente los datos a las opciones
                $.each(tmp_opciones,function(index,data){
                    
                    $scope.form.opciones.push(data);
                });
                $uibModalInstance.close();
        }
    }
    function InputCtrl($scope,$http,$uibModal,logger)
    {
        $scope.preguntas = preguntas?preguntas:[];
        $scope.prepend_edit = function(pregunta)
        {
            var modalInstance = $uibModal.open({
                            animation: true,
                            templateUrl: 'ModalPrepend.html',
                            controller: 'InputModal',
                            //size: size,
                            resolve: {
                                pregunta:function()
                                {
                                    return pregunta;
                                },
                                preguntas:function()
                                {
                                    return $scope.preguntas;
                                }
                                /*equipos_left: function () {
                                    return $scope.equipos_left;
                                },
                                equipos_right: function () {
                                    return $scope.equipos_right;
                                },
                               
                                equipo:function()
                                {
                                    return equipo;
                                }*/
                                
                            }
            });
        }
        $scope.prepend_add = function()
        {
            var modalInstance = $uibModal.open({
                            animation: true,
                            templateUrl: 'ModalPrepend.html',
                            controller: 'InputModal',
                            //size: size,
                            resolve: {
                                preguntas:function()
                                {
                                    return $scope.preguntas;
                                },
                                pregunta:function()
                                {
                                    return false;
                                },
                                /*equipos_left: function () {
                                    return $scope.equipos_left;
                                },
                                equipos_right: function () {
                                    return $scope.equipos_right;
                                },
                               
                                equipo:function()
                                {
                                    return equipo;
                                }*/
                                
                            }
            });
        }
        
        $scope.remove = function(index)
        {
            
            $scope.preguntas.splice(index,1);
            
        }
        $scope.options = {
            dropped: function(scope) {
                //console.log(scope.source.nodeScope.$modelValue);
                /*var category_id = scope.source.nodeScope.$modelValue.category_id,                   
                    list        = $scope.categories[scope.source.nodeScope.$modelValue.category_id].list,
                    form_data   = {},
                    order       = []7*/;
                var order = [];
                angular.forEach($scope.preguntas,function(item,index){
                    
                         
                    
                    if(item.id === false)
                    {
                        alert('Se recomienda guardar todo el cuestionario, existe una pregunta que no ha sido guardada');
                        return false;
                    }
                    
                    order[index]= item.id;//set_node(index,item);
                    
                    
                    
                    
                });
                var form_data={
                  //data  :{group:group_id},
                  //order : order
                  
                     
                     order:order
                 };
                
                
                
                $http.post(SITE_URL+'admin/cuestionarios/order',form_data).then(function(response){
                    
                    var result  = response.data,
                        status  = result.status,
                        message = result.message;
                    
                    if(status)
                    {
                         logger.logSuccess(message);
                    }
                    else
                    {
                         logger.logError(message);
                    }
                    
                });
            }
         }
    }
})();