(function() {
    tinymce.create('tinymce.plugins.artweb', {
 
        init : function(ed, url){
            ed.addButton('artweb', {
            title : 'Insert Themes Shortcode',
                onclick : function() {

                    var el = ed.selection.getNode(), vp = tinymce.DOM.getViewPort(), H = vp.h, W = ( 660 < vp.w ) ? 660 : vp.w, cls = ed.dom.getAttrib(el, 'class'), selectedContent = ed.selection.getContent();
                    
                    tb_show('Add Shortcode', url + '/shortcode_manager_overlay.php?ver=321&TB_iframe=true');
                    
                    tinymce.DOM.setStyles('TB_window', {
						'width':( W - 50 )+'px',
						'height':'660px',
						'margin-left':'-'+parseInt((( W - 50 ) / 2),10) + 'px'
					});
	
					if ( ! tinymce.isIE6 ) {
						tinymce.DOM.setStyles('TB_window', {
							'top':'20px',
							'marginTop':'0'
						});
					}
	
					tinymce.DOM.setStyles('TB_iframeContent', {
						'width':( W - 50 )+'px',
						'height':'660px'
					});
					//tinymce.DOM.setStyles( ['TB_overlay','TB_window','TB_load'], 'z-index', '999999' );

                },
                image: url + "/shortcode-icon.jpg"
            });
        }
    });
 
    tinymce.PluginManager.add('artweb', tinymce.plugins.artweb);
 
})();