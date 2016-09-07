/*
 * Ext JS Library 2.1
 * Copyright(c) 2006-2008, Ext JS, LLC.
 * licensing@extjs.com
 * 
 * http://extjs.com/license
 */

/**/
Ext.BLANK_IMAGE_URL = '/components/com_participants/ext/resources/images/default/s.gif';

Ext.grid.RowExpander = function(config){
    Ext.apply(this, config);

    this.addEvents({
        beforeexpand : true,
        expand: true,
        beforecollapse: true,
        collapse: true
    });

    Ext.grid.RowExpander.superclass.constructor.call(this);

    if(this.tpl){
        if(typeof this.tpl == 'string'){
            this.tpl = new Ext.Template(this.tpl);
        }
        this.tpl.compile();
    }

    this.state = {};
    this.bodyContent = {};
};

Ext.extend(Ext.grid.RowExpander, Ext.util.Observable, {
    header: "",
    width: 20,
    sortable: false,
    fixed:true,
    menuDisabled:true,
    dataIndex: '',
    id: 'expander',
    lazyRender : true,
    enableCaching: true,

    getRowClass : function(record, rowIndex, p, ds){
        p.cols = p.cols-1;
        var content = this.bodyContent[record.id];
        if(!content && !this.lazyRender){
            content = this.getBodyContent(record, rowIndex);
        }
        if(content){
            p.body = content;
        }
        return this.state[record.id] ? 'x-grid3-row-expanded' : 'x-grid3-row-collapsed';
    },

    init : function(grid){
        this.grid = grid;

        var view = grid.getView();
        view.getRowClass = this.getRowClass.createDelegate(this);

        view.enableRowBody = true;

        grid.on('render', function(){
            view.mainBody.on('mousedown', this.onMouseDown, this);
        }, this);
    },

    getBodyContent : function(record, index){
        if(!this.enableCaching){
            return this.tpl.apply(record.data);
        }
        var content = this.bodyContent[record.id];
        if(!content){
            content = this.tpl.apply(record.data);
            this.bodyContent[record.id] = content;
        }
        return content;
    },

    onMouseDown : function(e, t){
        if(t.className == 'x-grid3-row-expander'){
            e.stopEvent();
            var row = e.getTarget('.x-grid3-row');
            this.toggleRow(row);
        }
    },

    renderer : function(v, p, record){
        p.cellAttr = 'rowspan="2"';
        return '<div class="x-grid3-row-expander">&#160;</div>';
    },

    beforeExpand : function(record, body, rowIndex){
        if(this.fireEvent('beforeexpand', this, record, body, rowIndex) !== false){
            if(this.tpl && this.lazyRender){
                body.innerHTML = this.getBodyContent(record, rowIndex);
            }
            return true;
        }else{
            return false;
        }
    },

    toggleRow : function(row){
        if(typeof row == 'number'){
            row = this.grid.view.getRow(row);
        }
        this[Ext.fly(row).hasClass('x-grid3-row-collapsed') ? 'expandRow' : 'collapseRow'](row);
    },

    expandRow : function(row){
        if(typeof row == 'number'){
            row = this.grid.view.getRow(row);
        }
        var record = this.grid.store.getAt(row.rowIndex);
        var body = Ext.DomQuery.selectNode('tr:nth(2) div.x-grid3-row-body', row);
        if(this.beforeExpand(record, body, row.rowIndex)){
            this.state[record.id] = true;
            Ext.fly(row).replaceClass('x-grid3-row-collapsed', 'x-grid3-row-expanded');
            this.fireEvent('expand', this, record, body, row.rowIndex);
        }
    },

    collapseRow : function(row){
        if(typeof row == 'number'){
            row = this.grid.view.getRow(row);
        }
        var record = this.grid.store.getAt(row.rowIndex);
        var body = Ext.fly(row).child('tr:nth(1) div.x-grid3-row-body', true);
        if(this.fireEvent('beforcollapse', this, record, body, row.rowIndex) !== false){
            this.state[record.id] = false;
            Ext.fly(row).replaceClass('x-grid3-row-expanded', 'x-grid3-row-collapsed');
            this.fireEvent('collapse', this, record, body, row.rowIndex);
        }
    }
});


