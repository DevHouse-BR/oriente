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

        //var desktop = this.app.getDesktop();
        //var win = desktop.getWindow('grid-win');
		
 var winWidth = 800;
 var winHeight = 600;

 var xg = Ext.grid;
 var fm = Ext.form;
 
         function saveOPPgrid (GridEvent) {
            
				Ext.Ajax.request({
					waitMsg: 'Saving changes...'
					, url: 'index2.php?option=com_rekry&task=edit_opp'
					, params: { 
						task: "edit_opp"
						, option: 'com_rekry'
						, key: 'op_id'
						, keyID: GridEvent.record.data.op_id
						, field: GridEvent.field
						, value: GridEvent.value
						, originalValue: GridEvent.record.modified
						, start_date: GridEvent.record.data.op_start.format('Y-m-d')
						, end_date: GridEvent.record.data.op_end.format('Y-m-d')
					}
					, failure:function(response,options){
						Ext.MessageBox.alert('Warning','Error...');
					}                            
					, success:function(response,options){
						reader.commitChanges();
						reader.reload();
					}      
					, scope: this
				});
			};
			
			function saveARRgrid (GridEvent) {
            
				Ext.Ajax.request({
					waitMsg: 'Saving changes...'
					, url: 'index2.php?option=com_rekry&task=edit_opp'
					, params: { 
						task: "edit_opp"
						, option: 'com_rekry'
						, key: 'op_id'
						, keyID: GridEvent.record.data.op_id
						, field: GridEvent.field
						, value: GridEvent.value
						, originalValue: GridEvent.record.modified
					}
					, failure:function(response,options){
						Ext.MessageBox.alert('Warning','Error...');
					}                            
					, success:function(response,options){
						arrreader.commitChanges();
						arrreader.reload();
					}      
					, scope: this
				});
			};
			
			function savePROgrid (GridEvent) {
            
				Ext.Ajax.request({
					waitMsg: 'Saving changes...'
					, url: 'index2.php?option=com_rekry&task=edit_pro'
					, params: { 
						task: "edit_pro"
						, option: 'com_rekry'
						, key: 'id'
						, keyID: GridEvent.record.data.id
						, field: GridEvent.field
						, value: GridEvent.value
						, originalValue: GridEvent.record.modified
					}
					, failure:function(response,options){
						Ext.MessageBox.alert('Warning','Error...');
					}                            
					, success:function(response,options){
						storeProf.reload();
						storeProfA.reload();
						store.commitChanges();
						arrreader.reload();	
	                    reader.reload();
					}      
					, scope: this
				});
			};
			
			
			 function handleNewOpp () {
            
				Ext.Ajax.request({
					waitMsg: 'Saving changes...'
					, url: 'index2.php?option=com_rekry&task=new_opp'
					, params: { 
						task: "new_opp"
						, option: 'com_rekry'
					}
					, failure:function(response,options){
						Ext.MessageBox.alert('Warning','Error...');
					}                            
					, success:function(response,options){
						reader.reload();
					}      
					, scope: this
				});
			};
			
		 function handleNewPro () {
            
				Ext.Ajax.request({
					waitMsg: 'Saving changes...'
					, url: 'index2.php?option=com_rekry&task=new_pro'
					, params: { 
						task: "new_pro"
						, option: 'com_rekry'
					}
					, failure:function(response,options){
						Ext.MessageBox.alert('Warning','Error...');
					}                            
					, success:function(response,options){
						storeProf.reload();
						storeProfA.reload();
						store.reload();
						arrreader.reload();	
	                    reader.reload();
					}      
					, scope: this
				});
			};
			
			function handleNoDate (id) {
            
				Ext.Ajax.request({
					waitMsg: 'Saving changes...'
					, url: 'index2.php?option=com_rekry&task=no_date'
					, params: { 
						task: "no_date"
						, option: 'com_rekry'
						, id: id
					}
					, failure:function(response,options){
						Ext.MessageBox.alert('Warning','Error...');
					}                            
					, success:function(response,options){
						Ext.MessageBox.alert('Cell Action Executed','Closing Date removed on record ID: <b>'+ id +'</b>');
						storeProf.reload();
						storeProfA.reload();
						store.reload();
						arrreader.reload();	
	                    reader.reload();
					}      
					, scope: this
				});
			};
			
		function handleMoveToOppOpp() {
			
				var selectedRows = ARRgrid.selModel.selections.items;
		
				var selectedKeys = ARRgrid.selModel.selections.keys; 

				var encoded_keys = Ext.encode(selectedKeys);
			
				Ext.Ajax.request({
				
					waitMsg: 'Moveing rows...'
					, url: "index2.php?option=com_rekry&task=opp_opp"
					, params: { 
						task: "opp_opp" 
						, option: "com_rekry"
				    	, deleteKeys: encoded_keys
						, key: 'op_id'
					}
					, callback: function (options, success, response) {
						if (success) { 
							Ext.MessageBox.alert('OK',response.responseText);
							var json = Ext.util.JSON.decode(response.responseText);
							Ext.MessageBox.alert('OK','Selected record moved.');
						} else {
							Ext.MessageBox.alert('Sorry, please try again. ',response.responseText);
						}
					}
					, failure:function(response,options){
						Ext.MessageBox.alert('Warning','Error...');
					}                                      
					, success:function(response,options){
						reader.reload();
						arrreader.reload();
					}
					, scope: this
				});
			};	
		
		function handleMoveToArcOpp() {
			
				var selectedRows = OPPgrid.selModel.selections.items;
		
				var selectedKeys = OPPgrid.selModel.selections.keys; 

				var encoded_keys = Ext.encode(selectedKeys);
			
				Ext.Ajax.request({
				
					waitMsg: 'Moveing rows...'
					, url: "index2.php?option=com_rekry&task=arr_opp"
					, params: { 
						task: "arr_opp" 
						, option: "com_rekry"
				    	, deleteKeys: encoded_keys
						, key: 'op_id'
					}
					, callback: function (options, success, response) {
						if (success) { 
							Ext.MessageBox.alert('OK',response.responseText);
							var json = Ext.util.JSON.decode(response.responseText);
							Ext.MessageBox.alert('OK','Selected record moved.');
						} else {
							Ext.MessageBox.alert('Sorry, please try again. ',response.responseText);
						}
					}
					, failure:function(response,options){
						Ext.MessageBox.alert('Warning','Error...');
					}                                      
					, success:function(response,options){
						reader.reload();
						arrreader.reload();
					}
					, scope: this
				});
			};	
		
		function handleDeleteOpp() {
			
				var selectedRows = OPPgrid.selModel.selections.items;
		
				var selectedKeys = OPPgrid.selModel.selections.keys; 

				var encoded_keys = Ext.encode(selectedKeys);
			
				Ext.Ajax.request({
				
					waitMsg: 'Deleting rows...'
					, url: "index2.php?option=com_rekry&task=del_opp"
					, params: { 
						task: "del_opp" 
						, option: "com_rekry"
				    	, deleteKeys: encoded_keys
						, key: 'op_id'
					}
					, callback: function (options, success, response) {
						if (success) { 
							Ext.MessageBox.alert('OK',response.responseText);
							var json = Ext.util.JSON.decode(response.responseText);
							Ext.MessageBox.alert('OK','Selected record deleted.');
						} else {
							Ext.MessageBox.alert('Sorry, please try again. ',response.responseText);
						}
					}
					, failure:function(response,options){
						Ext.MessageBox.alert('Warning','Error...');
					}                                      
					, success:function(response,options){
						reader.reload();
					}
					, scope: this
				});
			};	
			
			function handleDeleteArr() {
			
				var selectedRows = ARRgrid.selModel.selections.items;
		
				var selectedKeys = ARRgrid.selModel.selections.keys; 

				var encoded_keys = Ext.encode(selectedKeys);
			
				Ext.Ajax.request({
				
					waitMsg: 'Deleting rows...'
					, url: "index2.php?option=com_rekry&task=del_opp"
					, params: { 
						task: "del_opp" 
						, option: "com_rekry"
				    	, deleteKeys: encoded_keys
						, key: 'op_id'
					}
					, callback: function (options, success, response) {
						if (success) { 
							Ext.MessageBox.alert('OK',response.responseText);
							var json = Ext.util.JSON.decode(response.responseText);
							Ext.MessageBox.alert('OK','Selected record deleted.');
						} else {
							Ext.MessageBox.alert('Sorry, please try again. ',response.responseText);
						}
					}
					, failure:function(response,options){
						Ext.MessageBox.alert('Warning','Error...');
					}                                      
					, success:function(response,options){
						arrreader.reload();
					}
					, scope: this
				});
			};	
			
			
			function handleDeletePro() {
			
				var selectedRows = PROgrid.selModel.selections.items;
		
				var selectedKeys = PROgrid.selModel.selections.keys; 

				var encoded_keys = Ext.encode(selectedKeys);
			
				Ext.Ajax.request({
				
					waitMsg: 'Deleting rows...'
					, url: "index2.php?option=com_rekry&task=del_pro"
					, params: { 
						task: "del_pro" 
						, option: "com_rekry"
				    	, deleteKeys: encoded_keys
						, key: 'id'
					}
					, callback: function (options, success, response) {
						if (success) { 
							Ext.MessageBox.alert('OK',response.responseText);
							var json = Ext.util.JSON.decode(response.responseText);
							Ext.MessageBox.alert('OK','Selected record deleted.');
						} else {
							Ext.MessageBox.alert('Sorry, please try again. ',response.responseText);
						}
					}
					, failure:function(response,options){
						Ext.MessageBox.alert('Warning','Error...');
					}                                      
					, success:function(response,options){
						storeProf.reload();
						storeProfA.reload();
						store.reload();
						arrreader.reload();	
	                    reader.reload();
						
					}
					, scope: this
				});
			};	
			
			function handlePublishOpp() {
			
				var selectedRows = OPPgrid.selModel.selections.items;
		
				var selectedKeys = OPPgrid.selModel.selections.keys; 

				var encoded_keys = Ext.encode(selectedKeys);
			
				Ext.Ajax.request({
				
					waitMsg: 'Deleting rows...'
					, url: "index2.php?option=com_rekry&task=pub_opp"
					, params: { 
						task: "pub_opp" 
						, option: "com_rekry"
				    	, deleteKeys: encoded_keys
						, key: 'op_id'
					}
					, callback: function (options, success, response) {
						if (success) { 
							Ext.MessageBox.alert('OK',response.responseText);
							var json = Ext.util.JSON.decode(response.responseText);
							Ext.MessageBox.alert('OK','Selected record published.');
						} else {
							Ext.MessageBox.alert('Sorry, please try again. ',response.responseText);
						}
					}
					, failure:function(response,options){
						Ext.MessageBox.alert('Warning','Error...');
					}                                      
					, success:function(response,options){
						reader.reload();
					}
					, scope: this
				});
			};	
			
				function handleUnpublishOpp() {
			
				var selectedRows = OPPgrid.selModel.selections.items;
		
				var selectedKeys = OPPgrid.selModel.selections.keys; 

				var encoded_keys = Ext.encode(selectedKeys);
			
				Ext.Ajax.request({
				
					waitMsg: 'Deleting rows...'
					, url: "index2.php?option=com_rekry&task=unpub_opp"
					, params: { 
						task: "unpub_opp" 
						, option: "com_rekry"
				    	, deleteKeys: encoded_keys
						, key: 'op_id'
					}
					, callback: function (options, success, response) {
						if (success) { 
							Ext.MessageBox.alert('OK',response.responseText);
							var json = Ext.util.JSON.decode(response.responseText);
							Ext.MessageBox.alert('OK','Selected record unpublished.');
						} else {
							Ext.MessageBox.alert('Sorry, please try again. ',response.responseText);
						}
					}
					, failure:function(response,options){
						Ext.MessageBox.alert('Warning','Error...');
					}                                      
					, success:function(response,options){
						reader.reload();
					}
					, scope: this
				});
			};	
			
			function handleLockOpp() {
			
				var selectedRows = OPPgrid.selModel.selections.items;
		
				var selectedKeys = OPPgrid.selModel.selections.keys; 

				var encoded_keys = Ext.encode(selectedKeys);
			
				Ext.Ajax.request({
				
					waitMsg: 'Deleting rows...'
					, url: "index2.php?option=com_rekry&task=lock_opp"
					, params: { 
						task: "lock_opp" 
						, option: "com_rekry"
				    	, deleteKeys: encoded_keys
						, key: 'op_id'
					}
					, callback: function (options, success, response) {
						if (success) { 
							Ext.MessageBox.alert('OK',response.responseText);
							var json = Ext.util.JSON.decode(response.responseText);
							Ext.MessageBox.alert('OK','Selected record locked.');
						} else {
							Ext.MessageBox.alert('Sorry, please try again. ',response.responseText);
						}
					}
					, failure:function(response,options){
						Ext.MessageBox.alert('Warning','Error...');
					}                                      
					, success:function(response,options){
						reader.reload();
					}
					, scope: this
				});
			};	
			
				function handleUnlockOpp() {
			
				var selectedRows = OPPgrid.selModel.selections.items;
		
				var selectedKeys = OPPgrid.selModel.selections.keys; 

				var encoded_keys = Ext.encode(selectedKeys);
			
				Ext.Ajax.request({
				
					waitMsg: 'Deleting rows...'
					, url: "index2.php?option=com_rekry&task=unlock_opp"
					, params: { 
						task: "unlock_opp" 
						, option: "com_rekry"
				    	, deleteKeys: encoded_keys
						, key: 'op_id'
					}
					, callback: function (options, success, response) {
						if (success) { 
							Ext.MessageBox.alert('OK',response.responseText);
							var json = Ext.util.JSON.decode(response.responseText);
							Ext.MessageBox.alert('OK','Selected record unlocked.');
						} else {
							Ext.MessageBox.alert('Sorry, please try again. ',response.responseText);
						}
					}
					, failure:function(response,options){
						Ext.MessageBox.alert('Warning','Error...');
					}                                      
					, success:function(response,options){
						reader.reload();
					}
					, scope: this
				});
			};	
			
			function handleLockArr() {
			
				var selectedRows = ARRgrid.selModel.selections.items;
		
				var selectedKeys = ARRgrid.selModel.selections.keys; 

				var encoded_keys = Ext.encode(selectedKeys);
			
				Ext.Ajax.request({
				
					waitMsg: 'Deleting rows...'
					, url: "index2.php?option=com_rekry&task=lock_opp"
					, params: { 
						task: "lock_opp" 
						, option: "com_rekry"
				    	, deleteKeys: encoded_keys
						, key: 'op_id'
					}
					, callback: function (options, success, response) {
						if (success) { 
							Ext.MessageBox.alert('OK',response.responseText);
							var json = Ext.util.JSON.decode(response.responseText);
							Ext.MessageBox.alert('OK','Selected record locked.');
						} else {
							Ext.MessageBox.alert('Sorry, please try again. ',response.responseText);
						}
					}
					, failure:function(response,options){
						Ext.MessageBox.alert('Warning','Error...');
					}                                      
					, success:function(response,options){
						arrreader.reload();
					}
					, scope: this
				});
			};	
			
				function handleUnlockArr() {
			
				var selectedRows = ARRgrid.selModel.selections.items;
		
				var selectedKeys = ARRgrid.selModel.selections.keys; 

				var encoded_keys = Ext.encode(selectedKeys);
			
				Ext.Ajax.request({
				
					waitMsg: 'Deleting rows...'
					, url: "index2.php?option=com_rekry&task=unlock_opp"
					, params: { 
						task: "unlock_opp" 
						, option: "com_rekry"
				    	, deleteKeys: encoded_keys
						, key: 'op_id'
					}
					, callback: function (options, success, response) {
						if (success) { 
							Ext.MessageBox.alert('OK',response.responseText);
							var json = Ext.util.JSON.decode(response.responseText);
							Ext.MessageBox.alert('OK','Selected record unlocked.');
						} else {
							Ext.MessageBox.alert('Sorry, please try again. ',response.responseText);
						}
					}
					, failure:function(response,options){
						Ext.MessageBox.alert('Warning','Error...');
					}                                      
					, success:function(response,options){
						arrreader.reload();
					}
					, scope: this
				});
			};	


    // shared reader

	var reader = new Ext.data.GroupingStore ({
				proxy: new Ext.data.HttpProxy ({ 
					url: 'index2.php?option=com_rekry&task=opp'	
					, scope: this
				})
				, baseParams: {
					option: "com_rekry"
					, task: 'opp'
					, "limit": 25
				}
				, reader: new Ext.data.JsonReader ({
					root: 'opp'
					, totalProperty: 'totalCount'
					, id: 'op_id'
					, fields: [
					    {name: 'op_id'},
						{name: 'op_name'},
                        {name: 'applicants'},
                        {name: 'op_start', type: 'date', dateFormat: 'Y-m-d'},
                        {name: 'op_end', type: 'date', dateFormat: 'Y-m-d'},
                        {name: 'op_company'},
						{name: 'op_desc'},
						{name: 'opportunity'},
                        {name:'edit'},
                        {name:'active'},	
                        {name:'company'},
                        {name:'culture'},
                        {name:'responsibilities'},
                        {name:'required_knowledge_and_skills'},	
                        {name:'required_experience'},
                        {name:'compensation'},	
                        {name:'contact'}						
						]						
				})
				, sortInfo:{field:'op_name', direction: "ASC"}
                , groupField:'op_company'
			});	

           var expander = new xg.RowExpander({
              tpl : new Ext.Template(
               '<div style="padding:10px;"><b>Short Description:</b><br /><br />{op_desc}<br /><br />',
               '<b>Long Description:</b><br /><br />{opportunity}<br /><br />',
			   '<b>Company Description:</b><br /><br />{company}<br /><br />',
			   '<b>Company Culture Description:</b><br />{culture}<br /><br />',
			   '<b>Responsibilities:</b><br /><br />{responsibilities}<br /><br />',
			   '<b>Required Knowledge and Skills:</b><br /><br />{required_knowledge_and_skills}<br /><br />',
			   '<b>Required Experience:</b><br /><br />{required_experience}<br /><br />',
			   '<b>Compensation:</b><br /><br />{compensation}<br /><br />',
			   '<b>Contact:</b><br /><br />{contact}</div>'
              )
            });	
		   
		   var storeProf = new Ext.data.Store ({
				proxy: new Ext.data.HttpProxy ({ 
					url: 'index2.php?option=com_rekry&task=prof',
					scope: this
				})
				, baseParams: {
					task: "prof"
				}
				, reader: new Ext.data.JsonReader ({
					root: 'prof_root'
					, id: 'KeyField'
					, fields: [
						{name: 'KeyField'}
						, {name: 'DisplayField'}
					]
				})
			});
			storeProf.loadData;
			storeProf.load();
			
			
			var storeProfA = new Ext.data.Store ({
				proxy: new Ext.data.HttpProxy ({ 
					url: 'index2.php?option=com_rekry&task=prof',
					scope: this
				})
				, baseParams: {
					task: "prof"
				}
				, reader: new Ext.data.JsonReader ({
					root: 'prof_root'
					, id: 'KeyField'
					, fields: [
						{name: 'KeyField'}
						, {name: 'DisplayField'}
					]
				})
			});
			storeProfA.loadData;
			storeProfA.load();
			
 this.cellActions = new Ext.ux.grid.CellActions({
 listeners:{
 action:function(grid, record, action, value) {
 //Ext.ux.Toast.msg('Event: action', 'You have clicked: <b>{0}</b>, action: <b>{1}</b>', value, action);
 //Ext.MessageBox.alert('Event: action','You have clicked: <b>'+ record.id +'</b>, action: <b>'+ action +'</b>');
 handleNoDate(record.id); 
 }
 ,beforeaction:function() {
 //Ext.ux.Toast.msg('Event: beforeaction', 'You can cancel the action by returning false from this event handler.');
 }
 }
 ,callbacks:{
 'icon-undo':function(grid, record, action, value) {
 //Ext.ux.Toast.msg('Callback: icon-undo', 'You have clicked: <b>{0}</b>, action: <b>{1}</b>', value, action);
 }
 }
 ,align:'left'
 });

           var cmOPPGrid = new xg.ColumnModel([
		   expander, 
		   new xg.RowNumberer(),
		    {id:'op_id',
			header: "ID", 
			width: 10, 
			sortable: true, 
			dataIndex: 'op_id', 
			align: 'right', 
			hidden: true},
            {header: "Title", 
			width: 220, 
			sortable: true, 
			dataIndex: 'op_name',
			editor: new fm.TextField({
						allowBlank: false
					})
					},
			{header: "# Applicants", 
			width: 80, 
			sortable: true, 
			dataIndex: 'applicants'},
            {header: "Date Created", 
			width: 80, 
			sortable: true, 
			dataIndex: 'op_start', 
			renderer: Ext.util.Format.dateRenderer('Y-m-d'),
			editor: new fm.DateField({
						format:'Y-m-d'
					}),	
					},            
            {header: "Closing Date", 
			width: 80, 
			sortable: true, 
			cellActions:[{
iconCls:'lock-icon'
,qtip:'Mark to no closing date'
,hide:true
,hideMode:'display'
}],
			renderer: Ext.util.Format.dateRenderer('Y-m-d'),
			editor: new fm.DateField({
						format:'Y-m-d'
					}),			
			dataIndex: 'op_end'},
			{	
					header: 'Public'
					, dataIndex: 'active'
					, width: 80
					, editor: new Ext.form.ComboBox({									    
										store: new Ext.data.SimpleStore({
											fields: ['value'],
											data:[[
												'true'
											],[
												'false'
											]]
										}),
										displayField: 'value',
										mode: 'local',
										triggerAction: 'all'										
									})
				},
			{	
					header: 'Locked'
					, dataIndex: 'edit'
					, width: 80
					, editor: new Ext.form.ComboBox({									    
										store: new Ext.data.SimpleStore({
											fields: ['value'],
											data:[[
												'true'
											],[
												'false'
											]]
										}),
										displayField: 'value',
										mode: 'local',
										triggerAction: 'all'										
									})
				},
				{header: "Profession", 
			hidden: false,
			width: 150, 
			sortable: true, 
			dataIndex: 'op_company',
			editor: new Ext.form.ComboBox({									    
										store: storeProf,
										displayField: 'DisplayField',
						                valueField: 'KeyField',
										typeAhead: false,
										lazyRender: true,
										triggerAction: 'all'										
									})
					, renderer: function(data) {
						record = storeProf.getById(data);
						if(record) {
							return record.data.DisplayField;
						} else {
							return '( missing )';
						}
					}
				}
        ]);	
			
			// by default columns are sortable
			cmOPPGrid.defaultSortable = true;

    var OPPgrid = new xg.EditorGridPanel({
        store: reader,
        cm: cmOPPGrid, 
        viewConfig: {
			        fitToFrame:true,
					fitContainer:true, 	
                    forceFit:true,
                    autoScroll:true					
		},	
        plugins:[expander, this.cellActions],		
		onContextClick : function(grid, index, e){
        if(!this.menu){ // create context menu on first right click
            this.menu = new Ext.menu.Menu({
                id:'grid-ctx',
                items: [				
				{
                    text: 'Edit selected in new Tab',
                    iconCls: 'new-tab',
                    scope:this,
                    handler: function(){
                        winTab.openTab(this.ctxRecord);
                    }
                },{
                    text: 'Dublicate to new tab',
                    iconCls: 'copy-tab',
                    scope:this,
                    handler: function(){
                        winTab.openDubTab(this.ctxRecord);
                    }
                },{
                    text: 'Add new',
                    iconCls: 'new-opp',
                    scope:this,
                    handler: handleNewOpp
                },'-',{
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
		id: 'opp-grid',
		clicksToEdit: 2,
		selModel: new xg.RowSelectionModel({singleSelect:false}),
        frame:false,		
        collapsible: false,
        animCollapse: false,
		autoWidth: true,
		height:winHeight-35,
		enableDragDrop: true,
        iconCls: 'icon-grid',
		bbar: new Ext.PagingToolbar({
			store: reader,
			pageSize: 25,
			displayInfo: 'Topics {0} - {1} of {2}',
			emptyMsg: 'No topics to display'}),
	    // stripeRows: true,
		tbar: [{
						text: 'New'
						, iconCls: 'add'
						, tooltip: 'Add new'
						, handler: handleNewOpp
						, scope: this
					}, {
						text: 'Publish'
						, tooltip: 'Publish rows from delete'
						, iconCls: 'lock-icon'
					    , handler: handlePublishOpp
						, scope: this
					},{
						text: 'Unpublish'
						, tooltip: 'Unpublish rows from delete'
						, iconCls: 'unlock-icon'
					    , handler: handleUnpublishOpp
						, scope: this
					}
					, {
						text: 'Lock'
						, tooltip: 'Lock rows from delete'
						, iconCls: 'lock-icon'
					    , handler: handleLockOpp
						, scope: this
					},{
						text: 'Unlock'
						, tooltip: 'Unlock rows from delete'
						, iconCls: 'unlock-icon'
					    , handler: handleUnlockOpp
						, scope: this
					}
					, {
						text: 'Move to archives'
						, tooltip: 'Select rows to move'
						, iconCls: 'move-icon'
					    , handler: handleMoveToArcOpp
						, scope: this
					}
					, {
						text: 'Delete'
						, iconCls: 'remove'
						, tooltip: 'Select rows to delete'
					    , handler: handleDeleteOpp
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
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Items" : "Item"]})'
        })	
    });		

	OPPgrid.addListener('afteredit', saveOPPgrid, this);
	OPPgrid.addListener('rowcontextmenu', OPPgrid.onContextClick);
	reader.load({params: {"start":0,"limit":25}});
	
	   // shared reader

	var arrreader = new Ext.data.GroupingStore ({
				proxy: new Ext.data.HttpProxy ({ 
					url: 'index2.php?option=com_rekry&task=arr'	
					, scope: this
				})
				, baseParams: {
					option: "com_rekry"
					, task: 'arr'
					, "limit": 25
				}
				, reader: new Ext.data.JsonReader ({
					root: 'opp'
					, totalProperty: 'totalCount'
					, id: 'op_id'
					, fields: [
					    {name: 'op_id'},
						{name: 'op_name'},
                        {name: 'applicants'},
                        {name: 'op_start', type: 'date', dateFormat: 'Y-m-d'},
                        {name: 'op_end', type: 'date', dateFormat: 'Y-m-d'},
                        {name: 'op_company'},
						{name: 'op_desc'},
						{name: 'opportunity'},
                        {name:'edit'},
                        {name:'active'},	
                        {name:'company'},
                        {name:'culture'},
                        {name:'responsibilities'},
                        {name:'required_knowledge_and_skills'},	
                        {name:'required_experience'},
                        {name:'compensation'},	
                        {name:'contact'}						
						]						
				})
				, sortInfo:{field:'op_name', direction: "ASC"}
                , groupField:'op_company'
			});	

           var expander = new xg.RowExpander({
              tpl : new Ext.Template(
               '<div style="padding:10px;"><b>Short Description:</b><br /><br />{op_desc}<br /><br />',
               '<b>Long Description:</b><br /><br />{opportunity}<br /><br />',
			   '<b>Company Description:</b><br /><br />{company}<br /><br />',
			   '<b>Company Culture Description:</b><br />{culture}<br /><br />',
			   '<b>Responsibilities:</b><br /><br />{responsibilities}<br /><br />',
			   '<b>Required Knowledge and Skills:</b><br /><br />{required_knowledge_and_skills}<br /><br />',
			   '<b>Required Experience:</b><br /><br />{required_experience}<br /><br />',
			   '<b>Compensation:</b><br /><br />{compensation}<br /><br />',
			   '<b>Contact:</b><br /><br />{contact}</div>'
              )
            });			

           var cmARRGrid = new xg.ColumnModel([
		   expander, 
		   new xg.RowNumberer(),
		    {id:'op_id',
			header: "ID", 
			width: 10, 
			sortable: true, 
			dataIndex: 'op_id', 
			align: 'right', 
			hidden: true},
            {header: "Title", 
			width: 200, 
			sortable: true, 
			dataIndex: 'op_name',
			editor: new fm.TextField({
						allowBlank: false
					})
					},
			{header: "# Applicants", 
			width: 80, 
			sortable: true, 
			dataIndex: 'applicants'},
            {header: "Date Created", 
			width: 80, 
			sortable: true, 
			dataIndex: 'op_start', 
			renderer: Ext.util.Format.dateRenderer('Y-m-d'),
			editor: new fm.DateField({
						format:'Y-m-d'
					}),	
					},            
            {header: "Closing Date", 
			width: 80, 
			sortable: true, 
			renderer: Ext.util.Format.dateRenderer('Y-m-d'),
			editor: new fm.DateField({
						format:'Y-m-d'
					}),			
			dataIndex: 'op_end'},
			{	
					header: 'Public'
					, dataIndex: 'active'
					, width: 80
					, editor: new Ext.form.ComboBox({									    
										store: new Ext.data.SimpleStore({
											fields: ['value'],
											data:[[
												'true'
											],[
												'false'
											]]
										}),
										displayField: 'value',
										mode: 'local',
										triggerAction: 'all'										
									})
				},
			{	
					header: 'Locked'
					, dataIndex: 'edit'
					, width: 80
					, editor: new Ext.form.ComboBox({									    
										store: new Ext.data.SimpleStore({
											fields: ['value'],
											data:[[
												'true'
											],[
												'false'
											]]
										}),
										displayField: 'value',
										mode: 'local',
										triggerAction: 'all'										
									})
				},
				{header: "Profession", 
			hidden: false,
			width: 150, 
			sortable: true, 
			dataIndex: 'op_company',
			editor: new Ext.form.ComboBox({									    
										store: storeProfA,
										displayField: 'DisplayField',
						                valueField: 'KeyField',
										typeAhead: false,
										lazyRender: true,
										triggerAction: 'all'										
									})
					, renderer: function(data) {
						record = storeProfA.getById(data);
						if(record) {
							return record.data.DisplayField;
						} else {
							return '( missing )';
						}
					}
				}
        ]);	
			
			// by default columns are sortable
			cmARRGrid.defaultSortable = true;

    var ARRgrid = new xg.EditorGridPanel({
        store: arrreader,
        cm: cmARRGrid, 
        viewConfig: {
                    forceFit:true,
                    autoScroll:true					
		},	
        plugins: expander,		
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
                        arrreader.reload();
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
		id: 'arr-grid',
		clicksToEdit: 2,
		selModel: new xg.RowSelectionModel({singleSelect:false}),
        frame:false,		
        collapsible: false,
        animCollapse: false,
		// autoHeight: true,
		height:winHeight-35,
		enableDragDrop: true,
        iconCls: 'icon-grid',
		bbar: new Ext.PagingToolbar({
			store: arrreader,
			pageSize: 25,
			displayInfo: 'Topics {0} - {1} of {2}',
			emptyMsg: 'No topics to display'}),
	    stripeRows: true,
		tbar: [{
						text: 'Lock'
						, tooltip: 'Lock rows from delete'
						, iconCls: 'lock-icon'
					    , handler: handleLockArr
						, scope: this
					},{
						text: 'Unlock'
						, tooltip: 'Unlock rows from delete'
						, iconCls: 'unlock-icon'
					    , handler: handleUnlockArr
						, scope: this
					}
					, {
						text: 'Move to opportunities'
						, tooltip: 'Select rows to move'
						, iconCls: 'move-icon'
					    , handler: handleMoveToOppOpp
						, scope: this
					}
					, {
						text: 'Delete'
						, iconCls: 'remove'
						, tooltip: 'Select rows to delete'
					    , handler: handleDeleteArr
						, scope: this
					}
					, {
						text: 'Refresh'
						, tooltip: 'Refresh grid'
						, iconCls: 'refresh-icon'
						, handler: function () {
							arrreader.reload();
						}
					}],
            view: new xg.GroupingView({
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Items" : "Item"]})'
        })	
    });		

	ARRgrid.addListener('afteredit', saveARRgrid, this);
	ARRgrid.addListener('rowcontextmenu', ARRgrid.onContextClick);
	arrreader.load({params: {"start":0,"limit":25}});
	
		  var store = new Ext.data.Store({
					url: 'index2.php?option=com_rekry&task=pro',
					reader: new Ext.data.JsonReader({root: 'pro',totalProperty: 'totalCount',id: 'id'}, 
					[{name: 'id'},
					 {name: 'name'},
					 {name: 'text'},
					 {name: 'modified'}]),
					baseParams: {option: "com_rekry",task: 'pro',"limit":25}});
		  
store.load({params: {"start":0,"limit":25}});

var PROgrid = new xg.EditorGridPanel({
		tbar: [{
						text: 'New'
						, iconCls: 'add'
						, tooltip: 'Add new'
						, handler: handleNewPro
						, scope: this
					}
					, {
						text: 'Delete'
						, iconCls: 'remove'
						, tooltip: 'Select rows to delete'
					    , handler: handleDeletePro
						, scope: this
					}
					, {
						text: 'Refresh'
						, tooltip: 'Refresh grid'
						, iconCls: 'refresh-icon'
						, handler: function () {
							store.reload();
						}
					}],
		id: 'pro-grid',
		clicksToEdit: 2,
		selModel: new xg.RowSelectionModel({singleSelect:false}),
        frame:false,		
        collapsible: false,
        animCollapse: false,
			 viewConfig: {
					fitToFrame:true,
					fitContainer:true, 	
                    forceFit:true,
                    autoScroll:true					
		    },	
			bbar: new Ext.PagingToolbar({
				store: store,
				pageSize: 25,
				displayInfo: 'Topics {0} - {1} of {2}',
				emptyMsg: 'No topics to display'}),
			store: store,
			colModel: new xg.ColumnModel([new xg.RowNumberer(),
						 {id:'id',
			            header: "ID", 
			            width: 10, 
			            sortable: true, 
			            dataIndex: 'id', 
			            align: 'right', 
			            hidden: true},								 
						{header: 'Name',
						dataIndex: 'name',
						width: 200,
						sortable: true,
						editor: new fm.TextField({
						allowBlank: false
					    }),
						locked: false},
						{header: 'Description',
						dataIndex: 'text',
						width: 200,
						sortable: true,
						locked: true,
						editor: new fm.TextField({
						allowBlank: false
					    })
						},{header: 'Modified',
						dataIndex: 'modified',
						width: 200,
						sortable: true,
						locked: true
						}]),
			            stripeRows: true,
			            height: winHeight-35});	


PROgrid.addListener('afteredit', savePROgrid, this);

var gsm = OPPgrid.getSelectionModel();

var winTab = new Ext.TabPanel({
renderTo:'ux-bar',
activeTab:0,
height: winHeight,
plain:false,
layoutOnTabChange: true,
defaults:{autoScroll: true},
items: [{
title: 'Opportunities',
items: OPPgrid,
},{
title: 'Archives',
items : ARRgrid,
},{
title: 'Professions',
items : PROgrid,
}],
openTab : function(record){
        record = (record && record.data) ? record : gsm.getSelected();
        var d = record.data;
        var id = !d.link ? Ext.id() : d.link.replace(/[^A-Z0-9-_]/gi, '');
		id = id + '-form';
		formid = id + '-edit';
        var tab;
	    if(!(tab = this.getItem(id))){
            tab = new Ext.Panel({
                id: id,
                title: d.op_name,
                tabTip: d.op_name,
                items: new Ext.form.FormPanel({
				id: formid
			    , labelWidth: 85
				, url: 'index2.php?option=com_rekry&task=save_app_tab'
				, frame: false
				, bodyStyle:'padding:5px 5px 0'
				, height: 540	
                , closeAction:'destroy'	
                , items: [
					new Ext.form.Hidden ({ name: 'task', value: 'save_app_tab' })
					, new Ext.form.Hidden ({ name: 'option', value: 'com_rekry' })
					, new Ext.form.Hidden ({ name: 'keyID', value: d.op_id })
					, {
						fieldLabel: 'Title'
						, name: 'title'
						, allowBlank:false
						, width: 200
						, xtype:'textfield'
						, value: d.op_name
					},{
                    xtype:'datefield',
					format:'Y-m-d',
                    fieldLabel: 'Date Created',
                    name: 'st_date',
					value: d.op_start,
                    width: 200
                },{
                    xtype:'datefield',
					format:'Y-m-d',
                    fieldLabel: 'Closing Date',
                    name: 'ed_date',
					value: d.op_end,
                    width: 200
                },{
                    xtype:'combo',
		            fieldLabel: 'Public',
                    name: 'active',
					value: d.active,
                    width: 200,
					store: new Ext.data.SimpleStore({
											fields: ['value'],
											data:[[
												'true'
											],[
												'false'
											]]
										}),
										displayField: 'value',
										mode: 'local',
										triggerAction: 'all'										
				 },{
            plain:true,
            height:385,
			autoScroll: true,
            defaults:{bodyStyle:'padding:10px'},
            items:[{
                cls:'x-plain',
                title:'Main',
                layout:'fit',
                items: {
                    xtype:'htmleditor',
                    id:'main',
                    fieldLabel:'Main',
					value: d.op_desc
					}
            },{
                cls:'x-plain',
                title:'Company Description',
                layout:'fit',
                items: {
                    xtype:'htmleditor',
                    id:'company',
                    fieldLabel:'Company Description',
					value: d.company
                }
            },{
                cls:'x-plain',
                title:'Culture',
                layout:'fit',
                items: {
                    xtype:'htmleditor',
                    id:'culture',
                    fieldLabel:'Culture',
					value: d.culture
                }
            },{
                cls:'x-plain',
                title:'Opportunity Description',
                layout:'fit',
                items: {
                    xtype:'htmleditor',
                    id:'opportunity',
                    fieldLabel:'Opportunity Description',
					value: d.opportunity
                }
            },{
                cls:'x-plain',
                title:'Responsibilities',
                layout:'fit',
                items: {
                    xtype:'htmleditor',
                    id:'responsibilities',
                    fieldLabel:'Responsibilities',
					value: d.responsibilities
                }
            },{
                cls:'x-plain',
                title:'Required Knowledge and Skills',
                layout:'fit',
                items: {
                    xtype:'htmleditor',
                    id:'skills',
                    fieldLabel:'Required Knowledge and Skills',
					value: d.required_knowledge_and_skills
                }
            },{
                cls:'x-plain',
                title:'Required Experience',
                layout:'fit',
                items: {
                    xtype:'htmleditor',
                    id:'experience',
                    fieldLabel:'Required Experience',
					value: d.required_experience
                }
            },{
                cls:'x-plain',
                title:'Compensation',
                layout:'fit',
                items: {
                    xtype:'htmleditor',
                    id:'compensation',
                    fieldLabel:'Compensation',
					value: d.compensation
                }
            },{
                cls:'x-plain',
                title:'Contact',
                layout:'fit',
                items: {
                    xtype:'htmleditor',
                    id:'contact',
                    fieldLabel:'Contact',
					value: d.contact
                }
            }]
        }
					/*
					*/
				]
				, tbar: [
					 {
						text: 'Save'
						, type: 'submit'
						, iconCls: 'new-tab'
						, handler: function () {  
						     Ext.getCmp(formid).getForm().submit({
								waitMsg: 'Saving...'
								, success: function (response,options) {
									 // Ext.getCmp(formid).getForm().reset();
								}
								, failure: function (response,options) {
									Ext.MessageBox.alert('Error','Unable to save record');
								}
							});
						} 
					}
					, {
						text: 'Reset'
						, type: 'reset'
						, iconCls: 'refresh-icon'
						, handler: function () {			
						 Ext.getCmp(formid).getForm().reset();
						}
					}
				]
			}),
                closable:true,
                autoScroll:true,
                border:true,
				height:600
            });
            this.add(tab);
        }
        this.setActiveTab(tab);
    }, openDubTab : function(record){
        record = (record && record.data) ? record : gsm.getSelected();
        var d = record.data;
        var id = !d.link ? Ext.id() : d.link.replace(/[^A-Z0-9-_]/gi, '');
		id = id + '-form';
		formid = id + '-edit';
        var tab;
	    if(!(tab = this.getItem(id))){
            tab = new Ext.Panel({
                id: id,
                title: 'Copy of: ' + d.op_name,
                tabTip: 'Copy of: ' + d.op_name,
                items: new Ext.form.FormPanel({
				id: formid
			    , labelWidth: 85
				, url: 'index2.php?option=com_rekry&task=save_app_tab_dub'
				, frame: false
				, bodyStyle:'padding:5px 5px 0'
				, height: 540	
                , closeAction:'destroy'	
                , items: [
					new Ext.form.Hidden ({ name: 'task', value: 'save_app_tab_dub' })
					, new Ext.form.Hidden ({ name: 'option', value: 'com_rekry' })
					, new Ext.form.Hidden ({ name: 'keyID', value: d.op_id })
					, {
						fieldLabel: 'Title'
						, name: 'title'
						, allowBlank:false
						, width: 200
						, xtype:'textfield'
						, value: 'Copy of: ' + d.op_name
					},{
                    xtype:'datefield',
					format:'Y-m-d',
                    fieldLabel: 'Date Created',
                    name: 'st_date',
					value: d.op_start,
                    width: 200
                },{
                    xtype:'datefield',
					format:'Y-m-d',
                    fieldLabel: 'Closing Date',
                    name: 'ed_date',
					value: d.op_end,
                    width: 200
                },{
                    xtype:'combo',
		            fieldLabel: 'Public',
                    name: 'active',
					value: d.active,
                    width: 200,
					store: new Ext.data.SimpleStore({
											fields: ['value'],
											data:[[
												'true'
											],[
												'false'
											]]
										}),
										displayField: 'value',
										mode: 'local',
										triggerAction: 'all'										
				 },{
            height:385,
			autoScroll: true,
            plain:true,
            defaults:{bodyStyle:'padding:10px'},
            items:[{
                cls:'x-plain',
                title:'Main',
                layout:'fit',
                items: {
                    xtype:'htmleditor',
                    id:'main',
                    fieldLabel:'Main',
					value: d.op_desc
					}
            },{
                cls:'x-plain',
                title:'Company Description',
                layout:'fit',
                items: {
                    xtype:'htmleditor',
                    id:'company',
                    fieldLabel:'Company Description',
					value: d.company
                }
            },{
                cls:'x-plain',
                title:'Culture',
                layout:'fit',
                items: {
                    xtype:'htmleditor',
                    id:'culture',
                    fieldLabel:'Culture',
					value: d.culture
                }
            },{
                cls:'x-plain',
                title:'Opportunity Description',
                layout:'fit',
                items: {
                    xtype:'htmleditor',
                    id:'opportunity',
                    fieldLabel:'Opportunity Description',
					value: d.opportunity
                }
            },{
                cls:'x-plain',
                title:'Responsibilities',
                layout:'fit',
                items: {
                    xtype:'htmleditor',
                    id:'responsibilities',
                    fieldLabel:'Responsibilities',
					value: d.responsibilities
                }
            },{
                cls:'x-plain',
                title:'Required Knowledge and Skills',
                layout:'fit',
                items: {
                    xtype:'htmleditor',
                    id:'skills',
                    fieldLabel:'Required Knowledge and Skills',
					value: d.required_knowledge_and_skills
                }
            },{
                cls:'x-plain',
                title:'Required Experience',
                layout:'fit',
                items: {
                    xtype:'htmleditor',
                    id:'experience',
                    fieldLabel:'Required Experience',
					value: d.required_experience
                }
            },{
                cls:'x-plain',
                title:'Compensation',
                layout:'fit',
                items: {
                    xtype:'htmleditor',
                    id:'compensation',
                    fieldLabel:'Compensation',
					value: d.compensation
                }
            },{
                cls:'x-plain',
                title:'Contact',
                layout:'fit',
                items: {
                    xtype:'htmleditor',
                    id:'contact',
                    fieldLabel:'Contact',
					value: d.contact
                }
            }]
        }
					/*
					*/
				]
				, tbar: [
					 {
						text: 'Save'
						, type: 'submit'
						, iconCls: 'new-tab'
						, handler: function () {  
						     Ext.getCmp(formid).getForm().submit({
								waitMsg: 'Saving...'
								, success: function (response,options) {
									 // Ext.getCmp(formid).getForm().reset();
								}
								, failure: function (response,options) {
									Ext.MessageBox.alert('Error','Unable to save record');
								}
							});
						} 
					}
					, {
						text: 'Reset'
						, type: 'reset'
						, iconCls: 'refresh-icon'
						, handler: function () {			
						 Ext.getCmp(formid).getForm().reset();
						}
					}
				]
			}),
                closable:true,
                autoScroll:true,
                border:true,
				height:600
            });
            this.add(tab);
        }
        this.setActiveTab(tab);
    }
});
		
});