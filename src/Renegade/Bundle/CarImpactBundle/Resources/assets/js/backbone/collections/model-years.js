/*global Backbone,console,window */
var app = app || {};

(function () {
    var ModelYears = Backbone.Collection.extend({
        model: app.ModelYear,
        url: function() {
            return window.carImpactSettings.apiPath + 'models/' + this.modelId + '/years';
        },
        modelId: null,
        fetchModelYears: function(modelId, fetchConfig) {
            this.modelId = modelId;
            this.reset();
            this.fetch(fetchConfig);
            return this;
        }
    });

    app.modelYears = new ModelYears();
})();