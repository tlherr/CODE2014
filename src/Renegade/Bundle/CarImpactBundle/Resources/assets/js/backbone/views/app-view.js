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
            this.$yearEntry = this.$('#year-entry');
            this.$vehicleSelectList = this.$('#vehicle-select-list');

            this.$makeEntry.select2();
            this.$modelEntry.select2();
            this.$yearEntry.select2();

            this.$modelEntry.select2('enable', false);
            this.$yearEntry.select2('enable', false);

            this.listenTo(app.vehicles, 'add', this.addVehicle);

            this.listenTo(app.models, 'reset', this.modelsReset);
            this.listenTo(app.models, 'add', this.modelAdded);
            this.listenTo(app.modelYears, 'reset', this.yearsReset);
            this.listenTo(app.modelYears, 'add', this.yearAdded);

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
                successCallback;

            if (this.currentModel && this.currentYear) {
                app.filteredVehicles.fetchFiltered(this.currentModel, this.currentYear, {
                    success: function () {
                        app.filteredVehicles.forEach(function(obj) {
                            var vehicleView = new app.VehicleSelectView({model: obj});
                            that.$vehicleSelectList.append(vehicleView.render().el);
                        });
                    }
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
            var newValue = this.$makeEntry.val();
            this.clearVehicleSelect();
            this.modelsReset();
            if (newValue === "0") {
                this.currentMake = false;
            } else {
                this.currentMake = newValue;
                this.loadModels();
            }
        },
        modelChanged: function(e) {
            var newValue = this.$modelEntry.val();
            this.clearVehicleSelect();
            this.yearsReset();
            if (newValue === "0") {
                this.currentModel = false;
            } else {
                this.currentModel = newValue;
                this.loadYears();
            }
        },
        yearChanged: function (obj) {
            var newValue = this.$yearEntry.val();
            this.clearVehicleSelect();
            if (newValue === "0") {
                this.currentYear = false;
            } else {
                this.currentYear = newValue;
                this.loadFilteredVehicles();
            }
        },
        loadModels: function() {
            var that = this;
            app.models.fetchMake(this.currentMake, {
                success: function () {
                    that.$modelEntry.select2('enable', true);
                }
            });
        },
        loadYears: function() {
            var that = this;
            app.modelYears.fetchModelYears(this.currentModel, {
                success: function () {
                    that.$yearEntry.select2('enable', true);
                }
            });
        },
        modelAdded: function (object) {
            ($('<option>', { value: object.get('id') }).addClass('loaded-option').text(object.get('label'))).appendTo(this.$modelEntry);
        },
        yearAdded: function (object) {
            ($('<option>', { value: object.get('year') }).addClass('loaded-option').text(object.get('year'))).appendTo(this.$yearEntry);
        },
        modelsReset: function() {
            this.$modelEntry.select2('val', 0);
            this.$modelEntry.select2('enable', false);
            this.$modelEntry.find('option.loaded-option').remove();
            this.yearsReset();
        },
        yearsReset: function() {
            this.$yearEntry.select2('val', 0);
            this.$yearEntry.select2('enable', false);
            this.$yearEntry.find('option.loaded-option').remove();
        }
    });
})(jQuery);