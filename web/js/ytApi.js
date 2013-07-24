function getVideos(p_videoIdArray) {
    var modulo = addTabVacia("Otros");                
    for (var x in p_videoIdArray) {
        getVideo(p_videoIdArray[x],modulo );
    }
    setTimeout(function(){
        var anterior = $("div#tabs-1 .connectedSortable").find("li.selected");
        var siguiente = anterior.next();
        anterior.removeClass("selected");
        siguiente.addClass("selected");    
    },500);
}
function getVideo(p_videoId,modulo) {
    var yt_url='http://gdata.youtube.com/feeds/api/videos/'+p_videoId+"?alt=json"; 
    $.ajax({
        type: "GET",
        url: yt_url,
        async:false,
        dataType:"jsonp",
        success: function(response){
            if(response.entry){
                var video_id=p_videoId;
                var video_title=response.entry.title.$t;
                var video_duration=secondsToHms(response.entry.media$group.yt$duration.seconds);

                var autor2 =response.entry.author[0].uri.$t.replace('http://gdata.youtube.com/feeds/api/users/','');
                    
                var lista = strLiVideo(video_id,video_title,video_duration,autor2);
                $(modulo).find($('ul.connectedSortable')).append(lista);
            }
        }
    });
}
function getListas(p_listaIdArray,modulo) {
    for (var x in p_listaIdArray) getLista("http://gdata.youtube.com/feeds/api/playlists/"+p_listaIdArray[x],$("div#tabs-1"), true);
    
    setTimeout(function(){
        var anterior = $("div#tabs-1 .connectedSortable").find("li.selected");
        var siguiente = anterior.next();
        anterior.removeClass("selected");
        siguiente.addClass("selected");    
    },500);
}
function getLista(enlace,elemento,cargar){
    var yt_url=enlace+'?v2&alt=json&orderby=published';
    var modulo;
    $.ajax({
        type: "GET",
        url: yt_url,
        dataType:"jsonp",
        success: function(response){
            if(response){
                modulo = addTabVacia(response.feed.media$group.media$title.$t);
                $.each(response.feed.entry, function(i,data){
                    var video_id="";
                    for (var i=0;i<data.link.length;i++){ 
                        if(data.link[i].rel.indexOf("related")>-1){
                            video_id=data.link[i].href.replace('http://gdata.youtube.com/feeds/api/videos/','');
                        }
                    }
                    var video_title=data.title.$t;
                    
                    var video_duration="0";
                    
                    if(data.media$group!= null) 
                        if(data.media$group.yt$duration!= undefined) 
                            if(data.media$group.yt$duration.seconds!= undefined) 
                                video_duration=secondsToHms(data.media$group.yt$duration.seconds);
                    
                    var autor2 =data.author[0].uri.$t.replace('http://gdata.youtube.com/feeds/api/users/','');
                    
                    var lista = strLiVideo(video_id,video_title,video_duration,autor2);
                    $("#my-widget1").find($(modulo+' ul.connectedSortable')).append(lista);
                });
            }
        },
        complete: function(){
            if(cargar){
                setTimeout(function(){
                      $("#my-widget1").find($(modulo+' ul.connectedSortable li:first')).next().find('div.enlace').trigger('click');
                      //$('#youtube-player-container').tubeplayer('stop');
                },1000);
            }
        }
    });    
}
function getCanal(p_canalId) {
    var yt_url='http://gdata.youtube.com/feeds/api/users/'+p_canalId+"?v=2&alt=json"; 
    $.ajax({
        type: "GET",
        url: yt_url,
        dataType:"jsonp",
        success: function(response){
            if(response.entry){
                var canal_id=response.entry.yt$channelId.$t;
                var autor=response.entry.author[0].name.$t;
                //var contenido=response.entry.content.$t;
                var imagen=response.entry.media$thumbnail.url;
                
                var feedSubscriptions = response.entry.gd$feedLink[0].href;
                var feedContacts = response.entry.gd$feedLink[1].href;
                var feedInbox = response.entry.gd$feedLink[2].href;
                var feedPlaylists = response.entry.gd$feedLink[3].href;
                var feedUploads = response.entry.gd$feedLink[4].href;
                var feedNewSubscriptionVideos = response.entry.gd$feedLink[5].href;
                
                var viewCount= response.entry.yt$statistics.viewCount;
                var totalUploadViews= response.entry.yt$statistics.totalUploadViews;
                var subscriberCount= response.entry.yt$statistics.subscriberCount;
                
                var CanalInfo=
                //'<div class="youtubeCanalInfo">'+
                '<div class="canal">'+
                        '<a target="_blank" href="http://www.youtube.com/channel/'+canal_id+'"><img class="youtubeCanal" src="'+imagen+'" /></a>'+
                        '<span><a target="_blank" href="http://www.youtube.com/channel/'+canal_id+'">'+autor+'</a></span><br/>'+
                        
                        //'<a href="http://www.youtube.com/user/'+autor+'?sub_confirmation=1"><div class="ytbutton"></div></a>'+
                        
                        
                        '<a class="yt-uix-button-subscribe-branded" target="_blank" href="http://www.youtube.com/user/'+canal_id+'">'+
                            '<span class="yt-uix-button-icon-wrapper">'+
                                '<img class="yt-uix-button-icon-subscribe-branded" src="pixel-vfl3z5WfW.gif" alt="" title="">'+
                            '</span>'+
                            '<span class="yt-uix-button-content">'+
                                '<span class="subscribe-hh-label">Suscribirse</span>'+
                            '</span>'+
                        '</a>'+
                        '<div class="yt-subscription-button-subscriber-count-branded-horizontal">'+subscriberCount+'</div><br/>'+
                        
                        
                        //'<span><strong>Suscriptores:</strong> '+subscriberCount+'</span><br/>'+
                        '<span><strong>Visitas al canal:</strong> '+viewCount+'</span><br/>'+
                        //'<span><strong>Visitas en videos:</strong> '+totalUploadViews+'</span><br/>'+
                        '<span><a href="#" data-id="'+autor+'" class="verListas">Ver listas</a></span>'+
                        '<span><a href="#" data-id="'+autor+'" class="verUploads">Ver videos subidos</a></span>'+
                        
                '</div>'+        
                '<div style="float:left;">'+
                        
                '</div>'+
                '<div class="yotubeVideoInfo" style="float:left;">'+
                        
                '</div>'+
                '<div class="limpia"></div>'+
                        /*
                        '<iframe src="http://www.youtube.com/subscribe_widget?p=LaTuerka" '+
                            'style="overflow: hidden; height: 150px; width: 300px; ; border: 0;" '+
                            'scrolling="no" frameBorder="0">'+
                        '</iframe>'+
                        */
                        
                        

                        
                        '<div style="clear:both;"></div>';
                //'</div>'
                
        
                //var modulo1 = addTabListasCanal(canal_id+"-Listas", canal_id, "listayt");
                //var modulo = addTabVacia(canal_id+"-Videos");
                
                $(".youtubeCanalInfo").html(CanalInfo);
                //$(modulo+' .connectedSortable').append(CanalInfo);
                //getListasCanal(canal_id,modulo);
                //getUploads(canal_id,modulo);
                
                
            }
        }
    })
}

