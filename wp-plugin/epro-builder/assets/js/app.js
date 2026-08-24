/**
 * EPRO Builder — full-screen editor app (v0.1).
 * Build-free: uses WordPress's bundled React (wp.element) + wp.components.
 *
 * v0.1 scope: add / select / edit / reorder / delete widgets & sections,
 * save to REST, live front-end preview (refreshes on save).
 * In-canvas drag-drop is a later phase.
 */
( function ( wp, cfg ) {
	'use strict';

	if ( ! wp || ! wp.element || ! cfg ) {
		// eslint-disable-next-line no-console
		console.error( 'EPRO Builder: WordPress scripts not available.' );
		return;
	}

	var el = wp.element.createElement;
	var Fragment = wp.element.Fragment;
	var useState = wp.element.useState;
	var useEffect = wp.element.useEffect;
	var C = wp.components;
	var apiFetch = wp.apiFetch;
	var __ = ( wp.i18n && wp.i18n.__ ) ? wp.i18n.__ : function ( s ) { return s; };

	if ( cfg.nonce && apiFetch.createNonceMiddleware ) {
		apiFetch.use( apiFetch.createNonceMiddleware( cfg.nonce ) );
	}

	/* ----------------------------------------------------------- schemas */

	var ALIGN = [ [ 'left', __( 'Chap', 'epro-builder' ) ], [ 'center', __( 'Markaz', 'epro-builder' ) ], [ 'right', __( "O'ng", 'epro-builder' ) ] ];

	var WIDGETS = {
		heading: { label: __( 'Sarlavha', 'epro-builder' ), icon: 'H', defaults: { text: __( 'Yangi sarlavha', 'epro-builder' ), level: 'h2', align: 'left' }, fields: [
			{ key: 'text', type: 'text', label: __( 'Matn', 'epro-builder' ) },
			{ key: 'level', type: 'select', label: __( 'Daraja', 'epro-builder' ), options: [ [ 'h1', 'H1' ], [ 'h2', 'H2' ], [ 'h3', 'H3' ], [ 'h4', 'H4' ] ] },
			{ key: 'align', type: 'select', label: __( 'Hizalash', 'epro-builder' ), options: ALIGN }
		] },
		text: { label: __( 'Matn', 'epro-builder' ), icon: '¶', defaults: { html: '<p>' + __( 'Matn kiriting...', 'epro-builder' ) + '</p>', align: 'left' }, fields: [
			{ key: 'html', type: 'textarea', label: __( 'Matn (HTML)', 'epro-builder' ) },
			{ key: 'align', type: 'select', label: __( 'Hizalash', 'epro-builder' ), options: ALIGN }
		] },
		button: { label: __( 'Tugma', 'epro-builder' ), icon: '⬚', defaults: { text: __( 'Tugma', 'epro-builder' ), url: '#', variant: 'primary', size: 'lg', align: 'left' }, fields: [
			{ key: 'text', type: 'text', label: __( 'Matn', 'epro-builder' ) },
			{ key: 'url', type: 'text', label: __( 'Havola', 'epro-builder' ) },
			{ key: 'variant', type: 'select', label: __( 'Uslub', 'epro-builder' ), options: [ [ 'primary', __( 'Asosiy', 'epro-builder' ) ], [ 'outline', __( 'Chiziqli', 'epro-builder' ) ], [ 'ghost', __( 'Shaffof', 'epro-builder' ) ] ] },
			{ key: 'size', type: 'select', label: __( "O'lcham", 'epro-builder' ), options: [ [ 'sm', 'S' ], [ 'md', 'M' ], [ 'lg', 'L' ], [ 'xl', 'XL' ] ] },
			{ key: 'align', type: 'select', label: __( 'Hizalash', 'epro-builder' ), options: ALIGN }
		] },
		image: { label: __( 'Rasm', 'epro-builder' ), icon: '🖼', defaults: { id: 0, url: '', alt: '', rounded: 0, align: 'center' }, fields: [
			{ key: '__media', type: 'media', label: __( 'Rasm', 'epro-builder' ) },
			{ key: 'alt', type: 'text', label: __( 'Alt matn', 'epro-builder' ) },
			{ key: 'rounded', type: 'toggle', label: __( 'Yumaloq burchak', 'epro-builder' ) },
			{ key: 'align', type: 'select', label: __( 'Hizalash', 'epro-builder' ), options: ALIGN }
		] },
		spacer: { label: __( "Bo'shliq", 'epro-builder' ), icon: '↕', defaults: { height: 40 }, fields: [
			{ key: 'height', type: 'number', label: __( 'Balandlik (px)', 'epro-builder' ) }
		] },
		divider: { label: __( 'Ajratgich', 'epro-builder' ), icon: '—', defaults: {}, fields: [] },
		hero: { label: __( 'Hero (preset)', 'epro-builder' ), icon: '★', defaults: { badge: '#1 SaaS', title: __( 'Sarlavha', 'epro-builder' ), title_accent: __( "urg'u", 'epro-builder' ), subtitle: __( 'Tavsif...', 'epro-builder' ), primary_text: __( 'Boshlash', 'epro-builder' ), primary_url: '#', secondary_text: __( 'Batafsil', 'epro-builder' ), secondary_url: '#', note: '' }, fields: [
			{ key: 'badge', type: 'text', label: 'Badge' },
			{ key: 'title', type: 'text', label: __( 'Sarlavha', 'epro-builder' ) },
			{ key: 'title_accent', type: 'text', label: __( "Urg'u (gradient)", 'epro-builder' ) },
			{ key: 'subtitle', type: 'textarea', label: __( 'Tavsif', 'epro-builder' ) },
			{ key: 'primary_text', type: 'text', label: __( 'Asosiy tugma', 'epro-builder' ) },
			{ key: 'primary_url', type: 'text', label: __( 'Asosiy havola', 'epro-builder' ) },
			{ key: 'secondary_text', type: 'text', label: __( 'Ikkilamchi tugma', 'epro-builder' ) },
			{ key: 'secondary_url', type: 'text', label: __( 'Ikkilamchi havola', 'epro-builder' ) },
			{ key: 'note', type: 'text', label: __( 'Izoh', 'epro-builder' ) }
		] },
		cta: { label: __( 'CTA (preset)', 'epro-builder' ), icon: '◆', defaults: { title: __( 'Sarlavha', 'epro-builder' ), subtitle: __( 'Tavsif', 'epro-builder' ), button_text: __( 'Boshlash', 'epro-builder' ), button_url: '#' }, fields: [
			{ key: 'title', type: 'text', label: __( 'Sarlavha', 'epro-builder' ) },
			{ key: 'subtitle', type: 'textarea', label: __( 'Tavsif', 'epro-builder' ) },
			{ key: 'button_text', type: 'text', label: __( 'Tugma matni', 'epro-builder' ) },
			{ key: 'button_url', type: 'text', label: __( 'Tugma havolasi', 'epro-builder' ) }
		] }
	};

	var SECTION_FIELDS = [
		{ key: 'background', type: 'select', label: __( 'Fon', 'epro-builder' ), options: [ [ 'white', __( 'Oq', 'epro-builder' ) ], [ 'base', __( 'Och kulrang', 'epro-builder' ) ], [ 'dark', __( 'Qora', 'epro-builder' ) ], [ 'gradient', __( 'Gradient', 'epro-builder' ) ] ] },
		{ key: 'padding', type: 'select', label: __( "Ichki bo'shliq", 'epro-builder' ), options: [ [ 'none', __( "Yo'q", 'epro-builder' ) ], [ 'sm', __( 'Kichik', 'epro-builder' ) ], [ 'md', __( "O'rta", 'epro-builder' ) ], [ 'lg', __( 'Katta', 'epro-builder' ) ] ] },
		{ key: 'width', type: 'select', label: __( 'Kenglik', 'epro-builder' ), options: [ [ 'boxed', __( 'Cheklangan', 'epro-builder' ) ], [ 'full', __( "To'liq", 'epro-builder' ) ] ] }
	];

	/* ----------------------------------------------------------- helpers */

	function uid( p ) {
		return p + '_' + Math.random().toString( 36 ).slice( 2, 9 );
	}
	function clone( o ) {
		return JSON.parse( JSON.stringify( o ) );
	}
	function newColumn() {
		return { id: uid( 'c' ), type: 'column', settings: { width: 100 }, widgets: [] };
	}
	function newSection() {
		return { id: uid( 's' ), type: 'section', settings: { background: 'white', padding: 'md', width: 'boxed' }, columns: [ newColumn() ] };
	}
	function newWidget( type ) {
		return { id: uid( 'w' ), type: type, settings: clone( WIDGETS[ type ].defaults ) };
	}

	/* ----------------------------------------------------------- field control */

	function FieldControl( props ) {
		var f = props.field;
		var settings = props.settings;
		var onChange = props.onChange;
		var value = settings[ f.key ];

		if ( f.type === 'media' ) {
			return el( 'div', { className: 'epro-field-media' },
				settings.url ? el( 'img', { src: settings.url, alt: '', className: 'epro-media-preview' } ) : null,
				el( C.Button, { variant: 'secondary', onClick: function () {
					var frame = wp.media( { title: __( 'Rasm tanlash', 'epro-builder' ), multiple: false, library: { type: 'image' } } );
					frame.on( 'select', function () {
						var a = frame.state().get( 'selection' ).first().toJSON();
						onChange( { id: a.id, url: a.url, alt: a.alt || '' } );
					} );
					frame.open();
				} }, settings.url ? __( "Rasmni o'zgartirish", 'epro-builder' ) : __( 'Rasm tanlash', 'epro-builder' ) ),
				settings.url ? el( C.Button, { variant: 'tertiary', isDestructive: true, onClick: function () { onChange( { id: 0, url: '', alt: '' } ); } }, __( "O'chirish", 'epro-builder' ) ) : null
			);
		}
		if ( f.type === 'select' ) {
			return el( C.SelectControl, {
				label: f.label,
				value: value,
				options: f.options.map( function ( o ) { return { value: o[ 0 ], label: o[ 1 ] }; } ),
				onChange: function ( v ) { onChange( objSet( f.key, v ) ); },
				__nextHasNoMarginBottom: true
			} );
		}
		if ( f.type === 'toggle' ) {
			return el( C.ToggleControl, {
				label: f.label,
				checked: !! value,
				onChange: function ( v ) { onChange( objSet( f.key, v ? 1 : 0 ) ); },
				__nextHasNoMarginBottom: true
			} );
		}
		if ( f.type === 'textarea' ) {
			return el( C.TextareaControl, {
				label: f.label,
				value: value || '',
				rows: 4,
				onChange: function ( v ) { onChange( objSet( f.key, v ) ); },
				__nextHasNoMarginBottom: true
			} );
		}
		// text / number / url
		return el( C.TextControl, {
			label: f.label,
			type: f.type === 'number' ? 'number' : 'text',
			value: value === undefined || value === null ? '' : value,
			onChange: function ( v ) { onChange( objSet( f.key, f.type === 'number' ? ( parseInt( v, 10 ) || 0 ) : v ) ); },
			__nextHasNoMarginBottom: true
		} );

		function objSet( k, v ) { var o = {}; o[ k ] = v; return o; }
	}

	/* ----------------------------------------------------------- app */

	function App() {
		var s0 = useState( { version: 1, sections: [] } );
		var layout = s0[ 0 ], setLayout = s0[ 1 ];
		var s1 = useState( true );
		var loading = s1[ 0 ], setLoading = s1[ 1 ];
		var s2 = useState( false );
		var saving = s2[ 0 ], setSaving = s2[ 1 ];
		var s3 = useState( null );
		var sel = s3[ 0 ], setSel = s3[ 1 ]; // { kind:'widget'|'section', s, c, w }
		var s4 = useState( 'desktop' );
		var device = s4[ 0 ], setDevice = s4[ 1 ];
		var s5 = useState( 0 );
		var tick = s5[ 0 ], setTick = s5[ 1 ];
		var s6 = useState( '' );
		var notice = s6[ 0 ], setNotice = s6[ 1 ];

		useEffect( function () {
			apiFetch( { url: cfg.restBase + '/layout/' + cfg.postId, method: 'GET' } ).then( function ( res ) {
				if ( res && res.data ) { setLayout( res.data ); }
				setLoading( false );
			} ).catch( function () {
				setNotice( __( 'Yuklashda xatolik.', 'epro-builder' ) );
				setLoading( false );
			} );
		}, [] );

		function commit( next ) {
			setLayout( next );
		}

		function addSection() {
			var next = clone( layout );
			next.sections.push( newSection() );
			commit( next );
			setSel( { kind: 'section', s: next.sections.length - 1 } );
		}
		function addWidget( type ) {
			var next = clone( layout );
			if ( ! next.sections.length ) { next.sections.push( newSection() ); }
			var si = sel && typeof sel.s === 'number' ? sel.s : next.sections.length - 1;
			var sec = next.sections[ si ];
			if ( ! sec.columns.length ) { sec.columns.push( newColumn() ); }
			sec.columns[ 0 ].widgets.push( newWidget( type ) );
			commit( next );
			setSel( { kind: 'widget', s: si, c: 0, w: sec.columns[ 0 ].widgets.length - 1 } );
		}
		function updateWidgetSettings( patch ) {
			if ( ! sel || sel.kind !== 'widget' ) { return; }
			var next = clone( layout );
			var w = next.sections[ sel.s ].columns[ sel.c ].widgets[ sel.w ];
			Object.keys( patch ).forEach( function ( k ) { w.settings[ k ] = patch[ k ]; } );
			commit( next );
		}
		function updateSectionSettings( patch ) {
			if ( ! sel || sel.kind !== 'section' ) { return; }
			var next = clone( layout );
			var sec = next.sections[ sel.s ];
			Object.keys( patch ).forEach( function ( k ) { sec.settings[ k ] = patch[ k ]; } );
			commit( next );
		}
		function deleteSel() {
			if ( ! sel ) { return; }
			var next = clone( layout );
			if ( sel.kind === 'widget' ) {
				next.sections[ sel.s ].columns[ sel.c ].widgets.splice( sel.w, 1 );
			} else {
				next.sections.splice( sel.s, 1 );
			}
			commit( next );
			setSel( null );
		}
		function moveWidget( si, ci, wi, dir ) {
			var next = clone( layout );
			var arr = next.sections[ si ].columns[ ci ].widgets;
			var j = wi + dir;
			if ( j < 0 || j >= arr.length ) { return; }
			var tmp = arr[ wi ]; arr[ wi ] = arr[ j ]; arr[ j ] = tmp;
			commit( next );
			setSel( { kind: 'widget', s: si, c: ci, w: j } );
		}
		function moveSection( si, dir ) {
			var next = clone( layout );
			var j = si + dir;
			if ( j < 0 || j >= next.sections.length ) { return; }
			var tmp = next.sections[ si ]; next.sections[ si ] = next.sections[ j ]; next.sections[ j ] = tmp;
			commit( next );
			setSel( { kind: 'section', s: j } );
		}

		function save( enabled ) {
			setSaving( true );
			setNotice( '' );
			apiFetch( { url: cfg.restBase + '/layout/' + cfg.postId, method: 'POST', data: { data: layout, enabled: enabled !== false } } )
				.then( function ( res ) {
					setSaving( false );
					if ( res && res.data ) { setLayout( res.data ); }
					setTick( tick + 1 ); // reload preview
					setNotice( __( 'Saqlandi ✓', 'epro-builder' ) );
					setTimeout( function () { setNotice( '' ); }, 2000 );
				} )
				.catch( function () {
					setSaving( false );
					setNotice( __( 'Saqlashda xatolik.', 'epro-builder' ) );
				} );
		}
		function disableBuilder() {
			if ( ! window.confirm( __( "Builder o'chirilsinmi? Sahifa oddiy muharrirga qaytadi.", 'epro-builder' ) ) ) { return; }
			apiFetch( { url: cfg.restBase + '/layout/' + cfg.postId, method: 'POST', data: { data: layout, enabled: false } } )
				.then( function () { window.location.href = cfg.exitUrl || cfg.previewUrl; } );
		}

		var frameWidth = device === 'mobile' ? 390 : ( device === 'tablet' ? 768 : '100%' );
		var previewSrc = cfg.previewUrl + ( cfg.previewUrl.indexOf( '?' ) === -1 ? '?' : '&' ) + 'epro_bust=' + tick;

		/* ---- panels ---- */

		function TopBar() {
			return el( 'div', { className: 'epro-topbar' },
				el( 'div', { className: 'epro-topbar-left' },
					el( 'strong', null, 'EPRO Builder' ),
					el( 'span', { className: 'epro-doc-title' }, cfg.title || '' )
				),
				el( 'div', { className: 'epro-topbar-center' },
					[ [ 'desktop', '🖥' ], [ 'tablet', '▭' ], [ 'mobile', '▯' ] ].map( function ( d ) {
						return el( C.Button, { key: d[ 0 ], variant: device === d[ 0 ] ? 'primary' : 'tertiary', onClick: function () { setDevice( d[ 0 ] ); } }, d[ 1 ] );
					} )
				),
				el( 'div', { className: 'epro-topbar-right' },
					notice ? el( 'span', { className: 'epro-notice' }, notice ) : null,
					el( C.Button, { variant: 'tertiary', href: cfg.previewUrl, target: '_blank' }, __( "Ko'rish", 'epro-builder' ) ),
					el( C.Button, { variant: 'tertiary', onClick: disableBuilder }, __( "O'chirish", 'epro-builder' ) ),
					el( C.Button, { variant: 'primary', isBusy: saving, onClick: function () { save( true ); } }, saving ? __( 'Saqlanmoqda…', 'epro-builder' ) : __( 'Saqlash', 'epro-builder' ) ),
					el( C.Button, { variant: 'tertiary', href: cfg.exitUrl }, '✕' )
				)
			);
		}

		function LeftPanel() {
			return el( 'div', { className: 'epro-left' },
				el( C.Button, { variant: 'primary', className: 'epro-add-section', onClick: addSection }, '+ ' + __( "Bo'lim qo'shish", 'epro-builder' ) ),
				el( 'div', { className: 'epro-widget-grid' },
					Object.keys( WIDGETS ).map( function ( type ) {
						return el( 'button', { key: type, className: 'epro-widget-btn', onClick: function () { addWidget( type ); } },
							el( 'span', { className: 'epro-widget-ico' }, WIDGETS[ type ].icon ),
							el( 'span', null, WIDGETS[ type ].label )
						);
					} )
				),
				el( 'div', { className: 'epro-tree' },
					el( 'div', { className: 'epro-tree-h' }, __( 'Struktura', 'epro-builder' ) ),
					layout.sections.length === 0 ? el( 'p', { className: 'epro-empty' }, __( "Hozircha bo'lim yo'q. Yuqoridan qo'shing.", 'epro-builder' ) ) : null,
					layout.sections.map( function ( sec, si ) {
						var selectedSec = sel && sel.kind === 'section' && sel.s === si;
						return el( 'div', { key: sec.id, className: 'epro-tree-sec' },
							el( 'div', { className: 'epro-tree-sec-h' + ( selectedSec ? ' is-sel' : '' ) },
								el( 'span', { className: 'epro-tree-label', onClick: function () { setSel( { kind: 'section', s: si } ); } }, '▦ ' + __( "Bo'lim", 'epro-builder' ) + ' ' + ( si + 1 ) ),
								el( 'span', { className: 'epro-tree-actions' },
									el( 'button', { title: '↑', onClick: function () { moveSection( si, -1 ); } }, '↑' ),
									el( 'button', { title: '↓', onClick: function () { moveSection( si, 1 ); } }, '↓' )
								)
							),
							sec.columns.map( function ( col, ci ) {
								return col.widgets.map( function ( w, wi ) {
									var selW = sel && sel.kind === 'widget' && sel.s === si && sel.c === ci && sel.w === wi;
									return el( 'div', { key: w.id, className: 'epro-tree-w' + ( selW ? ' is-sel' : '' ) },
										el( 'span', { className: 'epro-tree-label', onClick: function () { setSel( { kind: 'widget', s: si, c: ci, w: wi } ); } }, ( WIDGETS[ w.type ] ? WIDGETS[ w.type ].icon + ' ' + WIDGETS[ w.type ].label : w.type ) ),
										el( 'span', { className: 'epro-tree-actions' },
											el( 'button', { title: '↑', onClick: function () { moveWidget( si, ci, wi, -1 ); } }, '↑' ),
											el( 'button', { title: '↓', onClick: function () { moveWidget( si, ci, wi, 1 ); } }, '↓' )
										)
									);
								} );
							} )
						);
					} )
				)
			);
		}

		function RightPanel() {
			if ( ! sel ) {
				return el( 'div', { className: 'epro-right' }, el( 'p', { className: 'epro-empty' }, __( 'Tahrirlash uchun element tanlang.', 'epro-builder' ) ) );
			}
			if ( sel.kind === 'section' ) {
				var sec = layout.sections[ sel.s ];
				if ( ! sec ) { return el( 'div', { className: 'epro-right' } ); }
				return el( 'div', { className: 'epro-right' },
					el( 'div', { className: 'epro-right-h' }, __( "Bo'lim sozlamalari", 'epro-builder' ) ),
					SECTION_FIELDS.map( function ( f ) {
						return el( FieldControl, { key: f.key, field: f, settings: sec.settings, onChange: updateSectionSettings } );
					} ),
					el( C.Button, { isDestructive: true, variant: 'secondary', className: 'epro-del', onClick: deleteSel }, __( "Bo'limni o'chirish", 'epro-builder' ) )
				);
			}
			var w = layout.sections[ sel.s ] && layout.sections[ sel.s ].columns[ sel.c ] ? layout.sections[ sel.s ].columns[ sel.c ].widgets[ sel.w ] : null;
			if ( ! w ) { return el( 'div', { className: 'epro-right' } ); }
			var schema = WIDGETS[ w.type ];
			return el( 'div', { className: 'epro-right' },
				el( 'div', { className: 'epro-right-h' }, schema ? schema.label : w.type ),
				schema && schema.fields.length ? schema.fields.map( function ( f ) {
					return el( FieldControl, { key: f.key, field: f, settings: w.settings, onChange: updateWidgetSettings } );
				} ) : el( 'p', { className: 'epro-empty' }, __( "Bu element sozlamasiz.", 'epro-builder' ) ),
				el( C.Button, { isDestructive: true, variant: 'secondary', className: 'epro-del', onClick: deleteSel }, __( "Elementni o'chirish", 'epro-builder' ) )
			);
		}

		if ( loading ) {
			return el( 'div', { className: 'epro-loading' }, el( C.Spinner, null ), el( 'span', null, __( 'Yuklanmoqda…', 'epro-builder' ) ) );
		}

		return el( Fragment, null,
			el( TopBar, null ),
			el( 'div', { className: 'epro-body' },
				el( LeftPanel, null ),
				el( 'div', { className: 'epro-canvas' },
					el( 'div', { className: 'epro-frame-wrap', style: { maxWidth: frameWidth } },
						el( 'iframe', { key: tick, className: 'epro-frame', src: previewSrc, title: 'preview' } )
					),
					el( 'p', { className: 'epro-hint' }, __( "Saqlagandan so'ng oldindan ko'rish yangilanadi. (Jonli kanvas — keyingi bosqichda.)", 'epro-builder' ) )
				),
				el( RightPanel, null )
			)
		);
	}

	/* ----------------------------------------------------------- mount */

	function mount() {
		var node = document.getElementById( 'epro-builder-root' );
		if ( ! node ) { return; }
		if ( wp.element.createRoot ) {
			wp.element.createRoot( node ).render( el( App, null ) );
		} else {
			wp.element.render( el( App, null ), node );
		}
	}

	if ( document.readyState === 'loading' ) {
		document.addEventListener( 'DOMContentLoaded', mount );
	} else {
		mount();
	}

}( window.wp, window.eproBuilder ) );
