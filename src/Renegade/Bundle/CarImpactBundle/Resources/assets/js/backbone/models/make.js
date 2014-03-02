/*global Backbone,window */
var app = app || {};

(function () {
    'use strict';

    app.Make = Backbone.Model.extend({
        defaults: {
            id: '',
            label: '',
            canonical_label: ''
        },
        urlRoot: window.carImpactSettings.apiPath + 'makes'
    });
})();