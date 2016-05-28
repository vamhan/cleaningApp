<script type="text/javascript">
	
	$(document).ready(function(){

		$('.api-console-submit').on('click',function(){
			var targetAPI = $(this).parent();	
			
			if( targetAPI.hasClass('api-console') ){


				var methodName = targetAPI.attr('api-method');
				var apiName = targetAPI.attr('api-name');
				var result = targetAPI.find('.api-result');

				switch(methodName){
					case "get_commonList" : 
							var keyword = targetAPI.find('.api-keyword').val();
							var page = targetAPI.find('.api-page').val();
							var targetAPIURL = '<?php  echo site_url()?>__proto_mobile_api/'+methodName+'/method/'+apiName+'/page/'+page;
								if(keyword!=undefined && keyword != '' && keyword.length >0){
									targetAPIURL+= '/keyword/'+keyword;
								}
								// result
								// console.log(targetAPIURL);
							
							$.ajax({ type: "GET", url: targetAPIURL, data: {}, dataType: "json",
							  beforeSend:function(){
							  	console.log(targetAPI.find('.api-request'));
							  	targetAPI.find('.api-request').hide('fast');
				              },
				              success: function(data){
				              	result.html('<pre>'+JSON.stringify(data,null, '    ')+'</pre>');// console.log(data);// console.log('on success');
				              },
				              error:function(err){ // console.log('on error');
				              },
				              complete:function(){

				              	targetAPI.find('.api-request').html('<b> [Call to] </b>'+'<a href="'+targetAPIURL+'" target="_blank">'+targetAPIURL).show('fast');
				              }
				        	})//end ajax function

						break;
					
					case "get_commonDetail" : 
							var objectId = targetAPI.find('.api-object-id').val();
							var targetAPIURL = '<?php  echo site_url()?>__proto_mobile_api/'+methodName+'/method/'+apiName+'/id/'+objectId;
								if(keyword!=undefined && keyword != '' && keyword.length >0){
									targetAPIURL+= '/keyword/'+keyword;
								}
								// result
								console.log(targetAPIURL);

							$.ajax({ type: "GET", url: targetAPIURL, data: {}, dataType: "json",
				              success: function(data){
				              	result.html('<pre>'+JSON.stringify(data,null, '    ')+'</pre>');// console.log(data);// console.log('on success');
				              },
				              error:function(err){ // console.log('on error');
				              },
				              complete:function(){
				              	targetAPI.find('.api-request').html('<b> [Call to] </b>'+'<a href="'+targetAPIURL+'" target="_blank">'+targetAPIURL).show('fast');
				              }
				        	})//end ajax function

						break;

					case "set_commonInsert" : 

							var targetAPIURL = '<?php  echo site_url()?>__proto_mobile_api/'+methodName+'/method/'+apiName+'/';
							var param = targetAPI.find('.api-object-field');
							var paramString = '';
							if(param.length > 0){
								$.each(param,function(){
									var key = $(this).attr('object-name');
									var value = $(this).val();
									if(value == '')value='0';
									// paramString += (paramString =='')?'?':'&';
									paramString += (paramString =='')?'':'/';
									paramString += key+'/'+encodeURIComponent(value);
								})
								paramString+='/on_debug_console/1';
							}

							if(paramString != ''){
								targetAPIURL+= paramString;	
							}

							// var where = targetAPI.find('.api-object-where');
							// var whereString = where.attr('object-name')+'='+where.val();

							// if(paramString != ''){
							// 	targetAPIURL+= whereString;	
							// }
							$.ajax({ type: "GET", url: targetAPIURL, data: {}, dataType: "json",
				              success: function(data){
				              	result.html('<pre>'+JSON.stringify(data,null, '    ')+'</pre>');// console.log(data);// console.log('on success');
				              },
				              error:function(err){ // console.log('on error');
				              },
				              complete:function(){
				              	targetAPI.find('.api-request').html('<b> [Call to] </b>'+'<a href="'+targetAPIURL+'" target="_blank">'+targetAPIURL).show('fast');
				              }
				        	})//end ajax function	

							
						break;

					case "set_commonUpdate" : 

							var targetAPIURL = '<?php  echo site_url()?>__proto_mobile_api/'+methodName+'/method/'+apiName+'/';
							var param = targetAPI.find('.api-object-field');
							var paramString = '';
							if(param.length > 0){
								$.each(param,function(){
									var key = $(this).attr('object-name');
									var value = $(this).val();
									if(value == '')value='0';
									// paramString += (paramString =='')?'?':'&';
									paramString += (paramString =='')?'':'/';
									paramString += key+'/'+encodeURIComponent(value);
								})
								paramString+='/on_debug_console/1';
							}

							if(paramString != ''){
								targetAPIURL+= paramString+'/';	
							}

							var where = targetAPI.find('.api-object-where');
							var whereString = where.attr('object-name')+'/'+where.val();

							if(paramString != ''){
								targetAPIURL+= whereString+'/';	
							}
							// console.log(targetAPIURL);
							
							$.ajax({ type: "GET", url: targetAPIURL, data: {}, dataType: "json",
				              success: function(data){
				              	result.html('<pre>'+JSON.stringify(data,null, '    ')+'</pre>');// console.log(data);// console.log('on success');
				              },
				              error:function(err){ // console.log('on error');
				              },
				              complete:function(){
				              	targetAPI.find('.api-request').html('<b> [Call to] </b>'+'<a href="'+targetAPIURL+'" target="_blank">'+targetAPIURL).show('fast');
				              }
				        	})//end ajax function	

						break;
						
					case "set_commonDelete" : 

							var targetAPIURL = '<?php  echo site_url()?>__proto_mobile_api/'+methodName+'/method/'+apiName+'/';
							
							var where = targetAPI.find('.api-object-where');
							var whereString = where.attr('object-name')+'/'+where.val();

							if(paramString != ''){
								targetAPIURL+= whereString+'/';	
							}
							// console.log(targetAPIURL);
							
							$.ajax({ type: "GET", url: targetAPIURL, data: {}, dataType: "json",
				              success: function(data){
				              	result.html('<pre>'+JSON.stringify(data,null, '    ')+'</pre>');// console.log(data);// console.log('on success');
				              },
				              error:function(err){ // console.log('on error');
				              },
				              complete:function(){
				              	targetAPI.find('.api-request').html('<b> [Call to] </b>'+'<a href="'+targetAPIURL+'" target="_blank">'+targetAPIURL).show('fast');
				              }
				        	})//end ajax function	

						break;

				}

				
				

			}else{
				// console.log('targetAPI not found');
			}

		})

		
		
	})

</script>