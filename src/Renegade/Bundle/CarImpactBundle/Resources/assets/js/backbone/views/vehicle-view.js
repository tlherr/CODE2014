/*global Backbone,console,_ */
var app = app || {};

(function ($) {
    'use strict';

    app.VehicleView = Backbone.View.extend({
        tagName: 'li',
        template: _.template($('#vehicle-template').html()),
        render: function () {
            console.log(this.model);
            this.$el.html(this.template(this.model.toJSON()));

            // data-highway-mpg="<%- mileage.highway.mpg %>" data-city-mpg="<%- mileage.city.mpg %>" data-transmission="<%- transmission %>" data-fuel="<%- fuel %>" data-year="<%- year %>" data-engine-size="<%- engine_size %>"
            var mileage = this.model.get('mileage');
            this.$el.addClass('sortable');

            this.$el.attr('data-highway-mpg', mileage.highway.mpg);
            this.$el.attr('data-highway-lph', mileage.highway.lph);
            this.$el.attr('data-city-mpg', mileage.city.mpg);
            this.$el.attr('data-city-lph', mileage.city.lph);

            this.$el.attr('data-transmission', this.model.get('transmission'));
            this.$el.attr('data-fuel', this.model.get('fuel'));
            this.$el.attr('data-year', this.model.get('year'));
            this.$el.attr('data-engine-size', this.model.get('engine-size'));
            return this;
        }
    });
})(jQuery);