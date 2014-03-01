$(document).ready(function() {


    window.App = Ember.Application.create();

    App.Store = DS.Store.extend({
        adapter: DS.FixtureAdapter
    });


    //Routing

    App.Router.map(function(){
        this.route('contributors');
    });


    App.IndexRoute = Ember.Route.extend({
        setupController: function(controller) {
            // This sets the IndexController's title property:
            controller.set('title', "The is the index controller");
        }
    });

    App.ContributorsRoute = Ember.Route.extend({
        model: function() {
            return App.Contributor.all();
        }
    });

    //Models

    var attr = DS.attr;
    App.Contributor = DS.Model.extend({
        label: attr(),
        canonical_label: attr(),
        name: attr()
    });

    App.Contributor.reopenClass({
        allContributors: [],
        all: function(){
            this.allContributors = [];
            $.ajax({
                url: window.location.protocol + "//" + window.location.host + "/app_dev.php/api/v1/makes",
                dataType: 'json',
                context: this,
                success: function(response){
                    response.makes.forEach(function(contributor){
                        this.allContributors.addObject(App.Contributor.createRecord(contributor))
                    }, this)
                }
            });
            return this.allContributors;
        }
    });





});

