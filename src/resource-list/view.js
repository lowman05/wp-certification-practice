import { getContext, store } from '@wordpress/interactivity';

store( 'wpcpResourceList', {
	actions: {
		toggle() {
			const context = getContext();

			context.isOpen = ! context.isOpen;
		},
	},
} );
