import $ from 'jquery'
import { TweenMax } from 'gsap'
import ScrollToPlugin from "gsap/ScrollToPlugin"
export default {
  init: function(){
    $(function(){
      var $window = $(window);
      var scrollTime = 1;
      var scrollDistance = 50;

      $window.on("mousewheel DOMMouseScroll", function (event) {

        event.preventDefault();

        var delta = event.originalEvent.wheelDelta / 40 || -event.originalEvent.detail / 0.5;
        var scrollTop = $window.scrollTop();
        var finalScroll = scrollTop - parseInt(delta * scrollDistance);

        TweenMax.to($window, scrollTime, {
          scrollTo: { y: finalScroll, autoKill: true },
          ease: Power2.easeOut,
          overwrite: 10
        });
        console.log(finalScroll);
      });
    })
  }
}
