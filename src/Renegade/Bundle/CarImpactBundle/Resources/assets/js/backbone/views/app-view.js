/*global Backbone,console */
var app = app || {};

(function ($, undefined) {
    'use strict';

    app.AppView = Backbone.View.extend({
        el: '#vehicle-app',
        events: {
            'change #make-entry': 'makeChanged',
            'change #model-entry': 'modelChanged',
        },
        initialize: function () {
            this.$list = this.$('#vehicle-list');
            this.$makeEntry = this.$('#make-entry');
            this.$modelEntry = this.$('#model-entry').prop('disabled', true);
            this.$yearEntry = this.$('#year-entry').prop('disabled', true);

            this.$makeEntry.select2();
            this.$modelEntry.select2();

            this.listenTo(app.vehicles, 'add', this.addVehicle);
            this.listenTo(app.models, 'reset', this.modelsReset);
            this.listenTo(app.models, 'add', this.modelAdded);

            this.loadMakes();
            this.render();
        },
        render: function () {},
        addVehicle: function (vehicle) {
            var vehicleView = new app.VehicleView({ model: vehicle });
            this.$list.append(vehicleView.render().el);
        },
        loadMakes: function() {
            var that = this;
            app.makes.fetch({
                success: function(makes) {
                    $.each(makes.models , function(index, value) {
                        ($('<option>', { value: value.attributes.id }).text(value.attributes.label)).appendTo(that.$makeEntry);
                    });
                }
            });
        },
        makeChanged: function(e) {
            if (e.val === "-1") {
                this.modelsReset();
            } else {
                this.loadModels(e.val);
            }
        },
        modelChanged: function(e) {
            this.$yearEntry.prop('disabled', false);
            this.$yearEntry.find('option:selected').prop('selected', false);
        },
        loadModels: function(makeId) {
            var that = this;
            app.models.fetchMake(makeId, {
                success: function () {
                    that.$modelEntry.prop('disabled', false);
                }
            });
        },
        modelAdded: function(object) {
            ($('<option>', { value: object.get('id') }).addClass('model-option').text(object.get('label'))).appendTo(this.$modelEntry);
        },
        modelsReset: function() {
            this.$modelEntry.find($('option.model-option')).remove();
            this.$modelEntry.select2().prop('disabled', true);
        }
    });
})(jQuery);