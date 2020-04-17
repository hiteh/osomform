(function( $ ) {
	
	$( "html" ).removeClass( "no-js" )
	
	const form = $( "#osomform" )
	const button = form.find( "#osomform-send" )
	const inputs = form.find( "input,select" ).not( ":input[type=button], :input[type=submit]" )
	const consent = $( "#consent" )
	let errors = []
	const payload = {}
	const endpoint = wpApiSettings.root + "osomform/v1/osomcontact"

	const setErrors = ( test, element ) => {
		if ( test ) {
	    	element.addClass( "invalid" )
	    	element.attr( "aria-invalid", true )
	    	
	    	if( ! errors.includes( element.attr( "name" ) ) ) {
	    		errors.push( element.attr( "name" ) )
	    	}

	    } else {
	    	element.removeClass( "invalid" )
	    	element.attr( "aria-invalid", false )
	    	errors = errors.filter( ( value ) => value !== element.attr( "name" ) )
	    }
	}

	const validateInput = ( element ) => {

		const type = element.attr( "type" )
		const value = element.val()
		const name = element.attr( "name" )

		switch( type ) {
		  case "text":
		  	let pattern_t = ""
		  	if( "login" === name ) {
		  		pattern_t = new RegExp( /[^a-z0-9]/ )
		  	} else {
		  		pattern_t = new RegExp( /[^-AaĄąBbCcĆćDdEeĘęFfGgHhIiJjKkLlŁłMmNnŃńOoÓóPpQqRrSsŚśTtUuWwVvXxYyZzŹźŻż]/ )
		  	}
		   	setErrors( pattern_t.test( value ), element ) 
		    break;
		  case "email":
		    const pattern_e = new RegExp( /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/ )
		   	setErrors( ! pattern_e.test( value ), element ) 
		    break;
		  default:
		   	element.removeClass( "invalid" )
    		element.attr( "aria-invalid", false )
		}
	}

	const preparePayload = () => {
		inputs.each( ( index, input ) => {
			let element = $( input )
			payload[element.attr( "name" )] = element.val()
		} )
	}

	const sendRequest = ( method, endpoint, payload ) => {
		$.ajax( {
      		url: endpoint,
      		method: method,
      		dataType: 'json',
      		beforeSend: ( xhr ) => {
        		xhr.setRequestHeader( "X-WP-Nonce", wpApiSettings.nonce )
      		},
	      	data: payload
    	} )
    	.done( ( response ) => {
	      	alert( response.message )
	      	inputs.each( ( index, input ) => {
	      		const $target = $( input )
	      		! $target.is( "select" ) ? $target.val('') : ""
			} )
    	} )
    	.fail( ( response ) => {
    		alert( response.error )
    	} )
	}

	inputs.each( ( index, input ) => {
		$( input ).on( "input", ( e ) => {

			const target = $( e.target )
			validateInput( target )

		} )
	} )
	
	consent.on( "change", ( e ) => {

		const checked = $(e.target).prop( "checked" )
		checked ? button.prop( "disabled", false ) : button.prop( "disabled", true )
	} )

	button.on( "click", ( e ) => {
		
		e.preventDefault()
		inputs.each( ( index, input ) => {
			
			const target = $( input )
			validateInput( target )
			"" === target.val() ? setErrors( true, target ) : ""
		} )

		if( errors.length > 0 ) {
			return
		}

		preparePayload()
		sendRequest( "POST", endpoint, payload )
	} )

})( jQuery );
