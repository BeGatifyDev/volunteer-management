( function( blocks, element ) {
    var el = element.createElement;

    blocks.registerBlockType( 'vm/volunteer-list', {
        title: 'Volunteer List',
        icon: 'groups',
        category: 'widgets',
        edit: function() {
            return el(
                'p',
                {},
                'Volunteer list will appear here on frontend.'
            );
        },
        save: function() {
            return null; // Renders via PHP
        }
    } );
} )( window.wp.blocks, window.wp.element );
