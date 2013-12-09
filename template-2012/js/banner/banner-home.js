$(document).ready(function(){
// ad
	$tabs = $("#tab > ul")
	.tabs({ fx: { opacity: 'toggle',  duration: 'fast' } })	
	.tabs("rotate", 5000)
	.parent()
	.mouseover(function (){jQuery(this).find("> ul").tabs("rotate", null)})
	.mouseout(function (){jQuery(this).find("> ul").tabs("rotate", 8000)});

});