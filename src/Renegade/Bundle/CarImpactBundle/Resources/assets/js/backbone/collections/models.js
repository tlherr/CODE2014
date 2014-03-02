/*global Backbone,console */
var app = app || {};

(function () {
    var Models = Backbone.Collection.extend({
        model: app.Model,
        url: function() {
            return window.carImpactSettings.apiPath + 'makes/' + this.makeId + '/models';
        },
        makeId: null,
        fetchMake: function(id, fetchConfig) {
            this.makeId = id;
            this.reset();
            this.fetch(fetchConfig);
            return this;
        }
    });

    app.models = new Models();
})();