/**
http://nyromodal.nyrodev.com/
	this gives us thickbox functionality where we can influence the setting of each modal through the url.
	the author of nyroModal does not make this default functionality because he does not want to alter the url for this purpose.
	BUT this show how flexible nyrolmodal is because it can be edited to do so quite easily
	author: will caine
**/
$(function() {
	if(jQuery.fn){
		jQuery.fn.nyroModal.settings.processHandler = function(settings) {
			var tar_url = null;
			var surl = settings.url;
			var stype = settings.type;
			
			if(surl){
				tar_url=surl;
			}else{
				//url can be null if an type==iframe, so derive the url some other way
				if(settings.from && settings.from.tagName=='A'){
					tar_url=settings.from.href;
				}
			}
			
			if (tar_url) {
				var args = new Array();
				var usplit=tar_url.split("?");
				//this is used to relocate the bookmark to the end of the url, if i have to rewrite it
				var bkmark_inx=tar_url.indexOf("#");
				if(usplit.length>1){
					usplit = usplit[1].split("&");
					for(x=0; x<usplit.length; x++){
						arrsplit=usplit[x].split("=");
						if(arrsplit[1]){
							args[arrsplit[0].toUpperCase()]=arrsplit[1];
							args[x]=arrsplit[1];
						}
					}
				}
				if(args['NYRO_NO_CACHE']){
					//make sure the url is unique everytime
					myd=new Date()
					
					//make sure there is an '&' before adding this
					if(tar_url.charAt(tar_url.length-1)!='&'){
						tar_url+="&";
					}
					if( bkmark_inx == -1 ){
						bkmark_inx = surl.length;
					}
					tar_url = tar_url.substring(0,bkmark_inx) + "r="+myd.getTime() + tar_url.substring(bkmark_inx);
				}
				if(args['NYRO_HEIGHT']){
					settings.height = parseInt(args['NYRO_HEIGHT']);
					settings.minHeight = settings.height;
				}
				if(args['NYRO_WIDTH']){
					settings.width = parseInt(args['NYRO_WIDTH']);
					settings.minWidth = settings.width;
				}
				if(args['NYRO_MODAL']){
					settings.modal = true;
				}
				if(args['NYRO_TYPE']){
					settings.type = unescape(args['NYRO_TYPE']);
				}
				if(args['NYRO_TITLE']){
					settings.title = unescape(args['NYRO_TITLE']);
				}
				if(args['NYRO_BGCOLOR']){
					settings.bgColor = unescape(args['NYRO_BGCOLOR']);
				}
				

				if(surl){
					surl=tar_url;
				}
				jQuery.nyroModalSettings({
					url: surl
					,width: settings.width
					,minWidth: settings.minWidth
					,height: settings.height
					,minHeight: settings.minHeight
					,modal: settings.modal
					,type: settings.type
					,title: settings.title
					,bgColor: settings.bgColor
				});
			}
		};
	}else{
		alert("nyroModal url plugin:could not find: $.fn: " + $.fn );
	}
});