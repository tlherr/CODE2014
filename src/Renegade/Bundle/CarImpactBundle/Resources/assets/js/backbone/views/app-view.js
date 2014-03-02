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
            this.$modelEntry = this.$('#model-entry');

            app.makesBloodhound = new Bloodhound({
                datumTokenizer: function(d) { return Bloodhound.tokenizers.whitespace(d.canonical_label); },
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                prefetch: {
                    url: window.carImpactSettings.apiPath + 'makes'
                },
                limit: 10
            });

            app.modelsBloodhound = new Bloodhound({
                datumTokenizer: function(d) { return Bloodhound.tokenizers.whitespace(d.label); },
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                remote:  {
                    url: 'http://code2014.mark.renegade.local/app_dev.php/api/v1/models',
                    ajax: {
                        data: {
                            make: 748
                        }
                    }
                }
            });

            app.makesBloodhound.initialize();
            app.modelsBloodhound.initialize();

            this.$makeEntry.typeahead(null, {
                displayKey: 'label',
                source: app.makesBloodhound.ttAdapter()
            }).on('typeahead:selected', this.makeSelected);

            this.$modelEntry.typeahead(null, {
                displayKey: 'label',
                valueKey: 'id',
                source: app.modelsBloodhound.ttAdapter()
            });

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
        },
        makeSelected: function(e, object) {
            app.modelsBloodhound.remote.ajax.data.make = object.id;
        }
    });
})();