/*jQuery(function($){
	var searchRequest;
	$('.searchinput').autoComplete({
		minChars: 2,
		source: function(term, suggest){
			try { searchRequest.abort(); } catch(e){}
			searchRequest = $.get( global.search_api, { term: term }, function( res ) {
				if ( res !== null ) {
					var results = [];
					for(var key in res) {
						results.push(res[key].post_title)
					}
					suggest(results);
				}
			});
		}
	});
});*/

(function( $ ) {
	$(function() {
		var url = MyAutocomplete.url + "?action=my_search";
		$( "#searchinput" ).autocomplete({
			source: url,
			delay: 100,
			minLength: 2
		});
	});

})( jQuery );
