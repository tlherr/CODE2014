$(document).ready(function() {

    window.App = Ember.Application.create();
    App.Store = DS.Store.extend({
        adapter: DS.FixtureAdapter
    });

    //Create Models
    App.make = DS.Model.extend({
        label: attr(),
        canonical_label: attr(),
        name: attr()
    });

    App.model = DS.Model.extend({
        make_id: attr(),
        label: attr(),
        year: attr(),
        transmission: attr()
    });

    //Create a bunch of fake routes that map to the backend api calls for data

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

