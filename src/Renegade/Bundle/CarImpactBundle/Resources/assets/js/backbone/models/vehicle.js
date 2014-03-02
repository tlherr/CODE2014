/*global Backbone,window */
var app = app || {};

(function () {
    'use strict';

    app.Vehicle = Backbone.Model.extend({
        defaults: {
            id: '',
            year: ''
        },
        urlRoot: window.carImpactSettings.apiPath + 'vehicles'
    });
})();