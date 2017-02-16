
// -----------------------------------------------------------
var HTML = (function () {

    return {
        create: function (options) {
            var e,
                name,
                attributes,
                classes,
                key;

            if (typeof options !== 'object') {
                return false;
            }

            name = options['element'];
            attributes = options['attributes'];
            classes = options['class'];

            e = document.createElement(name);
            for (key in attributes) {
                if (attributes.hasOwnProperty(key)) {
                    e.setAttribute(key, options['attributes'][key]);
                }
            }
            e.className = classes;
            return e;
        }
    }

})();