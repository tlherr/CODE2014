$(document).ready(function() {


    window.App = Ember.Application.create();

    App.Store = DS.Store.extend({
        adapter: DS.FixtureAdapter
    });


    //Routing

    App.Router.map(function(){
        this.route('makes');
    });

    App.IndexRoute = Ember.Route.extend({
        setupController: function(controller) {
            // This sets the IndexController's title property:
            controller.set('title', "The is the index controller");
        }
    });

    App.MakesRoute = Ember.Route.extend({
        model: function() {

            console.log(App.Make.all());
            return App.Make.all();
        }
    });

    //Models

    var attr = DS.attr;
    App.Make = DS.Model.extend({
        label: attr(),
        canonical_label: attr(),
        name: attr()
    });

    App.Make.reopenClass({
        allMakes: [],
        all: function(){
            this.allMakes = [];
            $.ajax({
                url: window.location.protocol + "//" + window.location.host + "/app_dev.php/api/v1/makes",
                dataType: 'json',
                context: this,
                success: function(response){
                    response.makes.forEach(function(Make){
                        this.allMakes.addObject(App.Make.createRecord(Make))
                    }, this)
                }
            });
            return this.allMakes;
        }
    });





});

