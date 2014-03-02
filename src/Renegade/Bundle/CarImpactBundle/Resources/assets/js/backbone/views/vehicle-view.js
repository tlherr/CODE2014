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
            return this;
        }
    });
})(jQuery);