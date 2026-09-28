import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { PanelBody, RangeControl, SelectControl } from '@wordpress/components';
import { store as coreDataStore } from '@wordpress/core-data';
import { useSelect } from '@wordpress/data';
import { __ } from '@wordpress/i18n';

export default function Edit( { attributes, setAttributes } ) {
	const { postsToShow, resourceType } = attributes;

	const { resourceTypes, resources } = useSelect(
		( select ) => {
			const { getEntityRecords } = select( coreDataStore );

			const terms = getEntityRecords( 'taxonomy', 'wpcp_resource_type', {
				per_page: 100,
				orderby: 'name',
				order: 'asc',
			} );

			const selectedTerm = ( terms || [] ).find(
				( term ) => term.slug === resourceType
			);

			const resourceQuery = {
				per_page: postsToShow,
				status: 'publish',
				orderby: 'date',
				order: 'desc',
			};

			if ( resourceType ) {
				if ( ! selectedTerm ) {
					return {
						resourceTypes: terms,
						resources: null,
					};
				}

				resourceQuery.wpcp_resource_type = selectedTerm.id;
			}

			return {
				resourceTypes: terms,
				resources: getEntityRecords(
					'postType',
					'wpcp_resource',
					resourceQuery
				),
			};
		},
		[ postsToShow, resourceType ]
	);

	const resourceTypeOptions = [
		{
			label: __( 'All Resource Types', 'wp-certification-practice' ),
			value: '',
		},
		...( resourceTypes || [] ).map( ( term ) => ( {
			label: term.name,
			value: term.slug,
		} ) ),
	];

	return (
		<>
			<InspectorControls>
				<PanelBody
					title={ __(
						'Resource List Settings',
						'wp-certification-practice'
					) }
				>
					<RangeControl
						label={ __(
							'Number of Resources',
							'wp-certification-practice'
						) }
						value={ postsToShow }
						onChange={ ( value ) =>
							setAttributes( { postsToShow: value } )
						}
						min={ 1 }
						max={ 10 }
					/>

					<SelectControl
						label={ __(
							'Resource Type',
							'wp-certification-practice'
						) }
						value={ resourceType }
						options={ resourceTypeOptions }
						onChange={ ( value ) =>
							setAttributes( { resourceType: value } )
						}
					/>
				</PanelBody>
			</InspectorControls>

			<div { ...useBlockProps() }>
				<h3>{ __( 'Resource List', 'wp-certification-practice' ) }</h3>

				{ resources === null && (
					<p>
						{ __(
							'Loading Resources…',
							'wp-certification-practice'
						) }
					</p>
				) }

				{ resources && resources.length === 0 && (
					<p>
						{ __(
							'No Resources match the current settings.',
							'wp-certification-practice'
						) }
					</p>
				) }

				{ resources && resources.length > 0 && (
					<ul>
						{ resources.map( ( resource ) => (
							<li key={ resource.id }>
								{ resource.title.rendered ||
									__(
										'Untitled Resource',
										'wp-certification-practice'
									) }
							</li>
						) ) }
					</ul>
				) }
			</div>
		</>
	);
}
