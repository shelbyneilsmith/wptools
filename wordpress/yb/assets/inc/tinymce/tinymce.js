/*-----------------------------------------------------------------------------------*/
/*  Add TinyMCE Div Button
/*-----------------------------------------------------------------------------------*/
(function() {
    tinymce.create('tinymce.plugins.div', {
        init : function(ed, url) {
            ed.addButton('div', {
                title : 'Add Div w/ Class',
                image : url+'/description.png',
                onclick : function() {
                     ed.selection.setContent('[div class=""]Your Content...[/div]');

                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('div', tinymce.plugins.div);
})();

/*-----------------------------------------------------------------------------------*/
/*  Add TinyMCE Section Button
/*-----------------------------------------------------------------------------------*/
(function() {
    tinymce.create('tinymce.plugins.section', {
        init : function(ed, url) {
            ed.addButton('section', {
                title : 'Add Section',
                image : url+'/section.png',
                onclick : function() {
                     ed.selection.setContent('[section class="" bgcolor="" bgimage="" parallax="false" padding="30px 0" border=""]Your Content[/section]');

                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('section', tinymce.plugins.section);
})();

/*-----------------------------------------------------------------------------------*/
/*  Add TinyMCE Box Button
/*-----------------------------------------------------------------------------------*/
(function() {
    tinymce.create('tinymce.plugins.box', {
        init : function(ed, url) {
            ed.addButton('box', {
                title : 'Add Box Field',
                image : url+'/description.png',
                onclick : function() {
                     ed.selection.setContent('[box style="1 or 2" class=""]Your Content...[/box]');

                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('box', tinymce.plugins.box);
})();

/*-----------------------------------------------------------------------------------*/
/*  Add TinyMCE Placeholder Image Button
/*-----------------------------------------------------------------------------------*/
(function() {
    tinymce.create('tinymce.plugins.placeholder_img', {
        init : function(ed, url) {
            ed.addButton('placeholder_img', {
                title : 'Add Placeholder Image',
                image : url+'/gallery.png',
                onclick : function() {
                     ed.selection.setContent('[placeholder_img width="width" height="height" float="none"]');

                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('placeholder_img', tinymce.plugins.placeholder_img);
})();

/*-----------------------------------------------------------------------------------*/
/*	Add TinyMCE Accordion Button
/*-----------------------------------------------------------------------------------*/
(function() {
    tinymce.create('tinymce.plugins.accordion', {
        init : function(ed, url) {
            ed.addButton('accordion', {
                title : 'Add Accordion',
                image : url+'/accordion.png',
                onclick : function() {
                     ed.selection.setContent('[accordion open="2"]<br />[accordion-item title="First Tab Title"]Your Text[/accordion-item]<br />[accordion-item title="Second Tab Title"]Your Text[/accordion-item]<br />[accordion-item title="Third Tab Title"]Your Text[/accordion-item]<br />[/accordion]');

                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('accordion', tinymce.plugins.accordion);
})();

/*-----------------------------------------------------------------------------------*/
/*	Add TinyMCE Button
/*-----------------------------------------------------------------------------------*/
(function() {
    tinymce.create('tinymce.plugins.yb_button', {
        init : function(ed, url) {
            ed.addButton('yb_button', {
                title : 'Add a Button',
                image : url+'/button.png',
                onclick : function() {
                     ed.selection.setContent('[yb_button link="http://www.google.de" size="small, medium, large" target="_blank or _self" icon="cog" type="gradient or flat" altcolor="true or false" lightbox="true or false"]Button[/yb_button]');
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('yb_button', tinymce.plugins.yb_button);
})();

/*-----------------------------------------------------------------------------------*/
/*	Add TinyMCE Video Button
/*-----------------------------------------------------------------------------------*/
(function() {
    tinymce.create('tinymce.plugins.video', {
        init : function(ed, url) {
            ed.addButton('video', {
                title : 'Add Video',
                image : url+'/video.png',
                onclick : function() {
                     ed.selection.setContent('[embedvideo type="youtube, vimeo, dailymotion" id="Enter video ID (eg. 8F7UOBIT4Vk)"]');

                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('video', tinymce.plugins.video);
})();

/*-----------------------------------------------------------------------------------*/
/*	Add TinyMCE Gap Button
/*-----------------------------------------------------------------------------------*/
(function() {
    tinymce.create('tinymce.plugins.gap', {
        init : function(ed, url) {
            ed.addButton('gap', {
                title : 'Add Gap',
                image : url+'/gap.png',
                onclick : function() {
                     ed.selection.setContent('[gap height="30"]');

                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('gap', tinymce.plugins.gap);
})();

/*-----------------------------------------------------------------------------------*/
/*	Add TinyMCE SocialMedia Button
/*-----------------------------------------------------------------------------------*/
(function() {
    tinymce.create('tinymce.plugins.socialmedia', {
        init : function(ed, url) {
            ed.addButton('socialmedia', {
                title : 'Add Social Media Icon',
                image : url+'/socialmedia.png',
                onclick : function() {
                     ed.selection.setContent('[social icon="facebook" url="http://facebook.com"]');

                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('socialmedia', tinymce.plugins.socialmedia);
})();

/*-----------------------------------------------------------------------------------*/
/*	Add TinyMCE Tabs Button
/*-----------------------------------------------------------------------------------*/
(function() {
    tinymce.create('tinymce.plugins.tabs', {
        init : function(ed, url) {
            ed.addButton('tabs', {
                title : 'Add Tabs',
                image : url+'/tabs.png',
                onclick : function() {
                     ed.selection.setContent('[tabgroup]<br />[tab title="Tab 1"]Tab 1 content goes here.[/tab]<br />[tab title="Tab 2" icon="file"]Tab 2 content goes here.[/tab]<br />[tab icon="file"]Tab 3 content goes here.[/tab]<br />[/tabgroup]');

                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('tabs', tinymce.plugins.tabs);
})();

/*-----------------------------------------------------------------------------------*/
/*	Add TinyMCE Toggle Button
/*-----------------------------------------------------------------------------------*/
(function() {
    tinymce.create('tinymce.plugins.toggle', {
        init : function(ed, url) {
            ed.addButton('toggle', {
                title : 'Add Toggle',
                image : url+'/toggle.png',
                onclick : function() {
                     ed.selection.setContent('[toggle title="Toggle Title" open="true or false" icon="star"]Your Content goes here...[/toggle]');

                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('toggle', tinymce.plugins.toggle);
})();

/*-----------------------------------------------------------------------------------*/
/*	Add TinyMCE 1/2 Button
/*-----------------------------------------------------------------------------------*/
(function() {
    tinymce.create('tinymce.plugins.one_half', {
        init : function(ed, url) {
            ed.addButton('one_half', {
                title : 'Add 1/2 Columns',
                image : url+'/one_half.png',
                onclick : function() {
                     ed.selection.setContent('[one_half]Content here.[/one_half] [one_half_last]Content here.[/one_half_last]');

                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('one_half', tinymce.plugins.one_half);
})();

/*-----------------------------------------------------------------------------------*/
/*	Add TinyMCE 1/3 Button
/*-----------------------------------------------------------------------------------*/
(function() {
    tinymce.create('tinymce.plugins.one_third', {
        init : function(ed, url) {
            ed.addButton('one_third', {
                title : 'Add 1/3 Columns',
                image : url+'/one_third.png',
                onclick : function() {
                     ed.selection.setContent('[one_third]Content here.[/one_third] [one_third]Content here.[/one_third] [one_third_last]Content here.[/one_third_last]');

                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('one_third', tinymce.plugins.one_third);
})();

/*-----------------------------------------------------------------------------------*/
/*	Add TinyMCE 2/3 Button
/*-----------------------------------------------------------------------------------*/
(function() {
    tinymce.create('tinymce.plugins.two_third', {
        init : function(ed, url) {
            ed.addButton('two_third', {
                title : 'Add 2/3 Columns',
                image : url+'/two_third.png',
                onclick : function() {
                     ed.selection.setContent('[two_third]Content here.[/two_third] [one_third_last]Content here.[/one_third_last]');

                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('two_third', tinymce.plugins.two_third);
})();

/*-----------------------------------------------------------------------------------*/
/*	Add TinyMCE 1/4 Button
/*-----------------------------------------------------------------------------------*/
(function() {
    tinymce.create('tinymce.plugins.one_fourth', {
        init : function(ed, url) {
            ed.addButton('one_fourth', {
                title : 'Add 1/4 Columns',
                image : url+'/one_fourth.png',
                onclick : function() {
                     ed.selection.setContent('[one_fourth]Content here.[/one_fourth] [one_fourth]Content here.[/one_fourth] [one_fourth]Content here.[/one_fourth] [one_fourth_last]Content here.[/one_fourth_last]');

                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('one_fourth', tinymce.plugins.one_fourth);
})();

/*-----------------------------------------------------------------------------------*/
/*	Add TinyMCE 3/4 Button
/*-----------------------------------------------------------------------------------*/
(function() {
    tinymce.create('tinymce.plugins.three_fourth', {
        init : function(ed, url) {
            ed.addButton('three_fourth', {
                title : 'Add 3/4 Columns',
                image : url+'/three_fourth.png',
                onclick : function() {
                     ed.selection.setContent('[three_fourth]Content here.[/three_fourth][one_fourth_last]Content here.[/one_fourth_last]');

                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('three_fourth', tinymce.plugins.three_fourth);
})();
