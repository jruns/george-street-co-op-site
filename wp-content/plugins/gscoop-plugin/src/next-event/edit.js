import { __ } from '@wordpress/i18n';
import ServerSideRender from '@wordpress/server-side-render';
import { useBlockProps } from '@wordpress/block-editor';
import { Disabled } from '@wordpress/components';
import metadata from './block.json';
import './editor.scss';

export default function Edit( props ) {
	const blockProps = useBlockProps();
	const {
        attributes,
        setAttributes,
    } = props;

	let urlQueryArgs = {};
	for ( const contextName in props.context ) {
		urlQueryArgs[ contextName ] = props.context[ contextName ] ?? null;
	}

	return (
		<>
			<div { ...blockProps }>
				<Disabled>
					<ServerSideRender
						block={ metadata.name }
						skipBlockSupportAttributes
						attributes={ attributes}
						urlQueryArgs={ urlQueryArgs }
					/>
				</Disabled>
			</div>
		</>
	);
}
