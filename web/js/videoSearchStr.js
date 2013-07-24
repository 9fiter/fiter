function strVideoInfo(video_title,visitas,likes,dislikes,fecha){
    var lista="";
    //lista+='<h3>'+video_title+'</h3>';
    lista+='<span><img class="ico" alt="visitas" src="/img/ojo.png"> '+visitas+' visitas</span>';
    lista+='<span><img class="ico" alt="likes" src="/img/like.png"> '+likes+'</span>';
    lista+='<span><img class="ico" alt="likes" src="/img/dislike.png">'+dislikes+'</span><br/><br/>';
    
    //lista+='<span class="ytdescription">'+
    //        "Proin et massa ipsum. Sed at nibh lectus, non interdum nulla. Duis adipiscing, leo dictum ultrices gravida, metus nibh vulputate orci, vel facilisis sapien augue ac nulla. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Quisque adipiscing fermentum tortor."
    //     +'</span><br/>';
    
    
    
    //lista+='<span>fecha: '+fecha+'</span><br/>';
    return lista;
}
function strLiVideo(video_id,video_title,video_duration,autor2) {
    var lista2= '<li data-id="'+video_id+'" class="ui-state-default normal">';
    lista2+=         '<div class="yta">';
    lista2+=             '<img data-titulo="'+video_title+'" class="ytMasInfo rot270" src="/img/mas.png" title="Más información">';
    lista2+=         '</div>';
    lista2+=         '<div class="imgenlace" onclick="cargar(\''+video_id+'\',this,\''+autor2+'\')">'; 
    lista2+='<table border="0" cellpadding="0" cellspacing="0">';
    lista2+='<tbody>';
    lista2+='<tr>';
    lista2+='<td class="imagenVideo" style="background-image:url(http://img.youtube.com/vi/'+video_id+'/3.jpg);background-repeat: none;" align="right" valign="bottom">';
    lista2+='<span class="video_duration">'+video_duration+'</span></td>';
    lista2+='<td style="vertical-align: top">';
    lista2+='<div class="enlace" onclick="cargar(\''+video_id+'\',this,\''+autor2+'\')">';
    lista2+='<a>'+video_title+'</a><br/>';
    //lista2+='<a>'+autor2+'</a>';
    lista2+='</div>';
    lista2+='</td>';
    lista2+='</tr>';
    lista2+='</tbody>';
    lista2+='</table>';
    lista2+='</div>';
    lista2+='<div style="clear:both;"></div>';
    lista2+='<div class="masInfo">';
    lista2+=            '<div data-titulo="'+video_title+'" class="ytsearch" title="Buscar en Youtube!"  ></div>';
    lista2+=            '<div data-titulo="'+video_title+'" class="ytclip" title="Añadir a favoritos!" ></div>';
    lista2+='</div>';
    lista2+=         '<div style="clear:both;"></div>';
    lista2+=	'</li>';
    return lista2;
}

function strLiLista(video_id,video_title,nVideos,imagen,enlaceLista) {
    var lista2="";
    lista2+='<ul id="sortable1" class="conectada connectedortable ui-helper-reset ui-sortable">';
    lista2+= '<li class="selected vacio" style="display: none;"></li>';
    lista2+= '<li data-id="'+video_id+'" class="ui-state-default normal">';
    lista2+=         '<div class="yta">';
    lista2+=             '<img data-titulo="'+video_title+'" class="ytMasInfo rot270" src="/img/mas.png" title="Más información">';
    //lista2+=             '<a style="imglink" href="http://muchomoi.no-ip.org/link/iframeNew?duid='+usuariophp+'&amp;enlace=http://www.youtube.com/watch?v='+video_id+'" href="/pubs" rel="facebox" title="Compartir vínculos"></a>';
    lista2+=         '</div>';
    lista2+=         '<div class="imgenlace" onclick="getLista(\''+enlaceLista+'\',this,false)">'; 
    lista2+='<table border="0" cellpadding="0" cellspacing="0">';
    lista2+='<tbody>';
    lista2+='<tr>';
    lista2+='<td class="imagenVideo" style="background-image:url('+imagen+');background-repeat: none;" align="right" valign="bottom">';
    lista2+='<span class="video_duration">'+nVideos+'</span></td>';
    lista2+='<td style="vertical-align: top">';
    lista2+='<div class="enlace btnAddTab"  data-tipo="Lista" onclick="getLista('+enlaceLista+',this,false)">';
    lista2+='<a>'+video_title+'</a>';
    lista2+='</div>';
    lista2+='</td>';
    lista2+='</tr>';
    lista2+='</tbody>';
    lista2+='</table>';
    lista2+='</div>';
    lista2+='<div style="clear:both;"></div>';
    lista2+='<div class="masInfo">';
    lista2+=            '<div data-titulo="'+video_title+'" class="ytsearch" title="Buscar en Youtube!"  ></div>';
    lista2+=            '<div data-titulo="'+video_title+'" class="ytclip" title="Añadir a favoritos!" ></div>';
    lista2+='</div>';
    lista2+=         '<div style="clear:both;"></div>';
    lista2+=	'</li>';
    lista2+='</ul>';
    return lista2;
}




    



function strTabBuscar(){
    return  '<div id="tabs-1">'+
                '<div style="display:inline-block;width: 100%;">'+
                    strMenuBuscar()+
                '</div>'+
                '<ul id="sortable1" class="conectada connectedSortable ui-helper-reset">'+
                    '<li class="selected vacio" style="display: none;"></li>'+
                '</ul>'+
            '</div>';
}

