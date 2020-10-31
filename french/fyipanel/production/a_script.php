<script> 
var full=0; 
  var elem = document.documentElement;
  function f(){ 
    if (full==0) {
   if (elem.requestFullscreen) {
    elem.requestFullscreen();
  } else if (elem.mozRequestFullScreen) { /* Firefox */
    elem.mozRequestFullScreen();
  } else if (elem.webkitRequestFullscreen) { /* Chrome, Safari & Opera */
    elem.webkitRequestFullscreen();
  } else if (elem.msRequestFullscreen) { /* IE/Edge */
    elem.msRequestFullscreen();
  }
   full=1;
   document.getElementById("closefull").innerHTML="Close Full Screen";
    document.getElementById('ShowHide').innerHTML = ' <span class="glyphicon glyphicon-resize-small " aria-hidden="true"></span>';
}else{
   if (document.exitFullscreen) {
    document.exitFullscreen();
  } else if (document.mozCancelFullScreen) {
    document.mozCancelFullScreen();
  } else if (document.webkitExitFullscreen) {
    document.webkitExitFullscreen();
  } else if (document.msExitFullscreen) {
    document.msExitFullscreen();
  }
 full=0;
   document.getElementById("closefull").innerHTML="Full Screen";
    document.getElementById('ShowHide').innerHTML = ' <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>';
}
  }

</script>