(function($) {

  /* globals jQuery */

  "use strict";

  function mfnFieldIcon() {

    var group = '.form-group.browse-icon ';

    var $modal = $('.mfn-ui .modal-select-icon'),
      $search = $('.mfn-search', $modal),
      $form = false;

    var timer = false;

    // open

    $('.mfn-ui').on('click', group + '.mfn-button-upload', function(e) {

      e.preventDefault();

      $(document).trigger('mfn:modal:open', $modal);

      $form = $(this).closest('.form-group');

      var val = $('.mfn-form-input', $form).val();

      $search.val('');
      search('');

      $('.modalbox-content', $modal).scrollTop(0);

      $('.mfn-items-list li', $modal).removeClass('active');

      if( val ){

        $modal.find('li[data-rel="'+ val +'"]').addClass('active');

        if( -1 != val.indexOf('fa-') ){
          $('.mfn-select', $modal).val('fontawesome').trigger('change');
        } else {
          $('.mfn-select', $modal).val('mfnicons').trigger('change');
        }

      }

    });

    // close modal

    function close(){

      $(document).trigger('mfn:modal:close');

    }

    // select icon

    $modal.on('click', '.mfn-items-list a', function(e) {

      e.preventDefault();

      var $li = $(this).closest('li');

      var val = $li.data('rel');

      $form.removeClass('empty');

      $('.mfn-form-input', $form).val( val );
      $('.mfn-button-upload i', $form).attr( 'class', val );

      close();
    });

    // icon pack change

    $modal.on('change', '.mfn-select', function(e) {

      var val = $(this).val();

      $('.modalbox-content', $modal).find('.' + val).show().siblings().hide();

    });

    // remove

    $('.mfn-ui').on('click', group + '.mfn-button-delete', function(e) {

      e.preventDefault();

      $form = $(this).closest('.form-group');

      $form.addClass('empty');

      $('.mfn-form-input', $form).val('');
    });

    // search

    function search( value ){

      var $items = $('.mfn-items-list li', $modal);

      var value = value.toLowerCase();

      if( value ){

        $items.filter('[data-rel*=' + value + ']').show();
        $items.not('[data-rel*=' + value + ']').hide();

      } else {

        $items.show();

      }

    }

    function searchTimer( $input ){
      clearTimeout( timer );
      timer = setTimeout(function() {
        search( $input.val() );
      }, 300, $input);
    }

    $search.on('keyup', function() {
      searchTimer( $(this) );
    });

    // input change

    $('.mfn-ui').on('change', group + '.mfn-form-input', function(e) {

      e.preventDefault();

      $form = $(this).closest('.form-group');

      var val = $(this).val();

      if( val ){

        $form.removeClass('empty');
        $('.mfn-button-upload i', $form).attr( 'class', val );

      } else {

        $form.addClass('empty');

      }

    });

  }

  /**
   * $(document).ready
   * Specify a function to execute when the DOM is fully loaded.
   */

  $(function() {
    mfnFieldIcon();
  });

})(jQuery);
