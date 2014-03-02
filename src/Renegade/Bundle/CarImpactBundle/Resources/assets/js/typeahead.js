
var makes = new Bloodhound({
    datumTokenizer: function(d) { return Bloodhound.tokenizers.whitespace(d.label); },
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    remote: 'http://code2014.mark.renegade.local/app_dev.php/api/v1/makes'
});

var models = new Bloodhound({
    datumTokenizer: function(d) { return Bloodhound.tokenizers.whitespace(d.label); },
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    remote: 'test'
});

makes.initialize();

$('#make-entry')
.typeahead(null, {
    displayKey: 'label',
    source: makes.ttAdapter()
}).on('typeahead:opened', function() {
}).on('typeahead:selected', function(e, object) {
    models.remote = 'http://code2014.mark.renegade.local/app_dev.php/api/v1/makes/' + object.id + '/models';
    models.initialize();
});


$('#model-entry')
.typeahead(null, {
    displayKey: 'label',
    source: models.ttAdapter()
});


