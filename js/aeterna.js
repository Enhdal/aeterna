// Load plugin
/*$.ajax({
	type: "GET",
	url: "javascript/jquery.json.min.js",
	dataType: "script"
});

$.ajax({
	type: "GET",
	url: "javascript/ckeditor/ckeditor.js",
	dataType: "script"
});*/



// Function to initialize a page to call each time a page is loaded. 
function  initPage(){
	// Set each ckeditor UI.
	$('.ckeditor').each(function(){
		var $t = $(this);
		var $editor = $t.next('#cke_content');
		if(typeof $editor == 'undefined'){
			var name = $t.attr('name');
			CKEDITOR.replace(name);
		}
	});
}


function panelOverlay() {
	if ($('#rightPanel').length == 0)
		$('body').find('#mainContent').after('<aside id="rightPanel" class="contextPanel"></aside>');
	
	var $rp = $('#rightPanel');
	var $op = $('#openPanel');
	if($rp.attr('x-open') == 1){
		$rp.css('transition', '1s left,1s width,0.1s opacity');
		$rp.css('opacity', '0');
		$rp.css('width', '0px');
		$rp.attr('x-open', '0');
		$op.removeClass('glyphicon-chevron-right');
		$op.addClass('glyphicon-chevron-left');
	} else {
		var rp_height = $rp.height();
		var m_height = $('#mainContent').height();
		
		$rp.css('transition', '1s left,0.1s width,1s opacity');
		if(m_height > rp_height){
			$rp.css('height', $('#mainContent').height());
		}
		$rp.css('opacity', '1');
		$rp.css('width', '250px');
		$rp.attr('x-open', '1');
		$op.removeClass('glyphicon-chevron-left');
		$op.addClass('glyphicon-chevron-right');
	}
	/*$rp.fadeToggle(
		{
		duration : '500',
		easing : 'swing'
		}
	);*/
}

function closeOverlay() {
	var $rp = $('#rightPanel');
	/*.animate({
		right : '-=300',
		opacity : 0
	}, 400, function() {
		$('#rightPanel').fadeOut(300);
		$(this).css('display','none');
	});
	.fadeToggle(
		{
		duration : '500',
		easing : 'swing'
		});*/
	$rp.css('opacity', '0');
	return false;
}

// Check if email is right.
function mailValidate(email){
    var reg = new RegExp('^[a-z0-9]+([_|\.|-]{1}[a-z0-9]+)*@[a-z0-9]+([_|\.|-]{1}[a-z0-9]+)*[\.]{1}[a-z]{2,6}$', 'i');
 
    if(reg.test(email)){
		return true;
    }else{
		return false;
    }
}

// Initialize binds for signup page.
function init_signup(){
	$('#signup').click(function(){
		var $t = $(this);
		var form = $t.closest('form#signup_form');
		var data = form.getFormData();
		//data = $.toJSON(data);
		$.ajax({
			url : 'todo_ajax.php',
			type : 'POST',
			data : 'todo=signup&data='+data,
			success : function(result){
				window.location = 'index.php';
			}
		});
	});
}

// Connect user.
function connect_user(form){
	var data = form.getFormData();
	//data = $.toJSON(data);
	// Check to sign in.
	$.ajax({
		url : 'todo_ajax.php',
		type : 'POST',
		data : 'todo=user_connect&data='+data,
		success : function(result){
			// Reload login page to display access to user account administration.
			/*$.ajax({
				url : 'login.php',
				success : function(html){
					form.replaceWith($(html));
				}
			})*/
			location.reload();
		}
	});
}

function destroy_session(){
	$.ajax({
		url : 'kill_session.php',
		success : function(html){
			location.reload();
		}
	})
}

function update_menu(){
	
	return false;
}

