/*global Backbone,window */
var app = app || {};

(function () {
    'use strict';

    app.Model = Backbone.Model.extend({
        defaults: {
            id: '',
            label: '',
            canonical_label: ''
        }
    });
})();