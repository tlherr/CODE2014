/*global Backbone,console,_ */
var app = app || {};

(function ($) {
    'use strict';

    app.VehicleSelectView = Backbone.View.extend({
        tagName: 'li',
        template: _.template($('#vehicle-select-template').html()),
        render: function () {
            this.$el.html(this.template(this.model.toJSON()));
            return this;
        }
    });
})(jQuery);