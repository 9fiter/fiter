Array.prototype.contains = function(k) {
    for(var p in this)
        if(this[p] === k)
            return true;
    return false;
}
function secondsToHms(d) {
    d = Number(d);
    var h = Math.floor(d / 3600);
    var m = Math.floor(d % 3600 / 60);
    var s = Math.floor(d % 3600 % 60);
    return ((h > 0 ? h + ":" : "") + (m > 0 ? (h > 0 && m < 10 ? "0" : "") + m + ":" : "0:") + (s < 10 ? "0" : "") + s);
}

var usuariophp="1";
var enlace="asdasd";


$(function() {
    $.widget( "custom.videoSearch", {
        options: {
            red: 245,
            green: 245,
            blue: 245,
            tabCounter:5,
            canal:"",
            videoInicial: "",
            busquedaInicial:"salvados",
            listaVideos: new Array(),
            listaPlaylists: new Array(),
            activeTabs: ["Buscar","Mas"], // Buscar - Favoritos - Historial - Mas -
            addTabs:["Buscar"], // Buscar - Favoritos - Historial 
            // callbacks
            change: null,
            random: null
        },
        _create: function() {
            this.element.addClass( "custom-videoSearch" ).disableSelection();
            this.tabs = $(strTabs(this.options)).appendTo( this.element );
            this.tabs = this.tabs.tabs();
            this.tabs.find( ".ui-tabs-nav" ).sortable({
                axis: "x",
                stop: function() { this.tabs.tabs( "refresh" ); }
            });     
            this._conectarListas();
            this._eventos();
            
            //lista botones crear pestañas
            this.btnCrear = this.tabs.find(".btnAddTab");
            this._on( this.btnCrear, {
                click: function(event){ 
                    this.addTab(event.toElement.textContent);
                }
            });
            this._refresh();
            
            if(this.options.listaPlaylists.length>0) getListas(this.options.listaPlaylists);
            if(this.options.listaVideos.length>0) getVideos(this.options.listaVideos);
            
            
            
            this.videoInfo = $( "<div>", {
                    class: "youtubeVideoInfo"
            }).prependTo( this.element );
            
            
            this.canalInfo = $( "<div>", {
                    class: "youtubeCanalInfo"
            }).prependTo( this.element );
        
            this.canalTitle = $( "<div>", {
                    class: "youtubeVideoTitle"
            }).prependTo( this.element );
            
            
            this.ytplayer = $( "<div>", {
                    id: "youtube-player-container"
            }).tubeplayer({
                width: "100%",
                allowFullScreen: "true", // true by default, allow user to go full screen
                //initialVideo: "AvvSM4YD2YI", // the video that is loaded into the player
                initialVideo: this.options.videoInicial, // the video that is loaded into the player
                preferredQuality: "default",// preferred quality: default, small, medium, large, hd720,
                theme: "light", // possible options: "dark" or "light"
                modestbranding: false, // specify to include/exclude the YouTube watermark
                showinfo: true,
                onPlay: function(id){}, // after the play method is called
                onPause: function(){}, // after the pause method is called
                onStop: function(){}, // after the player is stopped
                onSeek: function(time){}, // after the video has been seeked to a defined point
                onMute: function(){}, // after the player is muted
                onUnMute: function(){}, // after the player is unmuted
                onPlayerEnded: function(){siguiente();}, // when the player returns a state of ended
                onErrorNotFound: function(){siguiente();}, // if a video cant be found
                onErrorNotEmbeddable: function(){siguienteErr();}, // if a video isnt embeddable
                onErrorInvalidParameter: function(){siguiente();} // if we've got an invalid param
            }).prependTo( this.element );
            //if(this.options.listaVideos.length==0) this.ytplayer.css('display','none');
            
            if(this.options.videoInicial) { 
                getVideoInfo(this.options.videoInicial,true);
                
            }
            if(this.options.canal.length>0) { 
                getCanal(this.options.canal); 
                var modulo = addTabVacia(this.options.canal+"-Videos");
                getUploads(this.options.canal,modulo);
                
            }
            
            
            
        },
        addTab: function(nombre,enlace) {
            var tabTemplate = "<li><a href='#{href}'>#{label}</a> <span class='ui-icon ui-icon-close'>Remove Tab</span></li>";
            var label = nombre || "Tab " + this.options.tabCounter;
            var id = "tabs-" + this.options.tabCounter;
            var li = $( tabTemplate.replace( /#\{href\}/g, "#" + id ).replace( /#\{label\}/g, label ) );
            var contenido='<ul id="sortable'+this.options.tabCounter+'" class="conectada connectedSortable ui-helper-reset"> <li class="selected vacio">'+nombre+'</li></ul>' ;
            var modulo = "#tabs-"+this.options.tabCounter;
            switch(nombre){
                //case "Buscar": contenido = strMenuBuscar(); break;
                //case "Listas": getListasCanal(this.options.canal,modulo);break;
                //case "Lista":  getLista(enlace,modulo); break;    
            }
            contenido = strMenuBuscar();
            var tabContentHtml = contenido || "Tab " + this.options.tabCounter + " content.";
            this.tabs.find( ".ui-tabs-nav li#ultimotab" ).before( li );
            this.tabs.find( "div#tabs-4" ).before( "<div id='" + id + "'>" + tabContentHtml + "</div>" );
            this.tabs.tabs( "refresh" );
            this.tabs.tabs("select", "#tabs-"+this.options.tabCounter);
            this.options.tabCounter++;
            $( ".connectedSortable" ).sortable().disableSelection();
            this._conectarListas();
        },
        addTabListasCanal: function(nombre,tipo,canal_id) {
            var tabTemplate = "<li><a href='#{href}' class='#{class}' data-id='#{data-id}'>#{label}</a> <span class='ui-icon ui-icon-close'>Remove Tab</span></li>";
            var label = nombre || "Tab " + this.options.tabCounter;
            var id = "tabs-" + this.options.tabCounter;
            var li = $( tabTemplate.replace( /#\{href\}/g, "#" + id ).replace( /#\{label\}/g, label ).replace( /#\{class\}/g, tipo ).replace( /#\{data-id\}/g, canal_id ) );
            var contenido='<ul id="sortable'+this.options.tabCounter+'" class="conectada connectedSortable ui-helper-reset"> <li class="selected vacio">'+nombre+'</li></ul>' ;
            var modulo = "#tabs-"+this.options.tabCounter;
            switch(nombre){
                case "Buscar": contenido = strMenuBuscar(); break;
                //case "Listas": getListasCanal(this.options.canal,modulo);break;
                //case "Lista":  getLista(enlace,modulo); break;    
            }
            switch(tipo){
                case "listayt": clase = strMenuBuscar(); break;
                //case "Listas": getListasCanal(this.options.canal,modulo);break;
                //case "Lista":  getLista(enlace,modulo); break;    
            }
            var tabContentHtml = contenido || "Tab " + this.options.tabCounter + " content.";
            this.tabs.find( ".ui-tabs-nav li#ultimotab" ).before( li );
            this.tabs.find( "div#tabs-4" ).before( "<div id='" + id + "'>" + tabContentHtml + "</div>" );
            //this.tabs.tabs( "refresh" );
            this.tabs.tabs("select", "#tabs-"+this.options.tabCounter);
            this.options.tabCounter++;
            $( ".connectedSortable" ).sortable().disableSelection();
            this._conectarListas();
        },
        _conectarListas: function() {
            $( ".connectedSortable" ).sortable().disableSelection();
            var $tabs = this.tabs;
            var $tab_items = $( "ul:first li", $tabs ).droppable({
                tolerance: "pointer",
                accept: ".connectedSortable li",
                hoverClass: "ui-state-hover",
                drop: function( event, ui ) {
                    var $item = $( this );
                    var $list = $( $item.find( "a" ).attr( "href" ) ).find( ".connectedSortable" );
                    ui.draggable.hide( "slow", function() {
                        $tabs.tabs( "select", $tab_items.index( $item ) );
                        $( this ).appendTo( $list ).show( 400 );

                        function borrarEstilo(elemento) { $(elemento).removeAttr("style"); }
                        setTimeout(borrarEstilo, 450, $(this)); //fix overflow

                    });
                    var origen= ui.draggable.parents(".connectedSortable").find("li").size()-1;
                    if(origen==2)   {ui.draggable.parents("ul").find("li.vacio").css("display","list-item");}  //mostrar mensaje vacio
                    var destino=$list.find("li").size()+1;
                    if(destino==2)   $list.find("li.vacio").css("display","none"); //ocultar mensaje vacio
                }
            });
        },
        _eventos: function(e) {
            
            //boton cerrar pestaña
            $( "#tabs span.ui-icon-close" ).live( "click", function(event) {
                var panelId = $( this ).closest( "li" ).remove().attr( "aria-controls" );
                $( "#" + panelId ).remove();
                $(this).parents(".ui-tabs").tabs( "refresh" );
                //tabs.tabs( "refresh" ); 
            });
            //boton mostrar mas informacion    
            $('#tabs').delegate( 'img.ytMasInfo', 'click', function(){
                masInfo(this);
            });
            //boton buscar en youtube
            $('#tabs').delegate( 'div.ytsearch', 'click', function(){
                $("#ytsi.search_input").val($(this).data('titulo'));
                buscar($(this).data("titulo"),$("div#tabs"));
            });
            //input text buscar youtube
            $("#tabs").delegate(".search_input", "keyup", function() {
                buscar($(this).val(),$(this).parents(".ui-tabs-panel"));	
            });
            //on change en el formulario de busqueda
            $("#tabs").delegate(".fecha,.duracion,.region,.orden,.license,.safeSearch,.3D,.HD,.genre", "change", function() {       
                refresca($(this));
            });
            $("#ul.conectada").delegate("li", "click", function() {       
                alert("asd");
            });
        
            this.element.delegate("a.verListas", "click", function(e) {  
                e.preventDefault();
                var id =$(this).data("id");
                var modulo = addTabVacia(id+"-Listas");
                getListasCanal(id,modulo);
            });
            
            this.element.delegate("a.verUploads", "click", function(e) {    
                e.preventDefault();
                var id =$(this).data("id");
                var modulo = addTabVacia(id+"-Videos");
                getUploads(id,modulo);
            });
            
            this.element.delegate("a.listayt", "click", function() {       
                var id =$(this).data("id");
                var modulo = $(this).attr('href');
                $(this).removeClass('listayt').addClass('listaytnoevent');
                getListasCanal(id,modulo);
            });
        
            $(window).resize(function() {
                tamanoyt();
            });
        
            
        
        },
        _refresh: function() {
                this.element.css( "background-color", "rgb(" +
                        this.options.red +"," +
                        this.options.green + "," +
                        this.options.blue + ")"
                );
                this._trigger( "change" );
        },
        random: function( event ) {
                var colors = {
                        red: Math.floor( Math.random() * 256 ),
                        green: Math.floor( Math.random() * 256 ),
                        blue: Math.floor( Math.random() * 256 )
                };
                if ( this._trigger( "random", event, colors ) !== false ) {
                        this.option( colors );
                }
        },
        _destroy: function() {
                this.changer.remove();

                this.element
                        .removeClass( "custom-videoSearch" )
                        .enableSelection()
                        .css( "background-color", "transparent" );
        },
        _setOptions: function() {
                this._superApply( arguments );
                this._refresh();
        },
        _setOption: function( key, value ) {
                // prevent invalid color values
                if ( /red|green|blue/.test(key) && (value < 0 || value > 255) ) {
                        return;
                }
                this._super( key, value );
        },
        getTabCounter: function(  ) {
             return this.options.tabCounter;
        }
    });
});
function addTabVacia(nombre){
    var tabcounter = $("#my-widget1").videoSearch('getTabCounter');
    var modulo = '#tabs-'+tabcounter;
    $("#my-widget1").videoSearch('addTab',nombre);
    $("#my-widget1").find($(modulo+' ul.connectedSortable')).empty();
    $("#my-widget1").find($(modulo+' ul.connectedSortable')).append('<li class="selected" style="display:none;"></li>');
    return modulo;
}


function addTabListasCanal(nombre,canal_id,tipo){
    var tabcounter = $("#my-widget1").videoSearch('getTabCounter');
    var modulo = '#tabs-'+tabcounter;
    $("#my-widget1").videoSearch('addTabListasCanal',nombre, tipo, canal_id);
    $("#my-widget1").find($(modulo+' ul.connectedSortable')).empty();
    $("#my-widget1").find($(modulo+' ul.connectedSortable')).append('<li class="selected" style="display:none;"></li>');
    return modulo;
}

function contains(a, obj) {
    for (var i = 0; i < a.length; i++) {
        if (a[i] === obj) {
            return true;
        }
    }
    return false;
}


var historial=new Array();
function cargar(video_id,elemento,canal_id){
    tamanoyt();
    
    
    video = {
        id:video_id,
        nombre:$(elemento).find('a').text(),
        imagen:$(elemento).parents('li').find('.imagenVideo').css('background-image').replace("url(","").replace(")",""),
        duracion:$(elemento).parents('li').find('.imagenVideo .video_duration').text()
    }
    //JSON.parse()
    //console.log(JSON.stringify(video));
    var historialtemp=new Array();
    //if(!contains(SON.stringify(video),historialtemp)) historialtemp.push(SON.stringify(video));
    if(!contains(video_id,historialtemp)) historialtemp.push(video_id);
        
        
    
    
    $.each(historialtemp, function(i, el){
        if($.inArray(el, historial) === -1) historial.push(el);
    });


    
    if($.cookie('historial')) {
        historialtemp = $.cookie('historial').split(",");
        
        $.each(historialtemp, function(i, el){
            if($.inArray(el, historial) === -1) historial.push(el);
        });
        
        //historial.push(video_id);
        $.cookie('historial', historial, { expires: 365, path: '/' });
    }else{
        //historial.push(historial);
        $.cookie('historial', historial, { expires: 365, path: '/' });
    }
    
    
    
    
    
    $('#youtube-player-container').css('display','block');
    $("#reproductor").css( "visibility" , "visible"  );
    $('#youtube-player-container').tubeplayer('play', video_id);
    
    getVideoInfo(video_id,true);
    
    var anterior = $(".connectedSortable").find("li.selected");
    anterior.removeClass("selected");
    anterior.addClass("played");
    anterior.addClass("normal");
    $(elemento).parent().addClass("selected");
    $(elemento).parent().removeClass("played");
    $(elemento).parent().removeClass("normal");
    setTimeout(function() {  
        var a = (parseInt(($('#reproductor').css('width')))*9)/16;
        $('#reproductor').css('height',a);    
    },1250);
    //cargarRelacionados(video_id);
    //cargarComentarios(video_id);
    //cargarInfo(video_id);
}
function siguiente(){
    var anterior = $(".connectedSortable").find("li.selected");
    var siguiente = anterior.next();
    anterior.addClass("normal");
    anterior.addClass("played");
    anterior.removeClass("selected");
    siguiente.addClass("selected");
    siguiente.removeClass("played");
    siguiente.removeClass("error");
    siguiente.removeClass("normal");
    $('#youtube-player-container').tubeplayer('play', siguiente.data("id"));
    //$('#youtube-player-container').tubeplayer('stop');
    //cargarRelacionados(siguiente.data("id"));
    //cargarComentarios(siguiente.data("id"));
    //cargarInfo(siguiente.data("id"));
}

function siguienteErr(){
    var anterior = $(".connectedSortable").find("li.selected");
    var siguiente = anterior.next();
    anterior.addClass("normal");
    anterior.removeClass("selected");
    anterior.addClass("error");
    setTimeout(function() {
        siguiente.removeClass("error");
        siguiente.removeClass("played");
        siguiente.addClass("selected");
        siguiente.removeClass("normal");
        $('#youtube-player-container').tubeplayer('play', siguiente.data("id"));
    },1500);
}
function tabsOrdenables(){
    var tabs = $( "#tabs" ).tabs();
    tabs.find( ".ui-tabs-nav" ).sortable({
        axis: "x",
        stop: function() { tabs.tabs( "refresh" ); }
    });
}
function masInfo(elemento){
    var divMasInfo=$(elemento).parents("li").find("div.masInfo");
    if(divMasInfo.css("display")=="none"){
        $("div.masInfo").hide("blind", {}, 300);
        divMasInfo.show("blind", {}, 300);
        $("img.ytMasInfo").addClass("rot270");
        $(elemento).parents("li").find("img.ytMasInfo").removeClass("rot270");
    }else  {
        $("div.masInfo").hide("blind", {}, 300);
        divMasInfo.hide("blind", {}, 300);
        $(elemento).parents("li").find("img.ytMasInfo").addClass("rot270");
    }
}
function refresca(entrada){
    /*var tamaño =parseInt($(entrada).find("option:selected").text().length)+1;
    if (tamaño>8) tamaño =8;
    $(entrada).css("width",  tamaño+"em"    );*/
    var modulo = $(entrada).parents(".ui-tabs-panel");
    buscar(modulo.find(".search_input").val(),modulo);
    
}

function tamanoyt(){
    var ancho = $('#youtube-player-container').find('iframe').width();
    var alto = parseInt((ancho*9)/16);
    $('#youtube-player-container').find('iframe').height(alto);
}