/* Author: Nick Jones

*/
$(document).ready(function() {
	var win = $(window);
	var doc = $(document);
	var initialized = false;

	var WIN_H;
	var WIN_W;
	var events = {
		init: function(){
			win.bind('resize', pageResize);
			win.bind('keydown',keyHandler);
			win.bind('mousewheel', function(eventData,deltaY) {

			});
			win.bind('scroll',function(e){
				
			});
			win.bind('click',function(e){
				
			});
      $(".trigger").click(function(){
        $(".panel").toggle("fast");
        $(this).toggleClass("active");
        return false;
      });
			function pageResize (e) {
				WIN_H = win.height();
				WIN_W = win.width();
			}
			
			function keyHandler (argument) {
				// if(argument.keyCode==38 || argument.keyCode==37){
				// 	prev();
				// }else if(argument.keyCode==40 || argument.keyCode==39){
				// 	next();
				// }else{
				// 	return;
				// }
			}
		}
	};
	events.init();
});























