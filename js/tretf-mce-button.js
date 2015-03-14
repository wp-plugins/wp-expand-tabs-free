(function() {
	tinymce.PluginManager.add('tretf_mce_button', function( editor, url ) {
		editor.addButton( 'tretf_mce_button', {
			text: 'Expand tab Shortcodes',
			icon: false,
			type: 'menubutton',
			menu: [
				{
					text: 'Tabs form shortcode',
					onclick: function() {
						editor.insertContent('[tr_tabs][ir_item id="1" title="Tab title"]Tab item content ...[/ir_item] [ir_item id="2" title="Tab title"]Tab item content ...[/ir_item] [ir_item id="3" title="Tab title"]Tab item content ...[/ir_item][/tr_tabs]');
					}
				},
				{
					text: 'Tabs form custom post',
                    onclick: function() {
                        editor.windowManager.open( {
                            title: 'Insert Random Shortcode',
                            body: [
                                {
                                    type: 'textbox',
                                    name: 'textboxID',
                                    label: 'ID',
                                    value: '1'
                                },
                                {
                                    type: 'textbox',
                                    name: 'textboxItems',
                                    label: 'Items',
                                    value: '3'
                                },
                                {
                                    type: 'textbox',
                                    name: 'textboxCategory',
                                    label: 'Type category name',
                                    value: ''
                                },
                                {
                                    type: 'textbox',
                                    name: 'textboxBackground',
                                    label: 'Background color code',
                                    value: '#46B3E6'
                                },
                                {
                                    type: 'textbox',
                                    name: 'textboxborder',
                                    label: 'Border color code',
                                    value: '#46B3E6'
                                },
                                {
                                    type: 'listbox',
                                    name: 'listboxEffect',
                                    label: 'Effect',
                                    'values': [
                                        {text: 'Scale', value: 'scale'},
                                        {text: 'Slide left', value: 'slideleft'},
                                        {text: 'Slide right', value: 'slideright'},
                                        {text: 'Slide top', value: 'slidetop'},
                                        {text: 'Slide down', value: 'slidedown'}
                                    ]
                                }
                            ],
                            onsubmit: function( e ) {
                                editor.insertContent( '[tabs id="' + e.data.textboxID + '" items="' + e.data.textboxItems + '" category="' + e.data.textboxCategory + '" background="' + e.data.textboxBackground + '" border="' + e.data.textboxborder + '" effect="' + e.data.listboxEffect + '"]');
                            }
                        });
                    }
				}
			]
		});
	});
})();