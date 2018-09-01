function contentsettings(){
	$bw=$('body').width();
	$hh=$('header').height();
	$nh=$('nav').height();
	$nw=$('nav').width();
	if ($bw>1050){
		$('.content').css('top',($hh+$hh/2));
		$('.content').css('margin-top',0);
		if ($('nav').css('display')!='none') $('.content').animate({'left':'18%'},50);
		else $('.content').animate({'left':'3%'},200);		
	}	
	else if ($bw>500){		
		if ($('nav').css('display')!='none'){
				$('.content').animate({'margin-top':(($hh+$nh)+10)},50);				
			}
		else {$('.content').animate({'margin-top':(($hh)+10)},50);	}
	}
	else $('.content').animate({'margin-top':(($hh)+10)},50);
}

$(window).resize(function(){contentsettings();});

$(document).ready(function(){
	if ($('body').width()<501){$('nav').hide();}
	contentsettings();
	$('#menu').click(
		function(){
		$('nav').slideToggle("200","linear", function(){contentsettings()});
			
		}
	);	
});



