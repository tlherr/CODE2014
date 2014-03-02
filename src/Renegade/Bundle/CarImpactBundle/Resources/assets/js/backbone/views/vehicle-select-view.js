/*global Backbone,console,_ */
var app = app || {};

(function ($) {
    'use strict';

    app.VehicleSelectView = Backbone.View.extend({
        tagName: 'li',
        template: _.template($('#vehicle-select-template').html()),
        events: {
            'click .add-button': 'addButtonClicked'
        },
        render: function () {
            this.$el.html(this.template(this.model.toJSON()));
            return this;
        },
        addButtonClicked: function () {
            this.trigger('load:vehicle', {id: this.model.get('id')});
        }
    });
})(jQuery);