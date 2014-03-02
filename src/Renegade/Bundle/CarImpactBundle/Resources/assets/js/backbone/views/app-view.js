/*global Backbone,console */
var app = app || {};

(function (undefined) {
    'use strict';

    app.AppView = Backbone.View.extend({
        el: '#vehicle-app',
        events: {
            'blur #make-entry': 'doSomethingWhenFocused'
        },
        initialize: function () {
            this.$list = this.$('#vehicle-list');
            this.$makeEntry = this.$('#make-entry');

            this.listenTo(app.vehicles, 'add', this.addVehicle);

            this.render();
        },
        render: function () {

        },
        doSomethingWhenFocused: function () {
            var that,
                vID,
                newVehicle;

            that = this;

            vID = this.$makeEntry.val();
            if (undefined !== vID && '' !== vID) {
                that.$makeEntry.val('');
                // Don't bother retrieving the vehicle if we have it
                if (undefined === app.vehicles.get(vID)) {
                    newVehicle = new app.Vehicle({id: vID});
                    newVehicle.fetch({
                        success: function (obj) {
                            app.vehicles.add(obj);
                        }
                    });
                }
            }
        },
        addVehicle: function (vehicle) {
            var vehicleView = new app.VehicleView({ model: vehicle });
            this.$list.append(vehicleView.render().el);
        }
    });
})();