// Set destination from query string when form is fully loaded
jQuery(document).on( 'nfFormReady', function() {
    const urlParams = new URLSearchParams( window.location.search );
    let destination = urlParams.get( 'dest' );

    if ( destination !== '' ) {
        destination = destination.toLowerCase().replaceAll( ' ', '-' ).replaceAll( '+', '-' ).replaceAll( '%20', '-' )
        document.querySelector("select.contact-destination").value = destination
    }
});