function getVideoInfo(p_videoId,mostrarCanal) {
    var yt_url='http://gdata.youtube.com/feeds/api/videos/'+p_videoId+"?v=2&alt=json"; 
    $.ajax({
        type: "GET",
        url: yt_url,
        async:false,
        dataType:"jsonp",
        success: function(response){
            if(response.entry){
                var video_id=p_videoId;
                var video_title=response.entry.title.$t;
                var video_duration=secondsToHms(response.entry.media$group.yt$duration.seconds);

                var autor2 =response.entry.author[0].uri.$t.replace('http://gdata.youtube.com/feeds/api/users/','');
                
                var visitas=response.entry.yt$statistics.viewCount;
                var likes=response.entry.yt$rating.numLikes;
                var dislikes = response.entry.yt$rating.numDislikes;
                var fecha = response.entry.published.$t;
                
                $('.youtubeVideoTitle').html('<h3><a href="http://muchomoi.no-ip.org/watch?v='+p_videoId+'">'+video_title+'</a></h3>');
                
                var lista = strVideoInfo(video_title,visitas,likes,dislikes,fecha);
                $('.youtubeVideoInfo').html(lista);
                
                if(mostrarCanal) getCanal(autor2); 
                
                
                
                
                
            }
        }
    });
}

function getListasCanal(p_canalId,modulo) {
    var yt_url='http://gdata.youtube.com/feeds/api/users/'+p_canalId+'/playlists?alt=json'; 
    $.ajax({
        type: "GET",
        url: yt_url,
        dataType:"jsonp",
        success: function(response){
            if(response.feed){
                $.each(response.feed.entry, function(i,data){
                    var video_id=p_canalId;
                    var video_title=data.title.$t;
                    var nVideos=data.gd$feedLink[0].countHint;
                    var imagen = "";
                    if(nVideos>0) imagen = data.media$group.media$thumbnail[0].url;
                    
                    var enlaceLista=data.gd$feedLink[0].href;
                    
                    var lista = strLiLista(video_id,video_title,nVideos,imagen,enlaceLista);
                    if(nVideos>0) //$(modulo).find($('ul.connectedSortable')).append(lista);
                                    $(modulo).append(lista);
                });
            }
        }
    });
}
function getUploads(usuario,modulo){
    var yt_url='http://gdata.youtube.com/feeds/api/users/'+usuario+'/uploads?alt=json'; 
    $.ajax({
        async:false,   
                      cache:false, 
        type: "GET",
        url: yt_url,
        dataType:"jsonp",
        success: function(response){
            if(response){
                //var modulo = addTabVacia("Subidos");
                $.each(response.feed.entry, function(i,data){
                    var autor = data.author[0].name.$t;
                    var autor2 =data.author[0].uri.$t.replace('http://gdata.youtube.com/feeds/api/users/','');
                    var video_id=data.link[data.link.length-1].href.replace('http://gdata.youtube.com/feeds/api/users/'+autor2+'/uploads/','');
                    var video_title=data.title.$t;
                    var video_duration=secondsToHms(data.media$group.yt$duration.seconds);

                    var lista = strLiVideo(video_id,video_title,video_duration,autor2);
                    $("#my-widget1").find($(modulo+' ul.connectedSortable')).append(lista);
                });
            }
        },
        complete: function(){
          setTimeout(function(){
                //$("#my-widget1").find($(modulo+' ul.connectedSortable li:first')).next().find('div.enlace').trigger('click');
                //$('#youtube-player-container').tubeplayer('stop');
          },1000);
        }
    });    
}
function buscar(cadena,modulo){
    var input = $(modulo).find($(".search_input"));
    if (cadena!=input.val()){  input.val(cadena); }
	
    var keyword= encodeURIComponent(cadena);
    var aaDuracion=$(modulo).find(".duracion").val();
    var bbDuracion=""; if(aaDuracion!="todos") bbDuracion='&duration='+aaDuracion;

    var aaRegion=$(modulo).find(".region").val();
    var bbRegion=""; if(aaRegion!="todos") bbRegion='&region='+aaRegion;

    var bbSafeSearch='&safeSearch='+$(modulo).find(".safeSearch").val();

    var aaLicense=$(modulo).find(".license").val()
    var bbLicense=""; if(aaLicense!="todos") bbRegion='&license='+aaLicense;

    var bb3D=""; if($(modulo).find(".3D").is(":checked")) bb3D='&3d=true';

    var aaGenre=$(modulo).find(".genre").val();
    var bbGenre=""; if(aaGenre!="todos") bbGenre='&genre='+aaGenre;
    var bbHD=""; if($(modulo).find(".HD").is(":checked")) bbHD='&hd=true';

    var yt_url='http://gdata.youtube.com/feeds/api/videos?q='+keyword+'&format=5&max-results=20&v=2&alt=jsonc&time='+$(modulo).find(".fecha").val()+'&orderby='+$(modulo).find(".orden").val()+bbDuracion+bbRegion+bbSafeSearch+bbLicense+bb3D+bbGenre+bbHD; 
    $.ajax({
        type: "GET",
        url: yt_url,
        dataType:"jsonp",
        success: function(response){
            $(modulo).find($('ul.connectedSortable')).empty();
            $(modulo).find($('ul.connectedSortable')).append('<li class="selected" style="display:none;"></li>');
            if(response.data.items){
                $.each(response.data.items, function(i,data){
                    var video_id=data.id;
                    var video_title=data.title;
                    var video_duration=secondsToHms(data.duration);

                    var autor2 =data.uploader;
                    
                    var lista = strLiVideo(video_id,video_title,video_duration,autor2);
                    $(modulo).find($('ul.connectedSortable')).append(lista);
                });
            }
        }
    });
}