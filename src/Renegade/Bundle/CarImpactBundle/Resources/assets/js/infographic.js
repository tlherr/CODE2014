$(document).ready(function() {
    var controller = $.superscrollorama();
    controller.addTween('#f1', TweenMax.from( $('#f1'), .5, {css:{opacity: 0}}));
    controller.addTween('#f2', TweenMax.from( $('#f2'), .5, {css:{opacity: 0}}));
    controller.addTween('#f3', TweenMax.from( $('#f3'), .5, {css:{opacity: 0}}));
    controller.addTween('#f4', TweenMax.from( $('#f4'), .5, {css:{opacity: 0}}));
    controller.addTween('#f5', TweenMax.from( $('#f5'), .5, {css:{opacity: 0}}));
    controller.addTween('#f6', TweenMax.from( $('#f6'), .5, {css:{opacity: 0}}));
    controller.addTween('#f7', TweenMax.from( $('#f7'), .5, {css:{opacity: 0}}));
    controller.addTween('#f8', TweenMax.from( $('#f8'), .5, {css:{opacity: 0}}));

});