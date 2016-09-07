/*
 * Ext JS Library 2.1
 * Copyright(c) 2006-2008, Ext JS, LLC.
 * licensing@extjs.com
 * 
 * http://extjs.com/license
 */

Ext.onReady(function() {		
				
		var winWidth = 800;
         var winHeight = 480;

          var xg = xg;
           var fm = Ext.form;
		   
    var myRecord = new Ext.data.Record.create([ 
		{name:'front'},
		{name:'community'},
		{name:'en'},
		{name:'r1'},
		{name:'r2'},
		{name:'r3'},
		{name:'r4'},
		{name:'r5'},
		{name:'r6'},
		{name:'r7'},
		{name:'r8'},
		{name:'r9'},
		{name:'r10'},
		{name:'r11'},
		{name:'cult'},
		{name:'comp'},
		{name:'tpl_path'},
	]);

	var myReader = new Ext.data.JsonReader({
		successProperty: 'success',
		totalProperty: 'results',
		root: 'config',
		id: 'front'
	}, myRecord);	
	
	var fs = new Ext.FormPanel({
		renderTo:'ux-bar',
        labelAlign: 'top',
        bodyStyle:'padding:5px',
		// configure how to read the XML Data
        reader : myReader,
        items: [{
            layout:'column',
            border:false,
            items:[{
                columnWidth:.25,
                layout: 'form',
                border:false,
                items: [{
                    xtype:'combo',
                    fieldLabel: 'Active',
                    name: 'front',
					anchor:'95%',
					store: new Ext.data.SimpleStore({
											fields: ['KeyField', 'DisplayField'],
											data:[[
												1, 'true'
											],[
												0, 'false'
											]]
										}),
										displayField: 'DisplayField',
						                valueField: 'KeyField',
										mode: 'local',
										triggerAction: 'all'
                },{
                    xtype:'combo',
                    fieldLabel: 'File Uploads On',
                    name: 'community',
                    anchor:'95%',
					store: new Ext.data.SimpleStore({
											fields: ['KeyField', 'DisplayField'],
											data:[[
												1, 'true'
											],[
												0, 'false'
											]]
										}),
										displayField: 'DisplayField',
						                valueField: 'KeyField',
										mode: 'local',
										triggerAction: 'all'
                },{
                    xtype:'combo',
                    fieldLabel: 'Company Description',
                    name: 'r1',
					anchor:'95%',
					store: new Ext.data.SimpleStore({
											fields: ['KeyField', 'DisplayField'],
											data:[[
												1, 'true'
											],[
												0, 'false'
											]]
										}),
										displayField: 'DisplayField',
						                valueField: 'KeyField',
										mode: 'local',
										triggerAction: 'all'
                },{
                    xtype:'combo',
                    fieldLabel: 'Culture Description',
                    name: 'r2',
					anchor:'95%',
					store: new Ext.data.SimpleStore({
											fields: ['KeyField', 'DisplayField'],
											data:[[
												1, 'true'
											],[
												0, 'false'
											]]
										}),
										displayField: 'DisplayField',
						                valueField: 'KeyField',
										mode: 'local',
										triggerAction: 'all'
                }]
            },{
                columnWidth:.25,
                layout: 'form',
                border:false,
                items: [{
                    xtype:'combo',
                    fieldLabel: 'Opportunity Description',
                    name: 'r3',
					anchor:'95%',
					store: new Ext.data.SimpleStore({
											fields: ['KeyField', 'DisplayField'],
											data:[[
												1, 'true'
											],[
												0, 'false'
											]]
										}),
										displayField: 'DisplayField',
						                valueField: 'KeyField',
										mode: 'local',
										triggerAction: 'all'
                },{
                    xtype:'combo',
                    fieldLabel: 'Responsibilities',
                    name: 'r4',
                    anchor:'95%',
					store: new Ext.data.SimpleStore({
											fields: ['KeyField', 'DisplayField'],
											data:[[
												1, 'true'
											],[
												0, 'false'
											]]
										}),
										displayField: 'DisplayField',
						                valueField: 'KeyField',
										mode: 'local',
										triggerAction: 'all'
                },{
                    xtype:'combo',
                    fieldLabel: 'Required Knowledge and Skills',
                    name: 'r5',
					anchor:'95%',
					store: new Ext.data.SimpleStore({
											fields: ['KeyField', 'DisplayField'],
											data:[[
												1, 'true'
											],[
												0, 'false'
											]]
										}),
										displayField: 'DisplayField',
						                valueField: 'KeyField',
										mode: 'local',
										triggerAction: 'all'
                },{
                    xtype:'combo',
                    fieldLabel: 'Experience and Education',
                    name: 'r6',
					anchor:'95%',
					store: new Ext.data.SimpleStore({
											fields: ['KeyField', 'DisplayField'],
											data:[[
												1, 'true'
											],[
												0, 'false'
											]]
										}),
										displayField: 'DisplayField',
						                valueField: 'KeyField',
										mode: 'local',
										triggerAction: 'all'
                }]
            },{
                columnWidth:.25,
                layout: 'form',
                border:false,
                items: [{
                    xtype:'combo',
                    fieldLabel: 'Compensation',
                    name: 'r7',
					anchor:'95%',
					store: new Ext.data.SimpleStore({
											fields: ['KeyField', 'DisplayField'],
											data:[[
												1, 'true'
											],[
												0, 'false'
											]]
										}),
										displayField: 'DisplayField',
						                valueField: 'KeyField',
										mode: 'local',
										triggerAction: 'all'
                },{
                    xtype:'combo',
                    fieldLabel: 'Contact',
                    name: 'r8',
					anchor:'95%',
					store: new Ext.data.SimpleStore({
											fields: ['KeyField', 'DisplayField'],
											data:[[
												1, 'true'
											],[
												0, 'false'
											]]
										}),
										displayField: 'DisplayField',
						                valueField: 'KeyField',
										mode: 'local',
										triggerAction: 'all'
                },{
                    xtype:'combo',
                    fieldLabel: 'Profession',
                    name: 'r9',
					anchor:'95%',
					store: new Ext.data.SimpleStore({
											fields: ['KeyField', 'DisplayField'],
											data:[[
												1, 'true'
											],[
												0, 'false'
											]]
										}),
										displayField: 'DisplayField',
						                valueField: 'KeyField',
										mode: 'local',
										triggerAction: 'all'
                },{
                    xtype:'combo',
                    fieldLabel: 'Date posted',
                    name: 'r10',
					anchor:'95%',
					store: new Ext.data.SimpleStore({
											fields: ['KeyField', 'DisplayField'],
											data:[[
												1, 'true'
											],[
												0, 'false'
											]]
										}),
										displayField: 'DisplayField',
						                valueField: 'KeyField',
										mode: 'local',
										triggerAction: 'all'
                }]
            },{
                columnWidth:.25,
                layout: 'form',
                border:false,
                items: [{
                    xtype:'combo',
                    fieldLabel: 'Due Date',
                    name: 'r11',
					anchor:'95%',
					store: new Ext.data.SimpleStore({
											fields: ['KeyField', 'DisplayField'],
											data:[[
												1, 'true'
											],[
												0, 'false'
											]]
										}),
										displayField: 'DisplayField',
						                valueField: 'KeyField',
										mode: 'local',
										triggerAction: 'all'
                },{
                    xtype:'combo',
                    fieldLabel: 'Template',
                    name: 'tpl_path',
					anchor:'95%',
					store: new Ext.data.SimpleStore({
											fields: ['KeyField', 'DisplayField'],
											data:[[
												'default', 'Default'
											],[
												'1st', '1st'
											],[
												'2nd', '2nd'
											],[
												'3rd', '3rd'
											],[
												'4th', '4th'
											],[
												'custom', 'Custom'
											]]
										}),
										displayField: 'DisplayField',
						                valueField: 'KeyField',
										mode: 'local',
										triggerAction: 'all'
                },{
                    xtype:'combo',
                    fieldLabel: 'Email Notices On',
                    name: 'comp',
					anchor:'95%',
					store: new Ext.data.SimpleStore({
											fields: ['KeyField', 'DisplayField'],
											data:[[
												1, 'true'
											],[
												0, 'false'
											]]
										}),
										displayField: 'DisplayField',
						                valueField: 'KeyField',
										mode: 'local',
										triggerAction: 'all'
                },{
                    xtype:'combo',
                    fieldLabel: 'English Language Only',
                    name: 'en',
					anchor:'95%',
					store: new Ext.data.SimpleStore({
											fields: ['KeyField', 'DisplayField'],
											data:[[
												1, 'true'
											],[
												0, 'false'
											]]
										}),
										displayField: 'DisplayField',
						                valueField: 'KeyField',
										mode: 'local',
										triggerAction: 'all'
                }]
            }]
        },{
                    xtype:'combo',
                    fieldLabel: 'Notify Ruleset',
                    name: 'cult',
					anchor:'95%',
					store: new Ext.data.SimpleStore({
											fields: ['KeyField', 'DisplayField'],
											data:[[
												'career', 'career'
											],[
												'company', 'company'
											],[
												'company_and_career', 'company_and_career'
											]]
										}),
										displayField: 'DisplayField',
										valueField: 'KeyField',
										mode: 'local',
										triggerAction: 'all'
                }],

        buttons: [{
            text: 'Save',
			handler: function(){
			fs.getForm().submit({url:'index2.php?option=com_rekry&task=saveconfig', waitMsg:'Saving'});
			}
        },{
            text: 'Cancel',
			handler: function(){
              fs.getForm().load({url:'index2.php?option=com_rekry&task=config', waitMsg:'Loading'});
             }
        }]
    });
	
	
	fs.getForm().load({url:'index2.php?option=com_rekry&task=config', waitMsg:'Loading'});		

});