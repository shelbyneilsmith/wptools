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
                     ed.selection.setContent('<p>[div class=""]</p><p>Content Here</p><p>[/div]</p>');
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
                     ed.selection.setContent('<p>[section class="" bgcolor="" bgimage="" parallax="false" padding="30px 0" border=""]</p><p>Content here</p><p>[/section]</p>');
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
                     ed.selection.setContent('<p>[box style="1 or 2" class=""]</p><p>Content Here</p><p>[/box]</p>');

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
                     ed.selection.setContent('[placeholder_img width="600" height="400" float="none"]');
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
/*  Add TinyMCE Accordion Button
/*-----------------------------------------------------------------------------------*/
(function() {
    tinymce.create('tinymce.plugins.accordion', {
        init : function(ed, url) {
            ed.addButton('accordion', {
                title : 'Add Accordion',
                image : url+'/accordion.png',
                onclick : function() {
                     ed.selection.setContent('<p>[accordion open="2"]</p><p>[accordion-item title="First Tab Title"]</p><p>Content here</p><p>[/accordion-item]</p><p>[accordion-item title="Second Tab Title"]</p><p>Content here</p><p>[/accordion-item]</p><p>[accordion-item title="Third Tab Title"]</p><p>Content here</p><p>[/accordion-item]</p><p>[/accordion]</p>');
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
/*  Add TinyMCE Button
/*-----------------------------------------------------------------------------------*/
(function() {
    tinymce.create('tinymce.plugins.yb_button', {
        init : function(ed, url) {
            ed.addButton('yb_button', {
                title : 'Add a Button',
                image : url+'/button.png',
                onclick : function() {
                     ed.selection.setContent('[yb_button link="http://www.google.de" size="small, medium, large" target="_self" icon="" type="flat" altcolor="false" lightbox="false"]Button[/yb_button]');
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
/*  Add TinyMCE Video Button
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
/*  Add TinyMCE Gap Button
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
/*  Add TinyMCE SocialMedia Button
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
/*  Add TinyMCE Tabs Button
/*-----------------------------------------------------------------------------------*/
(function() {
    tinymce.create('tinymce.plugins.tabs', {
        init : function(ed, url) {
            ed.addButton('tabs', {
                title : 'Add Tabs',
                image : url+'/tabs.png',
                onclick : function() {
                     ed.selection.setContent('<p>[tabgroup]</p><p>[tab title="Tab 1"]</p><p>Tab 1 Content Here</p><p>[/tab]</p><p>[tab title="Tab 2" icon="file"]</p><p>Tab 2 Content Here</p><p>[/tab]</p><p>[tab icon="file"]</p><p>Tab 3 Content Here</p><p>[/tab]</p><p>[/tabgroup]</p>');
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
/*  Add TinyMCE Toggle Button
/*-----------------------------------------------------------------------------------*/
(function() {
    tinymce.create('tinymce.plugins.toggle', {
        init : function(ed, url) {
            ed.addButton('toggle', {
                title : 'Add Toggle',
                image : url+'/toggle.png',
                onclick : function() {
                     ed.selection.setContent('<p>[toggle title="Toggle Title" open="false" icon=""]</p><p>Content Here</p><p>[/toggle]</p>');
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
/*  Add TinyMCE 1/2 Button
/*-----------------------------------------------------------------------------------*/
(function() {
    tinymce.create('tinymce.plugins.one_half', {
        init : function(ed, url) {
            ed.addButton('one_half', {
                title : 'Add 1/2 Columns',
                image : url+'/one_half.png',
                onclick : function() {
                     ed.selection.setContent('<p>[one_half]</p><p>Left Column</p><p>[/one_half]</p><p>[one_half_last]</p><p>Right Column</p><p>[/one_half_last]</p>');

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
/*  Add TinyMCE 1/3 Button
/*-----------------------------------------------------------------------------------*/
(function() {
    tinymce.create('tinymce.plugins.one_third', {
        init : function(ed, url) {
            ed.addButton('one_third', {
                title : 'Add 1/3 Columns',
                image : url+'/one_third.png',
                onclick : function() {
                     ed.selection.setContent('<p>[one_third]</p><p>Left Column</p><p>[/one_third]</p><p>[one_third]</p><p>Middle Column</p><p>[/one_third]</p><p>[one_third_last]</p><p>Right Column</p><p>[/one_third_last]</p>');

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
/*  Add TinyMCE 2/3 Button
/*-----------------------------------------------------------------------------------*/
(function() {
    tinymce.create('tinymce.plugins.two_third', {
        init : function(ed, url) {
            ed.addButton('two_third', {
                title : 'Add 2/3 Columns',
                image : url+'/two_third.png',
                onclick : function() {
                     ed.selection.setContent('<p>[two_third]</p><p>Left Column</p><p>[/two_third]</p><p>[one_third_last]</p><p>Right Column</p><p>[/one_third_last]</p>');

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
/*  Add TinyMCE 1/4 Button
/*-----------------------------------------------------------------------------------*/
(function() {
    tinymce.create('tinymce.plugins.one_fourth', {
        init : function(ed, url) {
            ed.addButton('one_fourth', {
                title : 'Add 1/4 Columns',
                image : url+'/one_fourth.png',
                onclick : function() {
                     ed.selection.setContent('<p>[one_fourth]</p><p>Left Outer Column</p><p>[/one_fourth]</p><p>[one_fourth]</p><p>Left Inner Column</p><p>[/one_fourth]</p><p>[one_fourth]</p><p>Right Inner Column</p><p>[/one_fourth]</p><p>[one_fourth_last]</p><p>Right Outer Column</p><p>[/one_fourth_last]</p>');

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
/*  Add TinyMCE 3/4 Button
/*-----------------------------------------------------------------------------------*/
(function() {
    tinymce.create('tinymce.plugins.three_fourth', {
        init : function(ed, url) {
            ed.addButton('three_fourth', {
                title : 'Add 3/4 Columns',
                image : url+'/three_fourth.png',
                onclick : function() {
                     ed.selection.setContent('<p>[three_fourth]</p><p>Left Column</p><p>[/three_fourth]</p><p>[one_fourth_last]</p><p>Right Column</p><p>[/one_fourth_last]</p>');
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('three_fourth', tinymce.plugins.three_fourth);
})();