function strTabs(options){
    var strTabs = 
    '<div id="tabs">'+
        '<ul>';
            if(options.activeTabs.contains("Buscar"))
                strTabs += '<li><a href="#tabs-1">Buscar</a> <span class="ui-icon ui-icon-close">Remove Tab</span></li>';
            if(options.activeTabs.contains("Mas"))
                strTabs += '<li id="ultimotab"><a href="#tabs-4">Más</a></li>';
    strTabs += 
        '</ul>';
    if(options.activeTabs.contains("Buscar"))
    strTabs += strTabBuscar();


    if(options.activeTabs.contains("Mas"))
    strTabs += 
        '<div id="tabs-4">'+
            '<ul id="sortable3" class="connectedSortable ui-helper-reset">';
                    if(options.addTabs.contains("Buscar"))
                        strTabs += '<li class="btnAddTab" data-tipo="Buscar"  class="ui-state-default">Buscar</li>';

            strTabs += 
            '</ul>'+
        '</div>';
    strTabs += 
    '</div>';
    return strTabs;
}




function strMenuBuscar() {
            var str='<div class="listasesionmenu" style="min-height: 60px;">'+
                '<div style="float:left;">'+
                    '<select class="tipo">'+
                        '<option value="videos">videos</option>'+
                        '<option value="listas">listas</option>'+
                        '<option value="canales">canales</option>'+
                    '</select>'+
                '</div>'+
                '<div style="float:left;">'+
                    '<select class="fecha">'+
                        '<option value="all_time">fecha</option>'+
                        '<option value="today">Hoy</option>'+
                        '<option value="this_week">Esta semana</option>'+
                        '<option value="this_month">Este mes</option>'+
                        '<option value="all_">Tiempo</option>'+
                        '<option value="top_rated">Más votados</option>'+
                        '<option value="most_popular">Más popular</option>'+
                        '<option value="most_discussed">Más discutidos</option>'+
                        '<option value="most_responded">Más respondidos</option>'+
                        '<option value="most_viewed">Más vistos</option>'+
                    '</select>'+
                '</div>'+
                '<div style="float:left">'+                          
                    '<select class="orden">'+
                        '<option value="relevance">orden</option>'+
                        '<option value="relevance">Relevancia</option>'+
                        '<option value="published">Publicados</option>'+
                        '<option value="viewCount">Reproducciones</option>'+
                        '<option value="rating">Valoración</option>'+
                        '<option value="relevance_lang_es">Español</option>'+			
                    '</select>'+
                '</div>'+
                '<div style="float:left">'+                       
                    '<select class="duracion">'+
                        '<option value="todos">duracion</option>'+
                        '<option value="short">-4min</option>'+
                        '<option value="medium">4-20min</option>'+
                        '<option value="long">+20min</option>'+
                    '</select>'+
                '</div>'+
                '<div style="float:left"> '+                            
                    '<select class="safeSearch">'+
                        '<option value="none">safeSearch</option>'+
                        '<option value="moderate">moderate</option>'+
                        '<option value="strict">strict</option>'+
                    '</select>'+
                '</div>'+
                '<div style="float:left">'+
                    '<select class="genre">'+
                        '<option value="todos">genero</option>'+
                        '<option value="1">Action/Adventure</option>'+
                        '<option value="2">Animation/Cartoons</option>'+
                        '<option value="3">Classic TV</option>'+
                        '<option value="4">Comedy</option>'+
                        '<option value="5">Drama</option>'+
                        '<option value="6">Home/Garden</option>'+
                        '<option value="7">News</option>'+
                        '<option value="8">Reality/GameShows</option>'+
                        '<option value="9">Science/Tech</option>'+
                        '<option value="10">Science-fiction</option>'+
                        '<option value="11">Soaps</option>'+
                        '<option value="13">Sports</option>'+
                        '<option value="14">Travel</option>'+
                        '<option value="16">Entertaiment</option>'+
                        '<option value="17">Documentary</option>'+
                        '<option value="20">Nature</option>'+
                        '<option value="21">Beauty/Fashion</option>'+
                        '<option value="23">Food</option>'+
                        '<option value="24">Gaming</option>'+
                        '<option value="25">Health/Fitness</option>'+
                        '<option value="26">Learning/Education</option>'+
                        '<option value="27">Foreign Language</option>'+
                    '</select>'+
                    '<div style="float:left">'+
                    '<select class="license">'+
                        '<option value="todos">licencia</option>'+
                        '<option value="cc">cc</option>'+
                        '<option value="youtube">youtube</option>'+
                    '</select>'+
                    '</div>'+
                    '<div style="float:left">'+
                        '<input type="checkbox" class="3D" value="true">3D'+
                    '</div>'+
                    '<div style="float:left">'+
                        '<input type="checkbox" class="HD" value="true">HD'+
                    '</div>'+
                '</div>'+
                
                '<div style="float:left">'+
                    '<select class="region">'+
                        '<option value="todos">Region</option>'+
                        '<option value="ES">España</option>'+
                        '<option value="GB">United Kingdom</option>'+
                        '<option value="US">United States</option>'+
                    '</select>'+
                '</div>'+
                
                '<div style="clear:both"> </div>'+
                '<div class="divytsi"><input type="text" class="search_input" value=""/></div>'+
            '</div>'+
            '<ul id="sortable1" class="conectada connectedSortable ui-helper-reset">'+
                '<li class="selected vacio" style="display: none;"></li>'+
            '</ul>';
            return str;
        }