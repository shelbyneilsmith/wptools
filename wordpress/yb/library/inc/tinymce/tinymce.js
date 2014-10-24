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
                     ed.selection.setContent('[placeholder_img width="width" height="height"]');

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
/*	Add TinyMCE Alert Button
/*-----------------------------------------------------------------------------------*/
(function() {
    tinymce.create('tinymce.plugins.alert', {
        init : function(ed, url) {
            ed.addButton('alert', {
                title : 'Add a Alert',
                image : url+'/alert.png',
                onclick : function() {
                     ed.selection.setContent('[alert type="notice, warning, success, error, info" close="true"]Your Message[/alert]');
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('alert', tinymce.plugins.alert);
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
/*	Add TinyMCE Divider Button
/*-----------------------------------------------------------------------------------*/
(function() {
    tinymce.create('tinymce.plugins.divider', {
        init : function(ed, url) {
            ed.addButton('divider', {
                title : 'Add Divider',
                image : url+'/divider.png',
                onclick : function() {
                     ed.selection.setContent('[hr margin="30px 0px 30px 0px"]');

                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('divider', tinymce.plugins.divider);
})();

/*-----------------------------------------------------------------------------------*/
/*	Add TinyMCE Dropcap
/*-----------------------------------------------------------------------------------*/
(function() {
    tinymce.create('tinymce.plugins.dropcap', {
        init : function(ed, url) {
            ed.addButton('dropcap', {
                title : 'Add Dropcap',
                image : url+'/dropcap.png',
                onclick : function() {
                     ed.selection.setContent('[dropcap style="default, circle, box, book"]R[/dropcap]');

                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('dropcap', tinymce.plugins.dropcap);
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
/*	Add TinyMCE Maps Button
/*-----------------------------------------------------------------------------------*/
(function() {
    tinymce.create('tinymce.plugins.maps', {
        init : function(ed, url) {
            ed.addButton('maps', {
                title : 'Add Google Maps',
                image : url+'/maps.png',
                onclick : function() {
                     ed.selection.setContent('[map w="600" h="400" style="full, standard" z="16" marker="yes" infowindow="Hello World!" infowindowdefault="yes or no" maptype="SATELLITE, HYBRID, TERRAIN" hidecontrols="true or false" address="New York"]');

                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('maps', tinymce.plugins.maps);
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
/*	Add TinyMCE Maps Button
/*-----------------------------------------------------------------------------------*/
(function() {
    tinymce.create('tinymce.plugins.clear', {
        init : function(ed, url) {
            ed.addButton('clear', {
                title : 'Add Clear',
                image : url+'/clear.png',
                onclick : function() {
                     ed.selection.setContent('[clear]');

                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('clear', tinymce.plugins.clear);
})();

/*-----------------------------------------------------------------------------------*/
/*	Add TinyMCE Icon Button
/*-----------------------------------------------------------------------------------*/
(function() {
    tinymce.create('tinymce.plugins.icon', {
        init : function(ed, url) {
            ed.addButton('icon', {
                title : 'Add Icon',
                image : url+'/icon.png',
                onclick : function() {
                     ed.selection.setContent('[icon icon="cash"]');

                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('icon', tinymce.plugins.icon);
})();

/*-----------------------------------------------------------------------------------*/
/*	Add TinyMCE Miniicon Button
/*-----------------------------------------------------------------------------------*/
(function() {
    tinymce.create('tinymce.plugins.miniicon', {
        init : function(ed, url) {
            ed.addButton('miniicon', {
                title : 'Add Mini-Icon',
                image : url+'/miniicon.png',
                onclick : function() {
                     ed.selection.setContent('[mini-icon icon="leaf"]');

                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('miniicon', tinymce.plugins.miniicon);
})();

/*-----------------------------------------------------------------------------------*/
/*	Add TinyMCE Iconbox Button
/*-----------------------------------------------------------------------------------*/
(function() {
    tinymce.create('tinymce.plugins.iconbox', {
        init : function(ed, url) {
            ed.addButton('iconbox', {
                title : 'Add Iconbox',
                image : url+'/iconbox.png',
                onclick : function() {
                     ed.selection.setContent('[iconbox icon="music" title="This is awesome!"]Your Content here...[/iconbox]');

                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('iconbox', tinymce.plugins.iconbox);
})();

/*-----------------------------------------------------------------------------------*/
/*	Add TinyMCE RetinaIcon Button
/*-----------------------------------------------------------------------------------*/
(function() {
    tinymce.create('tinymce.plugins.retinaicon', {
        init : function(ed, url) {
            ed.addButton('retinaicon', {
                title : 'Add Retina Icon',
                image : url+'/retinaicon.png',
                onclick : function() {
                     ed.selection.setContent('[retinaicon icon="beaker" size="small, medium, large" circle="true or false" color="#999999" background="#efefef" align="center"]');

                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('retinaicon', tinymce.plugins.retinaicon);
})();

/*-----------------------------------------------------------------------------------*/
/*	Add TinyMCE RetinaIconbox Button
/*-----------------------------------------------------------------------------------*/
(function() {
    tinymce.create('tinymce.plugins.retinaiconbox', {
        init : function(ed, url) {
            ed.addButton('retinaiconbox', {
                title : 'Add Retina Iconbox',
                image : url+'/retinaiconbox.png',
                onclick : function() {
                     ed.selection.setContent('[retinaiconbox icon="beaker" circle="true or false" color="#289dcc" background="#efefef" title="Incredibly Flexible"]Your Content here...[/retinaiconbox]');

                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('retinaiconbox', tinymce.plugins.retinaiconbox);
})();

/*-----------------------------------------------------------------------------------*/
/*	Add TinyMCE List Button
/*-----------------------------------------------------------------------------------*/
(function() {
    tinymce.create('tinymce.plugins.list', {
        init : function(ed, url) {
            ed.addButton('list', {
                title : 'Add List',
                image : url+'/list.png',
                onclick : function() {
                     ed.selection.setContent('[list]<br />[list_item icon="glass"]glass[/list_item]<br />[list_item icon="music"]music[/list_item]<br />[list_item icon="search"]search[/list_item]<br />[list_item icon="envelope"]envelope[/list_item]<br />[/list]');

                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('list', tinymce.plugins.list);
})();

/*-----------------------------------------------------------------------------------*/
/*	Add TinyMCE Member Button
/*-----------------------------------------------------------------------------------*/
(function() {
    tinymce.create('tinymce.plugins.member', {
        init : function(ed, url) {
            ed.addButton('member', {
                title : 'Add Member',
                image : url+'/member.png',
                onclick : function() {
                     ed.selection.setContent('[member name="John Doe" role="Web Developer" url="http://example.com" img="http://ybthemes.com/nopic.png" twitter="http://twitter.com" facebook="http://facebook.com" skype="http://skype.com" googleplus="http://google.de" linkedin="http://linkedin.com" mail="helloyb@gmail.com"]Description[/member]');

                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('member', tinymce.plugins.member);
})();

/*-----------------------------------------------------------------------------------*/
/*	Add TinyMCE Skill Button
/*-----------------------------------------------------------------------------------*/
(function() {
    tinymce.create('tinymce.plugins.skill', {
        init : function(ed, url) {
            ed.addButton('skill', {
                title : 'Add Skillbar',
                image : url+'/skill.png',
                onclick : function() {
                     ed.selection.setContent('[skill percentage="90" title="Photoshop & Illustrator 90%"]');

                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('skill', tinymce.plugins.skill);
})();

/*-----------------------------------------------------------------------------------*/
/*	Add TinyMCE Pricing Table Button
/*-----------------------------------------------------------------------------------*/
(function() {
    tinymce.create('tinymce.plugins.pricing', {
        init : function(ed, url) {
            ed.addButton('pricing', {
                title : 'Add Pricing Table',
                image : url+'/pricing.png',
                onclick : function() {
                     ed.selection.setContent('[pricing-table col="2"]<br />[plan name="Starter Edition" link="http://www.google.de" linkname="Sign Up" price="19$" per="per year" featured="Best Price"]<ul><li>Item 1</li></ul>[/plan]<br />[plan name="Starter Edition" link="http://www.google.de" linkname="Sign Up" price="49$" per="per month"]<ul><li>Item 1</li></ul>[/plan]<br />[/pricing-table]');

                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('pricing', tinymce.plugins.pricing);
})();

/*-----------------------------------------------------------------------------------*/
/*	Add TinyMCE Pullquote Button
/*-----------------------------------------------------------------------------------*/
(function() {
    tinymce.create('tinymce.plugins.pullquote', {
        init : function(ed, url) {
            ed.addButton('pullquote', {
                title : 'Add Pullquote',
                image : url+'/pullquote.png',
                onclick : function() {
                     ed.selection.setContent('[pullquote align="left or right"]Quote goes here...[/pullquote]');

                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('pullquote', tinymce.plugins.pullquote);
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
/*	Add TinyMCE Table Button
/*-----------------------------------------------------------------------------------*/
(function() {
    tinymce.create('tinymce.plugins.table', {
        init : function(ed, url) {
            ed.addButton('table', {
                title : 'Add Styled Table',
                image : url+'/table.png',
                onclick : function() {
                     ed.selection.setContent('[custom_table style="1,2 or 3"]Insert Table here[/custom_table]');

                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('table', tinymce.plugins.table);
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

/*-----------------------------------------------------------------------------------*/
/*	Add TinyMCE 1/5 Button
/*-----------------------------------------------------------------------------------*/
(function() {
    tinymce.create('tinymce.plugins.one_fifth', {
        init : function(ed, url) {
            ed.addButton('one_fifth', {
                title : 'Add 1/5 Columns',
                image : url+'/one_fifth.png',
                onclick : function() {
                     ed.selection.setContent('[one_fifth]Content here.[/one_fifth] [one_fifth]Content here.[/one_fifth] [one_fifth]Content here.[/one_fifth] [one_fifth]Content here.[/one_fifth] [one_fifth_last]Content here.[/one_fifth_last]');

                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('one_fifth', tinymce.plugins.one_fifth);
})();

/*-----------------------------------------------------------------------------------*/
/*	Add TinyMCE Projects Button
/*-----------------------------------------------------------------------------------*/
// (function() {
//     tinymce.create('tinymce.plugins.projects', {
//         init : function(ed, url) {
//             ed.addButton('projects', {
//                 title : 'Add Latest Projects',
//                 image : url+'/projects.png',
//                 onclick : function() {
//                      ed.selection.setContent('[portfolio projects="4" title="Latest Projects" show_title="yes or no" columns="2,3 or 4" filters="Portfolo Category slugs or all"]');

//                 }
//             });
//         },
//         createControl : function(n, cm) {
//             return null;
//         },
//     });
//     tinymce.PluginManager.add('projects', tinymce.plugins.projects);
// })();

/*-----------------------------------------------------------------------------------*/
/*	Add TinyMCE Blog Button
/*-----------------------------------------------------------------------------------*/
(function() {
    tinymce.create('tinymce.plugins.blog', {
        init : function(ed, url) {
            ed.addButton('blog', {
                title : 'Add Blog',
                image : url+'/blog.png',
                onclick : function() {
                     ed.selection.setContent('[blog posts="4" title="Latest Posts" show_title="yes or no" categories="Category slugs or all"]');

                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('blog', tinymce.plugins.blog);
})();

/*-----------------------------------------------------------------------------------*/
/*	Add TinyMCE Bloglist Button
/*-----------------------------------------------------------------------------------*/
(function() {
    tinymce.create('tinymce.plugins.bloglist', {
        init : function(ed, url) {
            ed.addButton('bloglist', {
                title : 'Add Bloglist',
                image : url+'/bloglist.png',
                onclick : function() {
                     ed.selection.setContent('[bloglist posts="2" title="Latest Posts" show_title="yes or no" categories="Category slugs or all"]');

                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('bloglist', tinymce.plugins.bloglist);
})();

/*-----------------------------------------------------------------------------------*/
/*	Add TinyMCE Testimonial Button
/*-----------------------------------------------------------------------------------*/
(function() {
    tinymce.create('tinymce.plugins.testimonial', {
        init : function(ed, url) {
            ed.addButton('testimonial', {
                title : 'Add Testimonial',
                image : url+'/testimonial.png',
                onclick : function() {
                     ed.selection.setContent('[testimonial author="John Doe, Company Inc."]Your Text...[/testimonial]');

                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('testimonial', tinymce.plugins.testimonial);
})();