$.fn.extend({
	// Load a page.
	updatePage: function(){
		var $t = $(this);
		var page_name = $t.attr('x-page');
		var page = page_name+'.php';
		
		$loc = $('#mainContent');
		$.ajax({
			url : page,
			success: function(result){
				$loc.html($(result));
				// If a function init_<page_name>() exists, launch it.
				if(typeof window['init_'+page_name] == 'function'){
					window['init_'+page_name]();
				}
			},
			// On error, load page 404.
			error : function(message){
				$.ajax({
					url : '404.html',
					success: function(result){
						$loc.html($(result));
					}
				})
			}
		})
		return false;
	},
	/*
	$t.find('input, select').bind("keyup", function(e) {
		if(e.keyCode == 13 && $(this)[0].nodeName == "INPUT") {
			e.stopImmediatePropagation();
			$t.closest('div.listTableFilter').listTableFilterAdd();
		} else if(e.ctrlKey && e.keyCode == 13) {
			e.stopImmediatePropagation();
			$t.closest('div.listTableFilter').listTableFilterAdd();
		} else if(e.keyCode == 27) { // Esc = Close filter's UI
			e.stopImmediatePropagation();
			$t.closest('div.listTableFilter').prev().prev().listTableInit_filterColClose();
		}
	});
	*/
	
	// Get back data from element in a form.
	getFormData : function(){
		var $t = $(this);
		$data = new Object();
		$t.find('input, select').each(function(){
			// Input element.
			var $t2 = $(this);
			var name = $t2.attr('name');
			var tmp = '';
			if($t2[0].nodeName == "INPUT") {
				tmp = $t2.val();
			} else if($t2[0].nodeName == "SELECT") {
				tmp = $t2.find('option:selected').val();
			}
			$data[name] = tmp; 
		});
		$t.find('textarea').each(function(){
			// Input element.
			var $t2 = $(this);
			var $editor = $t2.next('#cke_content');
			var name = $t2.attr('name');
			var tmp = '';
			if(typeof $editor == 'undefined'){
				tmp = $t2.html();
			}else{
				tmp = CKEDITOR.instances[name].getData();
			}
			$data[name] = tmp; 
		});
		$data = $.toJSON($data);
		$data = escape($data);
		$data= $data.replace("+", "%2B");
		$data= $data.replace("/", "%2F");
		return $data;
	},
	
	// Function on chapter's form to add or update it.
	setChapter : function(id_chapter){
		var $t = $(this);
		var data = $t.getFormData();
		var todo = '';
		
		if(id_chapter > 0)
			// If id_chapter is set and greater than 0,
			// book exists and has to be updated.
			todo = 'update_chapter';
		else
			// If id_chapter equals 0, it's a new book to add to db.
			todo = 'add_chapter';

		$.ajax({
			url : 'todo_ajax.php',
			type : 'POST',
			data : 'todo='+todo+'&data='+data,
			success : function(result){
				window.location = 'index.php';
			}
		});
		return false;
	},
	
	// Function on book's form to add or update it.
	setBook : function(id_book){
		var $t = $(this);
		var data = $t.getFormData();
		var todo = '';
		//data = $.toJSON(data);
		if(id_book > 0)
			// If id_book is set and greater than 0,
			// book exists and has to be updated.
			todo = 'update_book';
		else
			// If id_book equals 0, it's a new book to add to db.
			todo = 'add_book';

		$.ajax({
			url : 'todo_ajax.php',
			type : 'POST',
			data : 'todo='+todo+'&data='+data,
			success : function(result){
				window.location = 'index.php';
			}
		});
	},
	
	// Function on article's form to add or update it.
	setArticle : function(id_article){
		var $t = $(this);
		var data = $t.getFormData();
		var todo = '';
		if(id_article > 0)
			// If id_article is set and greater than 0,
			// article already exists and has to be updated.
			todo = 'update_article';
		else
			// If id_article equals 0, it's a new book to add to db.
			todo = 'add_article';

		$.ajax({
			url : 'todo_ajax.php',
			type : 'POST',
			data : 'todo='+todo+'&data='+data,
			success : function(result){
				window.location = 'index.php';
			}
		});
	}
});




$(document).ready(function(){
	// Initializing function.
	initPage();
	
	$('#connection').click(function(){
		var $t = $(this);
		var form = $t.closest('form#user_connect');
		connect_user(form);
	});
	
	$('#closePanel').click(function(e){
		panelOverlay();
		e.preventDefault();
	});
	
	$('.menu_choice').each(function(){
		$(this).click(function(){
			$(this).updatePage();
		});
	});

	// Usage
	$('#openPanel').click(function(e) {
		panelOverlay();
		e.preventDefault();
	});
	
});
