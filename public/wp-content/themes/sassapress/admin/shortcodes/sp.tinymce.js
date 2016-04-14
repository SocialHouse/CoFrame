(function() {
    tinymce.create('tinymce.plugins.sptiny', {
        init : function(ed, url) {
            ed.addCommand('shortcodeGenerator', function() {

                tb_show("Starter Shortcodes", url + '/shortcodes.php?&width=630&height=600');

                
            });
            //Add button
            ed.addButton('spscgenerator', {    title : 'Starter Shortcodes', cmd : 'shortcodeGenerator', image : url + '/shortcode-icon.png' });
        },
        createControl : function(n, cm) {
            return null;
        },
        getInfo : function() {
            return {
                longname : 'SP TinyMCE',
                author : 'Blueshoon',
                authorurl : 'http://www.blueshoon.com',
                infourl : 'http://www.blueshoon.com',
                version : tinymce.majorVersion + "." + tinymce.minorVersion
            };
        }
    });
    tinymce.PluginManager.add('sp_buttons', tinymce.plugins.sptiny);
})();