var makes = new Bloodhound({
    datumTokenizer: function(d) {
        console.log(d);
        return Bloodhound.tokenizers.whitespace(d.label);
    },
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    remote: 'http://code2014.mark.renegade.local/app_dev.php/api/v1/makes'
});

makes.initialize();

$('#make-entry')
    .typeahead(null, {
        displayKey: 'label',
        source: makes.ttAdapter()
    }).on('typeahead:opened', function() {
        console.log('opened');
    }).on('typeahead:selected', function(e, object) {
        console.log(arguments);
        console.log('selected');

        //Do next query with ID from first

    }).on('typeahead:autocompleted', function($e, datum){
        console.log('autocompleted');
        console.log(datum);
    });


