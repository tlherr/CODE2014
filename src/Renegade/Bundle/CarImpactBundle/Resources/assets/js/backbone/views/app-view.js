/*global Backbone,console */
var app = app || {};

(function (undefined) {
    'use strict';

    app.AppView = Backbone.View.extend({
        el: '#vehicle-app',
        events: {
            'blur #make-entry': 'loadModels'
        },
        initialize: function () {
            this.$list = this.$('#vehicle-list');
            this.$makeEntry = this.$('#make-entry');
            this.$modelEntry = this.$('#model-entry');

            $("#make-entry").select2();

            this.listenTo(app.vehicles, 'add', this.addVehicle);
            this.loadMakes();
            this.render();
        },
        render: function () {},
        addVehicle: function (vehicle) {
            var vehicleView = new app.VehicleView({ model: vehicle });
            this.$list.append(vehicleView.render().el);
        },
        loadMakes: function() {
            app.makes.fetch({
                success: function(makes) {
                    $.each(makes.models , function(index, value) {
                        ($('<option>', { value: value.attributes.id }).text(value.attributes.label)).appendTo('#make-entry');
                    });
                }
            });
        },
        loadModels: function() {
            //Take the current value of the Makes form element
            console.log((this.$makeEntry).val());
        }
    });
})();