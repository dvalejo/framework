(function () {

    var mainMenuItems = document.querySelectorAll('.main-menu__item');

    function mainMenuItem_MouseOverHandler(event) {
        var submenu = event.target;

    }

    for(var i = 0, len = mainMenuItems.length; i < len; i++) {
        mainMenuItems[i].addEventListener('mouseover', mainMenuItem_MouseOverHandler, false);
    }

})();