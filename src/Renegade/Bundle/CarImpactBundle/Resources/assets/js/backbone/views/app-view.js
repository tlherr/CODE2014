/*global Backbone,console */
var app = app || {};

(function () {
    'use strict';

    app.AppView = Backbone.View.extend({
        el: '#vehicle-app',
        events: {
            'focus #make-entry': 'doSomethingWhenFocused'
        },
        initialize: function () {
            console.log("Looks good, boss");
        },
        doSomethingWhenFocused: function () {
            console.log("Focused!");
        }
    });
})();