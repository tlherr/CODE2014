$(document).ready(function() {

    window.App = Ember.Application.create();
    App.Store = DS.Store.extend({
        adapter: DS.FixtureAdapter
    });

    App.ApplicationAdapter = DS.RESTAdapter.extend({
        host: 'http://code2014.mark.renegade.local/app_dev.php',
        namespace: 'api/v1'
    });

    //Create Models
    App.Make = DS.Model.extend({
        label: attr(),
        canonical_label: attr(),
        name: attr()
    });

    App.Model = DS.Model.extend({
        make_id: attr(),
        label: attr(),
        year: attr(),
        transmission: attr()
    });

    //Create a bunch of fake routes that map to the backend api calls for data
    App.Router.map(function() {
        this.route("make", { path: "/makes" });
        this.route("model", { path: "/makes/:make_id/models" });
    });


    App.MakeRoute = Ember.Route.extend({
        model: function() {
            return this.store.find('makes');
        }
    });


    App.ModelRoute = Ember.Route.extend({
        model: function(params) {
            return this.store.find('model', params.make_id);
        }
    });


    //Then use these routes to populate local datastores

    var vehicleMake = function(query, cb) {
        var results = $.map(['!', '!!', '!!!'], function(appendage) {
            var datum = { make: query + appendage };

            return datum;
        });

        cb(results);
    };

    $('#vehicle-make-typeahead').typeahead(null, {
        displayKey: 'make',
        source: vehicleMake
    });

});

