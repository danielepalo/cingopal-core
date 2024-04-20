( function( api ) {

	// Extends our custom "upgrade-pro" section.
	api.sectionConstructor['upgrade-pro'] = api.Section.extend( {

		// No events for this type of section.
		attachEvents: function () {},

		// Always make the section active.
		isContextuallyActive: function () {
			return true;
		}
	} );

} )( wp.customize );
