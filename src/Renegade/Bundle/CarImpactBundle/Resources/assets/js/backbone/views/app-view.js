/*global Backbone,console */
var app = app || {};

(function ($, undefined) {
    'use strict';

    app.AppView = Backbone.View.extend({
        el: '#vehicle-app',
        events: {
            'change #make-entry': 'makeChanged',
            'change #model-entry': 'modelChanged',
            'change #year-entry': 'yearChanged'
        },
        currentMake: null,
        currentModel: null,
        currentYear: null,
        initialize: function () {
            this.$list = this.$('#vehicle-list');
            this.$makeEntry = this.$('#make-entry');
            this.$modelEntry = this.$('#model-entry');
            this.$yearEntry = this.$('#year-entry').prop('disabled', true);
            this.$vehicleSelectList = this.$('#vehicle-select-list');

            this.$makeEntry.select2();
            this.$modelEntry.select2();

            this.$modelEntry.prop('disabled', true);

            this.listenTo(app.vehicles, 'add', this.addVehicle);
            this.listenTo(app.models, 'reset', this.modelsReset);
            this.listenTo(app.models, 'add', this.modelAdded);
            this.listenTo(app.filteredVehicles, 'reset', this.filteredVehiclesReset);

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
        loadFilteredVehicles: function () {
            var that = this,
                successCallback = function () {
                    app.filteredVehicles.forEach(function(obj) {
                        var vehicleView = new app.VehicleSelectView({model: obj});
                        that.$vehicleSelectList.append(vehicleView.render().el);
                    });
                };
            this.clearVehicleSelect();

            console.log(this.currentModel, this.currentYear);
            if (this.currentModel && this.currentYear) {
                app.filteredVehicles.fetchFiltered(this.currentModel, this.currentYear, {
                    success: successCallback
                });
            }
        },
        filteredVehiclesReset: function () {
            console.log("Clear out");
        },
        clearVehicleSelect: function () {
            this.$vehicleSelectList.find('li').remove();
        },
        makeChanged: function(e) {
            if (e.val === "0") {
                this.modelsReset();
            } else {
                this.loadModels(e.val);
            }
        },
        modelChanged: function(e) {
            this.$yearEntry.prop('disabled', false);
            this.$yearEntry.find('option:selected').prop('selected', false);
            if (e.val === "0") {
                this.currentModel = false;
            } else {
                this.currentModel = e.val;
            }
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
            this.clearVehicleSelect();
            this.$modelEntry.find($('option.model-option')).remove();
            this.$modelEntry.select2().prop('disabled', true);
        },
        yearChanged: function (obj) {
            if (this.$yearEntry.val() === "0") {
                this.currentYear = false;
            } else {
                this.currentYear = this.$yearEntry.val();
            }

            this.loadFilteredVehicles();
        }
    });
})(jQuery);