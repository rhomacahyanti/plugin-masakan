/*jQuery(document).ready(function( jQuery ) {
	jQuery(function() {
		var url = MyAutocomplete.url + "?action=my_search";
		jQuery( "#searchinput" ).autocomplete({
			source: url,
			delay: 100,
			minLength: 2
		});
	});

})( jQuery );*/

// Suggestion Box

console.log('test');
(function ($) {
    $('body').click(function (evt) {
        if (evt.target.id == "searchbox__suggestion" || evt.target.id == "query") {
            $('#searchbox__suggestion').attr('class', 'active');
        } else {
            $('#searchbox__suggestion').attr('class', '');
        }
    });

    $('#close-suggestion').click(function () {
        $('.search-box-input').val('');
        $(this).removeClass('active');
    });

    var index = -1;

    $(document).ready(function(){
      $('#searchinput').on('keyup', function (e) {
        console.log('keyup');
          if ($('.search-box-input').val().length >= 3) {
              var suggestions = document.getElementsByClassName('suggestion-list__items');
              var lastIndex = suggestions.length - 1;
              if (e.keyCode === 38) {
                  if (index === 0) {
                      index = lastIndex;
                  } else {
                      index = index - 1;
                  }
              } else if (e.keyCode === 40) {
                  if (index === lastIndex) {
                      index = 0;
                  } else {
                      index = index + 1;
                  }
              } else if (e.keyCode === 13) {
                  e.preventDefault();
                  e.stopPropagation();
                  var link = suggestions[index].getElementsByTagName('a')[0].href;
                  window.open(link, "_self");
              } else {
                  e.preventDefault();
                  e.stopPropagation();
                  var query = $(this).val();
                  $.ajax({
                      type: 'GET',
                      url: 'http://task.test/wp-json/wp/v2/food?per_page=5&search=' + query,
                      success: function (data) {
                          $('.suggestion-list').empty();
                          var list = '';
                          for (var i = 0; i < data.length; i++) {
                              list += '<li class="suggestion-list__items"><a href="' + data[i].link + '"><span class="title-s">' + data[i].title.rendered + '</span></a></li>';
                          }
                          $('.suggestion-list').append(list);
                      },
                      error: function (error) {
                          // console.log(error);
                      },
                      timeout: 1000
                  });
              }

              if (index !== -1) {
                  for (var x = 0; x < suggestions.length; x++) {
                      suggestions[x].className = 'suggestion-list__items';
                  }
                  suggestions[index].className = 'suggestion-list__items selected';
              }

              $('#searchbox__suggestion').addClass('active');
              $('#close-suggestion').addClass('active');
          } else {
              index = -1;
              $('#searchbox__suggestion').removeClass('active');
              $('#close-suggestion').removeClass('active');
          }
      });
    });
})(jQuery);
