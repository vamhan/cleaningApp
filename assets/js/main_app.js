var appConfig = {
	currentURL:undefined,
	getCurrentURL:function(){
		if(appConfig.currentURL == undefined){
			var HOST = window.location.protocol+'//'+window.location.host;
		    var PATH = (window.location.pathname);
		    	PATH = PATH.substring(0,PATH.lastIndexOf('/'));
		    appConfig.currentURL = HOST+PATH;
		}
		return appConfig.currentURL;
	}
}


// TODO:: remove it later , hacked -> unable to solved onload firing twice
firstInit = false;
$(function(){
	if(!firstInit){
		firstInit = true;
		return;
	}else{
		console.log('init mainApp.js')
		$('a[href="#"]').on('click',function(event){
			event.preventDefault();
		})	
	}
})
