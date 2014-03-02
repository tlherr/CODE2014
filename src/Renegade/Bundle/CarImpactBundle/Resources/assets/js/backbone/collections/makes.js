/*global Backbone,console,window */
var app = app || {};

(function () {
    var Makes = Backbone.Collection.extend({
        model: app.Make,
        url: window.carImpactSettings.apiPath + 'makes'
    });

    app.makes = new Makes();
})();