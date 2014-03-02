/*global Backbone,console */
var app = app || {};

(function () {
    var Vehicles = Backbone.Collection.extend({
       model: app.Vehicle
    });

    app.vehicles = new Vehicles();
})();