Ext.onReady(function() {
		
 var winWidth = 800;
 var winHeight = 600;

 var xg = Ext.grid;
 var fm = Ext.form; 
 
          function handleMoveToInt() {
			
				var selectedRows = APPgrid.selModel.selections.items;
		
				var selectedKeys = APPgrid.selModel.selections.keys; 

				var encoded_keys = Ext.encode(selectedKeys);
			
				Ext.Ajax.request({
				
					waitMsg: 'Moveing rows...'
					, url: "index2.php?option=com_rekry&task=app_int"
					, params: { 
						task: "app_int" 
						, option: "com_rekry"
				    	, deleteKeys: encoded_keys
						, key: 'ap_id'
					}
					, callback: function (options, success, response) {
						if (success) { 
							Ext.MessageBox.alert('OK',response.responseText);
							var json = Ext.util.JSON.decode(response.responseText);
							Ext.MessageBox.alert('OK','Selected records moved.');
						} else {
							Ext.MessageBox.alert('Sorry, please try again. ',response.responseText);
						}
					}
					, failure:function(response,options){
						Ext.MessageBox.alert('Warning','Error...');
					}                                      
					, success:function(response,options){
						reader.reload();
						intreader.reload();
					}
					, scope: this
				});
			};	
			
			
			function handleRemoveToInt() {
			
				var selectedRows = INTgrid.selModel.selections.items;
		
				var selectedKeys = INTgrid.selModel.selections.keys; 

				var encoded_keys = Ext.encode(selectedKeys);
			
				Ext.Ajax.request({
				
					waitMsg: 'Moveing rows...'
					, url: "index2.php?option=com_rekry&task=rem_int"
					, params: { 
						task: "rem_int" 
						, option: "com_rekry"
				    	, deleteKeys: encoded_keys
						, key: 'ap_id'
					}
					, callback: function (options, success, response) {
						if (success) { 
							Ext.MessageBox.alert('OK',response.responseText);
							var json = Ext.util.JSON.decode(response.responseText);
							Ext.MessageBox.alert('OK','Selected records moved.');
						} else {
							Ext.MessageBox.alert('Sorry, please try again. ',response.responseText);
						}
					}
					, failure:function(response,options){
						Ext.MessageBox.alert('Warning','Error...');
					}                                      
					, success:function(response,options){
						reader.reload();
						intreader.reload();
					}
					, scope: this
				});
			};	
			
			function handleDeleteAPP() {
			
				var selectedRows = APPgrid.selModel.selections.items;
		
				var selectedKeys = APPgrid.selModel.selections.keys; 

				var encoded_keys = Ext.encode(selectedKeys);
			
				Ext.Ajax.request({
				
					waitMsg: 'Deleting rows...'
					, url: "index2.php?option=com_rekry&task=del_app"
					, params: { 
						task: "del_app" 
						, option: "com_rekry"
				    	, deleteKeys: encoded_keys
						, key: 'ap_id'
					}
					, callback: function (options, success, response) {
						if (success) { 
							Ext.MessageBox.alert('OK',response.responseText);
							var json = Ext.util.JSON.decode(response.responseText);
							Ext.MessageBox.alert('OK','Selected records deleted.');
						} else {
							Ext.MessageBox.alert('Sorry, please try again. ',response.responseText);
						}
					}
					, failure:function(response,options){
						Ext.MessageBox.alert('Warning','Error...');
					}                                      
					, success:function(response,options){
						reader.reload();
						intreader.reload();
					}
					, scope: this
				});
			};	

    // shared reader

	var reader = new Ext.data.GroupingStore ({
				proxy: new Ext.data.HttpProxy ({ 
					url: 'index2.php?option=com_rekry&task=app'	
					, scope: this
				})
				, baseParams: {
					option: "com_rekry"
					, task: 'app'
					, "limit": 25
				}
				, reader: new Ext.data.JsonReader ({
					root: 'app'
					, totalProperty: 'totalCount'
					, id: 'ap_id'
					, fields: [
					    {name: 'ap_id'},
						{name: 'career_name'},
                        {name: 'career_gsm'},
                        {name: 'career_mail'},
                        {name: 'career_cv'},
                        {name: 'career_cv_link'},
						{name: 'op_name'},
						{name: 'user_id'},
						{name: 'career_keys'},
						{name: 'career_add'},
						{name: 'career_zip'},
						{name: 'career_city'},
						{name: 'career_ph'},
						{name: 'career_bdate'},
						{name: 'career_info'},
						{name: 'career_gender'},
						{name: 'career_edu'},
						{name: 'career_eedu'},
						{name: 'career_exp'},
						{name: 'career_referen'}
						]						
				})
				, sortInfo:{field:'op_name', direction: "ASC"}
                , groupField:'op_name'
			});	
	
	var intreader = new Ext.data.GroupingStore ({
				proxy: new Ext.data.HttpProxy ({ 
					url: 'index2.php?option=com_rekry&task=int'	
					, scope: this
				})
				, baseParams: {
					option: "com_rekry"
					, task: 'int'
					, "limit": 25
				}
				, reader: new Ext.data.JsonReader ({
					root: 'int'
					, totalProperty: 'totalCount'
					, id: 'ap_id'
					, fields: [
					    {name: 'ap_id'},
						{name: 'name'},
                        {name: 'gsm'},
                        {name: 'mail'},
                        {name: 'cv'},
                        {name: 'cv_link'},
						{name: 'op_name'},
						{name: 'user_id'},
						{name: 'keys'},
						{name: 'add'},
						{name: 'zip'},
						{name: 'city'},
						{name: 'ph'},
						{name: 'bdate'},
						{name: 'info'},
						{name: 'gender'},
						{name: 'edu'},
						{name: 'eedu'},
						{name: 'exp'},
						{name: 'referen'},
						{name: 'int_date', type: 'date', dateFormat: 'Y-m-d'},
						{name: 'int_time', type: 'date', dateFormat: 'H:i:s'}
						]						
				})
				, sortInfo:{field:'op_name', direction: "ASC"}
                , groupField:'op_name'
			});	
	
	
	      var expander = new xg.RowExpander({
			  tpl : new Ext.Template(
               '<div style="margin: 0px; padding: 0px;">' 
			   ,'<table width="100%" border="0" cellspacing="0" cellpadding="0" class="appexpander">'
               ,'<tr>'
               ,'<th>Curriculum Vitae</th>'
               ,'<th>Address</th>'
			   ,'<th>Phone</th>'
			   ,'<th>Birthdate</th>'
			   ,'<th>Gender</th>'
               ,'</tr>'
			   ,'<tr>'
               ,'<td>'
			   ,'<a href="index2.php?option='
			   ,'com_rekry&task=loadpdf&filename='
			   ,'{career_cv_link}&usrid={user_id}">'
			   ,'{career_cv}</a>'
			   ,'</td>'
               ,'<td>{career_add}, {career_zip} {career_city}</td>'
			   ,'<td>{career_ph}</td>'
			   ,'<td>{career_bdate}</td>'
			   ,'<td>{career_gender}</td>'
               ,'</tr>'
               ,'</table>'
			   ,'<table width="100%" border="0" cellspacing="0" cellpadding="0" class="appexpander">'
               ,'<tr>'
			   ,'<th>Info</th>'
               ,'<th>Education</th>'
               ,'<th>Extra Courses</th>'
               ,'</tr>'
			   ,'<tr>'
			   ,'<td>{career_info}</td>'
			   ,'<td>{career_edu}</td>'
			   ,'<td>{career_eedu}</td>'
			   ,'</tr>'
               ,'</table>'
			   	,'<table width="100%" border="0" cellspacing="0" cellpadding="0" class="appexpander">'
               ,'<tr>'
			   ,'<th>Expereience</th>'
               ,'<th>References</th>'
			   ,'<th>Keys</th>'
               ,'</tr>'
			   ,'<tr>'
			   ,'<td>{career_exp}</td>'
			   ,'<td>{career_referen}</td>'
			   ,'<td>{career_keys}</td>'
			   ,'</tr>'
               ,'</table>'
			   ,'</div>'
              )
            });			

           var cmAPPGrid = new xg.ColumnModel([
		   	expander,						   
		   new xg.RowNumberer(),
		    {id:'ap_id',
			header: "ID", 
			width: 4, 
			sortable: true, 
			dataIndex: 'ap_id', 
			align: 'right', 
			hidden: true},
            {header: "Fullname", 
			width: 10, 
			sortable: true, 
			dataIndex: 'career_name'
			},{header: "GSM", 
			width: 10, 
			sortable: true, 
			dataIndex: 'career_gsm'
			},{header: "Email", 
			width: 10, 
			sortable: true, 
			dataIndex: 'career_mail'
			},{header: "Keys", 
			width: 10, 
			sortable: true, 
			dataIndex: 'career_keys'
			},{header: "Opportunity", 
			hidden: false,
			width: 20, 
			sortable: true, 
			dataIndex: 'op_name'}
            ]);	
			
			// by default columns are sortable
			cmAPPGrid.defaultSortable = true;

    var APPgrid = new xg.EditorGridPanel({
		plugins:[new Ext.ux.grid.Search({
				iconCls:'icon-zoom'
				,readonlyIndexes:['note']
				,disableIndexes:['career_name', 'career_mail', 'op_name', 'career_gsm', 'ap_id']
				,minChars:3
				,autoFocus:true
//				,menuStyle:'radio'
			}), expander],
        store: reader,
        cm: cmAPPGrid, 
        viewConfig: {
					fitToFrame:true,
					fitContainer:true, 	
                    forceFit:true,
                    autoScroll:true					
		},	
		onContextClick : function(grid, index, e){
        if(!this.menu){ // create context menu on first right click
            this.menu = new Ext.menu.Menu({
                id:'grid-ctx',
                items: [				
				{
                    iconCls: 'refresh-icon',
                    text:'Refresh',
                    scope:this,
                    handler: function(){
                        this.ctxRow = null;
                        reader.reload();
                    }
                }]
            });
            this.menu.on('hide', this.onContextHide, this);
        }
        e.stopEvent();
        if(this.ctxRow){
            Ext.fly(this.ctxRow).removeClass('x-node-ctx');
            this.ctxRow = null;
        }
        this.ctxRow = this.view.getRow(index);
        this.ctxRecord = this.store.getAt(index);
        Ext.fly(this.ctxRow).addClass('x-node-ctx');
        this.menu.showAt(e.getXY());
        }

        , onContextHide : function(){
        if(this.ctxRow){
            Ext.fly(this.ctxRow).removeClass('x-node-ctx');
            this.ctxRow = null;
        }
        },
		id: 'app-grid',
		clicksToEdit: 2,
		selModel: new xg.RowSelectionModel({singleSelect:false}),
        frame:false,		
        collapsible: false,
        animCollapse: false,
		// autoHeight: true,
		height: winHeight-35,
		enableDragDrop: true,
        iconCls: 'icon-grid',	
		bbar: new Ext.PagingToolbar({
			store: reader,
			pageSize: 25,
			displayInfo: 'Topics {0} - {1} of {2}',
			emptyMsg: 'No topics to display'}),
		tbar: [ {
						text: 'Move to interviews'
						, tooltip: 'Select rows to move'
						, iconCls: 'move-icon'
					    , handler: handleMoveToInt
						, scope: this
					}
					, {
						text: 'Delete'
						, iconCls: 'remove'
						, tooltip: 'Select rows to delete'
					    , handler: handleDeleteAPP
						, scope: this
					}
					, {
						text: 'Refresh'
						, tooltip: 'Refresh grid'
						, iconCls: 'refresh-icon'
						, handler: function () {
							reader.reload();
						}
					}],
            view: new xg.GroupingView({
            forceFit:true,
			autoScroll:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Items" : "Item"]})'
        })	
    });	

	APPgrid.addListener('rowcontextmenu', APPgrid.onContextClick);
	reader.load( {params: {"start":0,"limit":25}} );
	
			 var expander = new xg.RowExpander({
			  tpl : new Ext.Template(
               '<div style="margin: 0px; padding: 0px;">' 
			   ,'<table width="100%" border="0" cellspacing="0" cellpadding="0" class="appexpander">'
               ,'<tr>'
               ,'<th>Curriculum Vitae</th>'
               ,'<th>Address</th>'
			   ,'<th>Phone</th>'
			   ,'<th>Birthdate</th>'
			   ,'<th>Gender</th>'
               ,'</tr>'
			   ,'<tr>'
               ,'<td>'
			   ,'<a href="index2.php?option='
			   ,'com_rekry&task=loadpdf&filename='
			   ,'{cv_link}&usrid={cuser_id}">'
			   ,'{cv}</a>'
			   ,'</td>'
               ,'<td>{add}, {zip} {city}</td>'
			   ,'<td>{ph}</td>'
			   ,'<td>{bdate}</td>'
			   ,'<td>{gender}</td>'
               ,'</tr>'
               ,'</table>'
			   ,'<table width="100%" border="0" cellspacing="0" cellpadding="0" class="appexpander">'
               ,'<tr>'
			   ,'<th>Info</th>'
               ,'<th>Education</th>'
               ,'<th>Extra Courses</th>'
               ,'</tr>'
			   ,'<tr>'
			   ,'<td>{info}</td>'
			   ,'<td>{edu}</td>'
			   ,'<td>{eedu}</td>'
			   ,'</tr>'
               ,'</table>'
			   	,'<table width="100%" border="0" cellspacing="0" cellpadding="0" class="appexpander">'
               ,'<tr>'
			   ,'<th>Expereience</th>'
               ,'<th>References</th>'
			   ,'<th>Keys</th>'
               ,'</tr>'
			   ,'<tr>'
			   ,'<td>{exp}</td>'
			   ,'<td>{referen}</td>'
			   ,'<td>{keys}</td>'
			   ,'</tr>'
               ,'</table>'
			   ,'</div>'
              )
            });		
			
			var intAPPGrid = new xg.ColumnModel([
		   expander,
     	   new xg.RowNumberer(),
		    {id:'id',
			header: "ID", 
			width: 4, 
			sortable: true, 
			dataIndex: 'id', 
			align: 'right', 
			hidden: true},
            {header: "Fullname", 
			width: 10, 
			sortable: true, 
			dataIndex: 'name'
			},{header: "GSM", 
			width: 10, 
			sortable: true, 
			dataIndex: 'gsm'
			},{header: "Email", 
			width: 10, 
			sortable: true, 
			dataIndex: 'mail'
			},{header: "Keys", 
			width: 10, 
			sortable: true, 
			dataIndex: 'keys'
			},{header: "Date of Interview", 
			width: 10, 
			sortable: true, 
			dataIndex: 'int_date',
			renderer: Ext.util.Format.dateRenderer('Y-m-d'),
			editor: new fm.DateField({
						format:'Y-m-d'
					})	
			},{header: "Time of Interview", 
			width: 10, 
			sortable: true, 
			dataIndex: 'int_time',
			renderer: Ext.util.Format.dateRenderer('H:i'),
			editor: new fm.TimeField({
						minValue: '08:00',
                        maxValue: '17:00',
                        increment: 30,
						format: 'H:i'
					})	
			},{header: "Opportunity", 
			hidden: false,
			width: 20, 
			sortable: true, 
			dataIndex: 'op_name'}
            ]);	
			
			function saveINTgrid (GridEvent) {
            
				Ext.Ajax.request({
					waitMsg: 'Saving changes...'
					, url: 'index2.php?option=com_rekry&task=edit_int'
					, params: { 
						task: "edit_int"
						, option: 'com_rekry'
						, key: 'ap_id'
						, keyID: GridEvent.record.data.ap_id
						, field: GridEvent.field
						, value: GridEvent.value
						, originalValue: GridEvent.record.modified
						, int_date: GridEvent.record.data.int_date.format('Y-m-d')
					}
					, failure:function(response,options){
						Ext.MessageBox.alert('Warning','Error...');
					}                            
					, success:function(response,options){
						intreader.commitChanges();
						intreader.reload();
					}      
					, scope: this
				});
			};
			
			// by default columns are sortable
			intAPPGrid.defaultSortable = true;
	
	 var INTgrid = new xg.EditorGridPanel({
        plugins: expander,
        store: intreader,
        cm: intAPPGrid, 
        viewConfig: {
					fitToFrame:true,
					fitContainer:true, 	
                    forceFit:true,
                    autoScroll:true					
		},	
		onContextClick : function(grid, index, e){
        if(!this.menu){ // create context menu on first right click
            this.menu = new Ext.menu.Menu({
                id:'grid-ctx',
                items: [				
				{
                    iconCls: 'refresh-icon',
                    text:'Refresh',
                    scope:this,
                    handler: function(){
                        this.ctxRow = null;
                        intreader.reload();
                    }
                }]
            });
            this.menu.on('hide', this.onContextHide, this);
        }
        e.stopEvent();
        if(this.ctxRow){
            Ext.fly(this.ctxRow).removeClass('x-node-ctx');
            this.ctxRow = null;
        }
        this.ctxRow = this.view.getRow(index);
        this.ctxRecord = this.store.getAt(index);
        Ext.fly(this.ctxRow).addClass('x-node-ctx');
        this.menu.showAt(e.getXY());
        }

        , onContextHide : function(){
        if(this.ctxRow){
            Ext.fly(this.ctxRow).removeClass('x-node-ctx');
            this.ctxRow = null;
        }
        },
		id: 'int-grid',
		clicksToEdit: 2,
		selModel: new xg.RowSelectionModel({singleSelect:false}),
        frame:false,		
        collapsible: false,
        animCollapse: false,
		// autoHeight: true,
		height: winHeight-35,
		enableDragDrop: true,
        iconCls: 'icon-grid',
		bbar: new Ext.PagingToolbar({
			store: intreader,
			pageSize: 25,
			displayInfo: 'Topics {0} - {1} of {2}',
			emptyMsg: 'No topics to display'}),
		tbar: [ {
						text: 'Remove from interviews'
						, tooltip: 'Select rows to move'
						, iconCls: 'move-icon'
					    , handler: handleRemoveToInt
						, scope: this
					}
					, {
						text: 'Refresh'
						, tooltip: 'Refresh grid'
						, iconCls: 'refresh-icon'
						, handler: function () {
							intreader.reload();
						}
					}],
            view: new xg.GroupingView({
            forceFit:true,
			autoScroll:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Items" : "Item"]})'
        })	
    });	

	INTgrid.addListener('rowcontextmenu', INTgrid.onContextClick);
	INTgrid.addListener('afteredit', saveINTgrid, this);
	intreader.load({params: {"start":0,"limit":25}});
	
	          var APLreader = new Ext.data.GroupingStore ({
				proxy: new Ext.data.HttpProxy ({ 
					url: 'index2.php?option=com_rekry&task=apl'	
					, scope: this
				})
				, baseParams: {
					option: "com_rekry"
					, task: 'apl'
					, "limit" : 25
				}
				, reader: new Ext.data.JsonReader ({
					root: 'apl'
					, totalProperty: 'totalCount'
					, id: 'id'
					, fields: [
					    {name: 'id'},
						{name: 'career_name'},
                        {name: 'career_gsm'},
                        {name: 'career_email'},
                        {name: 'career_cv'},
                        {name: 'career_cv_link'},
						{name: 'addr'},
						{name: 'user_id'},
						{name: 'lname'},
						{name: 'keys'},
						{name: 'address'},
						{name: 'city'},
						{name: 'zip'},
						{name: 'phone'},
						{name: 'bdate'},
						{name: 'gender'},
						{name: 'exp'},
						{name: 'ext'},
						{name: 'edu'},
						{name: 'ref'},
						{name: 'info'}
						]						
				})
				, sortInfo:{field:'career_name', direction: "ASC"}
                , groupField:'lname'
			});	
	
	
	      expander = new xg.RowExpander({
              tpl : new Ext.Template(
               '<div style="margin: 0px; padding: 0px;">' 
			   ,'<table width="100%" border="0" cellspacing="0" cellpadding="0" class="appexpander">'
               ,'<tr>'
               ,'<th>Curriculum Vitae</th>'
               ,'<th>Address</th>'
			   ,'<th>Phone</th>'
			   ,'<th>Birthdate</th>'
			   ,'<th>Gender</th>'
               ,'</tr>'
			   ,'<tr>'
               ,'<td>'
			   ,'<a href="index2.php?option='
			   ,'com_rekry&task=loadpdf&filename='
			   ,'{career_cv_link}&usrid={user_id}">'
			   ,'{career_cv}</a>'
			   ,'</td>'
               ,'<td>{address}, {zip} {city}</td>'
			   ,'<td>{phone}</td>'
			   ,'<td>{bdate}</td>'
			   ,'<td>{gender}</td>'
               ,'</tr>'
               ,'</table>'
			   ,'<table width="100%" border="0" cellspacing="0" cellpadding="0" class="appexpander">'
               ,'<tr>'
			   ,'<th>Info</th>'
               ,'<th>Education</th>'
               ,'<th>Extra Courses</th>'
               ,'</tr>'
			   ,'<tr>'
			   ,'<td>{info}</td>'
			   ,'<td>{edu}</td>'
			   ,'<td>{ext}</td>'
			   ,'</tr>'
               ,'</table>'
			   	,'<table width="100%" border="0" cellspacing="0" cellpadding="0" class="appexpander">'
               ,'<tr>'
			   ,'<th>Expereience</th>'
               ,'<th>References</th>'
			   ,'<th>Keys</th>'
               ,'</tr>'
			   ,'<tr>'
			   ,'<td>{exp}</td>'
			   ,'<td>{ref}</td>'
			   ,'<td>{keys}</td>'
			   ,'</tr>'
               ,'</table>'
			   ,'</div>'
              )
            });		

           var cmAPLGrid = new xg.ColumnModel([
		   	expander,						   
		   new xg.RowNumberer(),
		    {id:'id',
			header: "ID", 
			width: 4, 
			sortable: true, 
			dataIndex: 'id', 
			align: 'right', 
			hidden: true},
            {header: "Fullname", 
			width: 10, 
			sortable: true, 
			dataIndex: 'career_name'
			},{header: "GSM", 
			width: 10, 
			sortable: true, 
			dataIndex: 'career_gsm'
			},{header: "Email", 
			width: 10, 
			sortable: true, 
			dataIndex: 'career_email'
			},{header: "Keys", 
			width: 10, 
			sortable: true, 
			dataIndex: 'keys'
			},{header: "Lastname", 
			hidden: true,
			width: 20, 
			sortable: true, 
			dataIndex: 'lname'}
            ]);	
			
			// by default columns are sortable
			cmAPLGrid.defaultSortable = true;

   var APLgrid = new xg.EditorGridPanel({
		plugins:[new Ext.ux.grid.Search({
				iconCls:'icon-zoom'
				,readonlyIndexes:['note']
				,disableIndexes:['career_name', 'career_mail', 'lname', 'career_gsm', 'id']
				,minChars:3
				,autoFocus:true
//				,menuStyle:'radio'
			}), expander],	
        store: APLreader,
        cm: cmAPLGrid, 
        viewConfig: {
					fitToFrame:true,
					fitContainer:true, 	
                    forceFit:true,
                    autoScroll:true					
		},	
		onContextClick : function(grid, index, e){
        if(!this.menu){ // create context menu on first right click
            this.menu = new Ext.menu.Menu({
                id:'grid-ctx',
                items: [				
				{
                    iconCls: 'refresh-icon',
                    text:'Refresh',
                    scope:this,
                    handler: function(){
                        this.ctxRow = null;
                        APLreader.reload();
                    }
                }]
            });
            this.menu.on('hide', this.onContextHide, this);
        }
        e.stopEvent();
        if(this.ctxRow){
            Ext.fly(this.ctxRow).removeClass('x-node-ctx');
            this.ctxRow = null;
        }
        this.ctxRow = this.view.getRow(index);
        this.ctxRecord = this.store.getAt(index);
        Ext.fly(this.ctxRow).addClass('x-node-ctx');
        this.menu.showAt(e.getXY());
        }

        , onContextHide : function(){
        if(this.ctxRow){
            Ext.fly(this.ctxRow).removeClass('x-node-ctx');
            this.ctxRow = null;
        }
        },
		id: 'apl-grid',
		clicksToEdit: 2,
		selModel: new xg.RowSelectionModel({singleSelect:false}),
        frame:false,		
        collapsible: false,
        animCollapse: false,
		// autoHeight: true,
		height: winHeight-35,
		enableDragDrop: true,
        iconCls: 'icon-grid',
		bbar: new Ext.PagingToolbar({
			store: APLreader,
			pageSize: 25,
			displayInfo: 'Topics {0} - {1} of {2}',
			emptyMsg: 'No topics to display'}),
		tbar: [ {
						text: 'Refresh'
						, tooltip: 'Refresh grid'
						, iconCls: 'refresh-icon'
						, handler: function () {
							APLreader.reload();
						}
					}],
            view: new xg.GroupingView({
            forceFit:true,
			autoScroll:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Items" : "Item"]})'
        })	
    });	

	APLgrid.addListener('rowcontextmenu', APLgrid.onContextClick);
	APLreader.load({params: {"start":0,"limit":25}});
		
var tabs = new Ext.TabPanel({
renderTo:'ux-bar',
title:'Applications',
height: winHeight,
activeTab:0,
layoutOnTabChange: true,
items: [{
title: 'Applications',
header:false,
items: APPgrid,
border:false
},{
title: 'Applicants',
header:false,
items: APLgrid,
border:false
},{
title: 'Interviews',
header:false,
items : INTgrid,
border:false
}]
});

});