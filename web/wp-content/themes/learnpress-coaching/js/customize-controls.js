( function( api ) {

	// Extends our custom "learnpress-coaching" section.
	api.sectionConstructor['learnpress-coaching'] = api.Section.extend( {

		// No events for this type of section.
		attachEvents: function () {},

		// Always make the section active.
		isContextuallyActive: function () {
			return true;
		}
	} );

} )( wp.customize );