(function($){
                      /*_____________Modulo manejo de ScrollBar_____________*/  
		var scrollBar = (function(){
      var crear = function(config){ //el objeto config contiene el div de los pies y una areferencia al modulo
        config.piesCont.mCustomScrollbar({
          horizontalScroll:true,
          scrollButtons : {
          	enable:true,
          },
          callbacks:{
            onScroll: function(){
              var npies = config.modulo.pies();//obtiene el arreglo de pies              
              if(npies){
                for (var i = 0; i < npies.length; i++) {
                    npies[i].canvas.getPos(true);
                };
              }
            },
            onTotalScroll:function(){
              var npies = config.modulo.pies();
              if(npies){
                for (var i = 0; i < npies.length; i++) {
                  npies[i].canvas.getPos(true);
                };
              }
            }
          }
        });    
      }
      return {
        crear: crear
      }
    })();// fin del modulo ScrollBar

                      /*_____________Modulo Autocompletar_____________*/ 
    var autoCompletar = (function(){
      var terminos = new Array();
      var getTerminos = function(urlTerminos){
        return $.ajax({
            url:urlTerminos,
            dataType:'json'
        });
      };      
      var construirAutoCompletar = function(urlTerminos){
        getTerminos(urlTerminos).done(function(data){         
          terminos =  $.map(data, function(element,index){            
            return element.termnameutf8;
          });
          $('input.inputField').autocomplete({
            source:terminos,
            minLength:2
          });
        });
      }        
      return {
        construirAutoCompletar:construirAutoCompletar
      }       
    })();//fin del modulo autocompletar

                      /*_____________Modulo Creacion Pies_____________*/ 
    var piesModulo = (function(){//Modulos crear pies
      var piesMarco = $('div.pie'),
      modulo,
      template = Handlebars.compile($('script#template').html()),// variable para tener la plantilla
      pies = new Array(),
      getPies = function(){return pies;},
      setvisModulo = function(nuevoModulo){modulo = nuevoModulo},
      cargarDatos = function(config){ //debe cargar todos los pies en esta parte
        pies =[]; //se resetean los pies
        var criterion = getMetadataCriterion(piesMarco); // obtiene los criterios para buscar los metadatos      
        loadingProgress(piesMarco);  
        if(config.buscador){// si se hace la busqueda desde el formulario, se busca el nodo con nombre correspondiente
          //al centrar el nodo se vuelve a llamar el metodo para que cargue los pies.
          var termino = config.buscador.find('input[type="text"]').val();
          var idActual = modulo.actual().graph.getByName(termino).id;
          modulo.actual().onClick(idActual);
          return;
        }       
        criterion.forEach(function(el, i, arr){
            if(config.searchObj){// si se llamo el metodo con un objeto de busqueda
              config.searchObj.criterio = el
            }          
            $.ajax({
              url: config.urlBusqueda,
              data: config.searchObj,
              type: 'post',
              dataType:'json'     
            }).done(function(data){   
              if (config.searchObj){ // si se realiza carga de datos desde otra parte del js
                if(data.mensaje){
                 config.dialogo.empty().text(data.mensaje).dialog("open");
                 return;
                }
                pies.push(crearPie(data.pie.Column,data.pie.PieData, data.pie.Data));                         
              }                 
          });
        });   
      },
      loadingProgress = function(contenedores){
        contenedores.empty().siblings('div.pieContent').children('div').remove();
        $('<div></div>',{
            class:'loadingIcon',            
        }).appendTo(contenedores);
      },
      crearPie = function(div,json,results){
        var Json = json;
        $('#'+div).empty();
        var Pie = new $jit.PieChart({
          injectInto: div,
          animate:true,         
          hoveredColor: '#CCCCCC',
          showLabels:false,
          resizeLabels:false,
          updateHeights:false,
          Tips:{
              enable: true,
              type:'HTML',
                onShow: function(tip, node) {                                    
                  $(tip).html('<span class="etiqueta">' + node.label + '</span>: '+node.value).css('opacity',1);              
                }   
            },
            Events:{
              enable:true,
              onClick: function(node, eventInfo, e){

                var actualId = modulo.actual().root;
                var currentNode = modulo.actual().graph.getNode(actualId);
                if(currentNode.data.title === "is Concept"){
                  resourceModule.loadResource(node,modulo.actual().root,'term_id',0);

                }else if(currentNode.data.title === "is Category"){
                   resourceModule.loadResource(node,modulo.actual().root,'ParentKey',0);
                }
              }
            }
        });
        Pie.loadJSON(Json);
        var sb = Pie.sb;    
        var convenciones = $.map(results,function(n){         
          var node = sb.graph.getByName(n.column);
          return {
            nombreCampo: n.column,//n[div],
            cantidadRecursos:n.numresources,//n['Numero'],
            color:node.getData('colorArray')[0]
          }
        });
        $('html, body').animate({scrollTop:150},300,'easeOutQuart');
        datosConvenciones = {convenciones:convenciones,
                              criterio:div}
        setConventions(datosConvenciones); 
        return Pie;
      },
      setConventions = function(datos){ // compila la plantilla handlebars y muestra las convenciones de los pies
        var contenedor = $('div#'+datos.criterio).siblings('div.pieContent');
        contenedor.children('div').remove();
          
        //var template = Handlebars.compile(plantilla),
        contenido = template(datos);
        contenedor.append(contenido);
        setTimeout(function(){contenedor.children('div').addClass('visible');},500);//time out para que se active la transición css
      },
      getMetadataCriterion = function(piesCont){//funcion para obtener los criterios de busqueda de metadatos
        var criterion = piesCont.map(function(index, dom){
          return dom.id;
        });
        return criterion.get();
      } 
      return {
        cargarDatos: cargarDatos,
        pies: getPies,
        crearPie:crearPie,
        iniciar:setvisModulo
      };
    })();//fin del modulo pies

                      /*_____________Modulo Manejo Visualizacion de Grafos_____________*/ 
    var visModulo = (function(){
      var panelTitulo = $('div#titulo'),
      current,
      cargarData = function (config){   // inicializa todas las visualizaciones
        current = crearRgraph(dataJson); //data json son los datos del arbol importados de los ejemplos que envio el profe        
        /*es necesario vaciar las otras visualizaciones antes de pintar una nueva
        de otra forma hay conflictos con las id de las etiquetas y no se muestran
        y entonces no hay forma de navegar los arboles*/
        $('li#hyperLink').on('click',function(){
          $('div.vis').empty();
          current = crearHyperTree(dataJson);
        });
        $('li#arbolLink').on('click',function(){
          $('div.vis').empty();
         current = crearRgraph(dataJson);
        });

        $('li#spaceLink').on('click',function(){
          $('div.vis').empty();
         current = crearSpaceTree(dataJson);
        });

      },
      getActual = function(){
        return current
      },
       crearRgraph = function(json){
          var ht = new $jit.RGraph({  
          injectInto: 'arbol',  
          width: 940,  
          height: 480,
          background: {  
            CanvasStyles: {  
              strokeStyle: '#555'  
            }  
          },
          Node: {  
              dim: 10,  
              color: "#004080"  
          },  
          Edge: {  
              lineWidth: 2,  
              color: "#0BC0F4"  
          },
          Navigation: {  
              enable: true,  
              panning: false,  
            
          },

          Tips: {  
            enable: true,  
            type: 'html',  
            // add positioning offsets  
            offsetX: 20,  
            offsetY: 20,  
            // implement the onShow method to  
            // add content to the tooltip when a node  
            // is hovered  
            onShow: function(tip, node){  
              // count children  
              var count = 0;  
              node.eachSubnode(function(){  
                count++;  
              });  
              // add tooltip info  
              $(tip).html("<div class=\"tip-title\"><b>Name:</b> " + node.name  
                  + "</div><div class=\"tip-text\">" + count + " children</div>").css('opacity',1);
               
            }  
          },
          onCreateLabel: function(domElement, node){ 
              domElement.innerHTML = node.name;  
              $jit.util.addEvent(domElement, 'click', function () { 
                  //node.getParents && limpiarArbol(node.getParents()[0]);
                  ht.onClick(node.id, {  
                      onComplete: function() {  
                          ht.controller.onComplete();  
                      }  
                  });  
              });  
          }, 
          onPlaceLabel: function(domElement, node){  
              var style = domElement.style;  
              style.display = '';  
              style.cursor = 'pointer';  
              if (node._depth <= 2) {  
                  style.fontSize = "0.8em";  
                  style.color = "#ddd";  
          
              }  else {  
                  style.display = 'none';  
              }         
              var left = parseInt(style.left);  
              var w = domElement.offsetWidth;  
              style.left = (left - w / 2) + 'px';  
          },
          onBeforeCompute:function(node){
            piesNodoArbol(node);
            panelTitulo.html("<p>"+node.name+"</p>"); // se pone el nombre del nodo en  el panel               
          },
          onAfterCompute:function(node){            
          },
          Events:{
            enable:true,
            onClick:function(){
             //limpiarArbol(node.getParents());  
            }
          }        
        });
        ht.loadJSON(json);
        ht.refresh(); 
        return ht;
      },
      crearHyperTree = function(json){
          var ht = new $jit.Icicle({  
          injectInto: 'hyperArbol',  
          width: 940,  
          height: 480,
          Node: {  
              dim: 10,  
              color: "#004080"  
          },  
          Edge: {  
              lineWidth: 2,  
              color: "#0BC0F4"  
          },
          onCreateLabel: function(domElement, node){             

              domElement.innerHTML = node.name;  
              $jit.util.addEvent(domElement, 'click', function () { 
                  //node.getParents && limpiarArbol(node.getParents()[0]);
                  ht.onClick(node.id, {  
                      onComplete: function() {  
                          ht.controller.onComplete();  
                      }  
                  });  
              });  
          }, 
          onPlaceLabel: function(domElement, node){  
              var style = domElement.style;  
              style.display = '';  
              style.cursor = 'pointer';  
              if (node._depth <= 2) {  
                  style.fontSize = "0.8em";  
                  style.color = "#ddd";  
          
              }  else {  
                  style.display = 'none';  
              }         
              var left = parseInt(style.left);  
              var w = domElement.offsetWidth;  
              style.left = (left - w / 2) + 'px';  
          },
          onBeforeCompute:function(node){ 
            piesNodoArbol(node);
            panelTitulo.html("<p>"+node.name+"</p>"); // se pone el nombre del nodo en  el panel               
          },
          onAfterCompute:function(node){            
          },
          Tips: {  
            enable: true,  
            type: 'Native',  
            // add positioning offsets  
            offsetX: 20,  
            offsetY: 20,  
            // implement the onShow method to  
            // add content to the tooltip when a node  
            // is hovered  
            onShow: function(tip, node){  
              // count children  
              var count = 0;  
              node.eachSubnode(function(){  
                count++;  
              });  
              // add tooltip info  
              tip.innerHTML = "<div class=\"tip-title\"><b>Name:</b> " + node.name  
                  + "</div><div class=\"tip-text\">" + count + " children</div>";  
            }  
          },
          Events:{
            enable:true,
            onMouseEnter: function(node) {  
            //add border and replot node  
            node.setData('border', '#33dddd');  
            ht.fx.plotNode(node, ht.canvas);  
            ht.labels.plotLabel(ht.canvas, node, ht.controller);  
          },
          onMouseLeave: function(node) {  
            node.removeData('border');  
            ht.fx.plot();  
          },  
            onClick:function(node){
             if (node) {  
              //hide tips and selections               
              if(ht.events.hovered)  
                this.onMouseLeave(ht.events.hovered);  
                //perform the enter animation  
              ht.enter(node);  
              }  
            }
          }


        });
        ht.loadJSON(json);
        ht.refresh(); 
        
        return ht;
      },


       crearSpaceTree = function(json){
          var ht = new $jit.ST({  
          injectInto: 'space',  
          width: 940,  
          height: 480,
          duration: 800,  
          //set animation transition type  
          transition: $jit.Trans.Quart.easeInOut,  
          //set distance between node and its children  
          levelDistance: 30,

          orientation:'top',
          offsetY: 80,  
          //enable panning  
          Navigation: {  
            enable:true,  
            panning:true  
          },  
          //set node and edge styles  
          //set overridable=true for styling individual  
          //nodes or edges  
          Node: {  
              height: 70,  
              width: 120,  
              type: 'rectangle',  
              color: '#aaa',  
              overridable: true  
          },
          onCreateLabel: function(domElement, node){
             
              domElement.innerHTML = node.name;  
              $jit.util.addEvent(domElement, 'click', function () { 
                  //node.getParents && limpiarArbol(node.getParents()[0]);
                  ht.onClick(node.id, {  
                      onComplete: function() {  
                          ht.controller.onComplete();  
                          ht.root= node.id;
                      }  
                  });  
              });

              var style = domElement.style;  
                 
          }, 
          onPlaceLabel: function(domElement, node){  
              var style = domElement.style;  
              style.display = '';  
              style.cursor = 'pointer';
              style.width = 120 + 'px';  
              style.height = 70 + 'px';              
              style.cursor = 'pointer';  
              style.color = '#333';  
              style.fontSize = '1em';  
              style.textAlign= 'center';  
              style.paddingTop = '.7em';
              style.color = 'white';  
              
          },
          onBeforeCompute:function(node){ 
            piesNodoArbol(node);
            panelTitulo.html("<p>"+node.name+"</p>"); // se pone el nombre del nodo en  el panel               
          },
          onAfterCompute:function(node){
            
          },
          Events:{
            enable:false
          }        
        });
        ht.loadJSON(json);
        ht.compute();
        ht.onClick(ht.root);    
        return ht;
      },

      piesNodoArbol = function (node){// carga los pies de un concepto o categoría       
      //  ajaxRequest && ajaxRequest.abort();//cancela el pedido ajax de pies si se esta realizando otro.
        if(node.data.title === "is Category"){
          piesModulo.cargarDatos({
            searchObj:{idTerm:node.id,idColumn:"ParentKey",criterio:""},
            urlBusqueda:'resource/getPies'
          });
        }else{
          piesModulo.cargarDatos({
            searchObj:{idTerm:node.id,idColumn:"term_id",criterio:""},
            urlBusqueda:'resource/getPies'
          });
        }        
      }
      return {
        cargarData:cargarData,
        piesNodoArbol: piesNodoArbol,
        actual:getActual
      };
    })();//fin del modulo arbol

                      /*_____________Modulo Arrance_____________*/ 
    var init = function (config){
      config.dialogo.dialog({ //dialogo modal
        autoOpen: false,
        show: "blind",
        hide: "explode",
        modal:true,
        zIndex: 9898
      });
      config.tabs.tabs().addClass( "ui-tabs-vertical ui-helper-clearfix" );
      config.tabs.find('li').removeClass( "ui-corner-top" )
                            .end()
                            .children('ul')
                            .removeClass('ui-corner-all')
                            .removeClass('ui-widget-header'); // preparacion de las tabs de jqery ui
      config.buscador.on('submit', function(e){// configuracion del buscador
        e.preventDefault();
        piesModulo.cargarDatos(config);      
      });
      config.scrollToo.on('click',function(){
        $('html, body').animate({scrollTop:0},300,'easeInBack').promise().done(function(){
          config.buscador.find('input').focus();
        });
      });
      $(window).on('scroll', function(){
        $(window).scrollTop() > 100 ? config.scrollToo.slideDown():config.scrollToo.slideUp();
      });
      config.buscador.find('input[type="text"]').on('focus',function(){
        $(this).val("");
      });
    }

    /*-------------------------------------fin modulos-------------------------------------------*/

// codigo para probar recursos
// var node = {
//     name:'Language',
//     label:'en'
//   };
//   resourceModule.loadResource(node,1000304728);
  
  resourceModule.init({
    plantilla:$('script#resourceTemplate').html(),
    url:"resource/getResource",
  });
  
/****Pensar en como se estan cargando los recursos desde el buscador*******/

    visModulo.cargarData({
      arbolJson:'index.php/buscador/cargarArbol',
      piesJson:'index.php/buscador/pieArbol'
     });
    
    piesModulo.iniciar(visModulo);

    init({
      buscador:$('form#form_buscador'),
      urlBusqueda:'index.php/resource/getPies',
      scrollToo:$('div.searchTag'),
      arbol:$('form#form_arbol'),
      dialogo: $("#dialogo"),
      tabs:$('div#tabs'),      
    });

    autoCompletar.construirAutoCompletar('text/loadTermsSearch');
    scrollBar.crear({
      piesCont:$(".piesContainer"),
      modulo:piesModulo      
    });

  

})(jQuery);