/*global Backbone,console,window */
var app = app || {};

(function () {
    var FilteredVehicles = Backbone.Collection.extend({
        model: app.Vehicle,
        modelId: null,
        year: null,
        url: function() {
            return window.carImpactSettings.apiPath + 'vehicles/' + this.modelId + '/years/' + this.year;
        },
        fetchFiltered: function (model, year, fetchConfig) {
            this.modelId = model;
            this.year = year;
            this.reset();
            this.fetch(fetchConfig);
            return this;
        }
    });

    app.filteredVehicles = new FilteredVehicles();
})();