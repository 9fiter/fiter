$(document).ready(function() {
    $("#menuCategorias").html("<nav>"+$("aside.asideLeft nav").html()+"</nav>");
    $('#footerMasVistos').after($('#listaMasValorados').parent().next().clone());
    $('#footerMasValorados').after($('#listaMasValorados').parent().next().clone());
    $("#btn_menu").click(function(e) { 
        if($("#menuCategorias").css("display")=="none") 
             $("#menuCategorias").show(100);
        else $("#menuCategorias").hide(100);
        return false;  
    });
    $("#btn_usuario").click(function(e) { 
        if($("#menuUsuario").css("display")=="none") 
             $("#menuUsuario").show(100);
        else $("#menuUsuario").hide(100);
        return false;  
    });
});
$(window).resize(function() {
    if ($(window).width()>767) 
        if($("#menuCategorias").css("display")!="none") 
            $("#menuCategorias").hide(100);
});
function addTagForm(collectionHolder, newLinkLi) {
    // Get the data-prototype explained earlier
    var prototype = collectionHolder.data('prototype');
    
    // get the new index
    var index = collectionHolder.data('index');
    // Replace '$$name$$' in the prototype's HTML to
    // instead be a number based on how many items we have
    //var newForm = prototype.replace(/\$\$name\$\$/g, index);
    //console.log(prototype);
    var newForm = prototype.replace(/__name__/g, index+'_enlace');
    console.log(newForm);
    // increase the index with one for the next item
    collectionHolder.data('index', index + 1);
    // Display the form in the page in an li, before the "Add a tag" link li
    var newFormLi = $('<li></li>').append(newForm);
    newLinkLi.before(newFormLi);
    var li = $(collectionHolder.find('li')[collectionHolder.find('li').length-2]);
    addTagFormDeleteLink2($(li[0]));
}
function addTagFormDeleteLink2($tagFormLi) {
    var $removeFormA = $('<a class="remove_tag_link" href="#"><img src="/img/delete.png"/></a>');
    $tagFormLi.find('div div').append($removeFormA);
    $removeFormA.on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();
        // remove the li for the tag form
        $tagFormLi.remove();
    });
}
function addTagFormDeleteLink($tagFormLi) {
    var $removeFormA = $('<a class="remove_tag_link" href="#"><img src="/img/delete.png"/></a>');
    $tagFormLi.find('div').append($removeFormA);
    $removeFormA.on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();
        // remove the li for the tag form
        $tagFormLi.remove();
    });
}
// Get the ul that holds the collection of tags
var collectionHolder = $('ul.videosYoutube');
// setup an "add a tag" link
var $addTagLink = $('<a href="#" class="add_tag_link">Añadir más</a>');
var $newLinkLi = $('<li></li>').append($addTagLink);

$(document).ready(function() {
    // add a delete link to all of the existing tag form li elements
    collectionHolder.find('li').each(function() {
        addTagFormDeleteLink($(this));
    });
    // add the "add a tag" anchor and li to the tags ul
    collectionHolder.append($newLinkLi);
    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    collectionHolder.data('index', collectionHolder.find(':input').length);
    $addTagLink.on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // add a new tag form (see next code block)
        addTagForm(collectionHolder, $newLinkLi);
    });
});
// Get the ul that holds the collection of tags
var collectionHolder2 = $('ul.listasYoutube');
// setup an "add a tag" link
var $addTagLink2 = $('<a href="#" class="add_tag_link">Añadir más</a>');
var $newLinkLi2 = $('<li></li>').append($addTagLink2);
$(document).ready(function() {
    // add a delete link to all of the existing tag form li elements
    collectionHolder2.find('li').each(function() {
        addTagFormDeleteLink($(this));
    });
    // add the "add a tag" anchor and li to the tags ul
    collectionHolder2.append($newLinkLi2); 
    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    collectionHolder2.data('index', collectionHolder2.find(':input').length);
    $addTagLink2.on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // add a new tag form (see next code block)
        addTagForm(collectionHolder2, $newLinkLi2);
    });
});
// Get the ul that holds the collection of tags
var collectionHolder3 = $('ul.maps');
// setup an "add a tag" link
var $addTagLink3 = $('<a href="#" class="add_tag_link">Añadir más</a>');
var $newLinkLi3 = $('<li></li>').append($addTagLink3);
$(document).ready(function() {
    // add a delete link to all of the existing tag form li elements
    collectionHolder3.find('li').each(function() {
        addTagFormDeleteLink($(this));
    });
    // add the "add a tag" anchor and li to the tags ul
    collectionHolder3.append($newLinkLi3); 
    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    collectionHolder3.data('index', collectionHolder3.find(':input').length);
    $addTagLink3.on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // add a new tag form (see next code block)
        addTagForm(collectionHolder3, $newLinkLi3);
    });
});

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#blah').attr('src', e.target.result);
            $('#blah').css('display','inline-block');
        }
        reader.readAsDataURL(input.files[0]);
    }
}










function grafico(data,id){
  var suma =0;
  $.each( data, function( key, value ) { suma+=value[1]; });
  $.each( data, function( key, value ) {
    var poll = document.getElementById(id);
    poll.setAttribute('class', 'poll');
    var title = document.createElement('div');
    var text = document.createTextNode(data[key][0]);
    title.appendChild(text);
    var vote = document.createElement('div');
    vote.setAttribute('class', 'vote');

    var percent;
    if(suma>0) percent = ((value[1]*100)/suma).toFixed(2)+'%';
    else percent = "0%";
    vote.innerHTML = data[key][2]+" "+data[key][1]+" - "+percent;
    title.appendChild(vote);
    poll.appendChild(title);
    var box = document.createElement('div');
    box.setAttribute('class', 'box');
    var answer = document.createElement('div');
    answer.setAttribute('class', 'answer');
    answer.style.width= percent;
    box.appendChild(answer);
    poll.appendChild(box);
  });    
}