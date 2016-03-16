//******************* General view ***********************************************
var CUFDebug=true;

if (!CUFDebug) {
    console = console || {};
    console.log = function(){};
}

var VCUFGeneral=Backbone.View.extend({
    el:"div#cuf_general"
});

var VCUFTabsBackup=Backbone.View.extend({
    el:"div#cuf_tabs_backup"
});

var VCUFTabsOption=Backbone.View.extend({
    el:"div#cuf_tabs_option"
});

var VCUFTabsFolder=Backbone.View.extend({
    el:"div#cuf_tabs_folder"
});

//******************************* VIEW and ACTION of button tabs ******************
var VCUFTabsButton=Backbone.View.extend({
    mCUFOption:{},
    mCUFSelectedFolder:{},
    el:"ul#cuf_tabs_button"
    , events: {
        "click .cuf_fd": "fd",
        "click .cuf_bk": "bp"      
    },fd:function(){
        var self=this;
        console.log(this.mCUFSelectedFolder);
          this.mCUFOption.fetch({type:'POST',data:{action: "cuf_save_option",option:this.mCUFOption.attributes},success:function(){
            if(self.mCUFSelectedFolder.get('folderName')!=''){
                      self.mCUFSelectedFolder.trigger('change'); 
                  }
        }});
    },bk:function(){
       console.log("TODO: Change for cuf logic");
      
    }
});


var MCUFSelectedFolder = Backbone.Model.extend({
    defaults :{
        folderName:''
    }
});


var CCUFFolder= Backbone.Collection.extend({
    url:ajaxurl
});

var CCUFFolderFiles= Backbone.Collection.extend({
    url:ajaxurl,
    parse:function(response) {
        if(response.status==200){
            return response.results;
        }else{
            //TODO: do something with error
            console.log(response.status);
        }
    
  }
});

var VCUFTableFiles= Backbone.View.extend({
    cCUFFolderFiles:{},
    id:'folder-file',
    className:'form-table wp-list-table widefat fixed',
    tagName:'table',
    template:_.template(jQuery("#cuf_table_files").html()),
    render: function() {
       console.log('Render table empty');
       this.$el.html(this.template());
       return this;
    }
});

var VCUFTrFile= Backbone.View.extend({
    mCUFFile:{},
    mCUFOption:{},
    tagName:'tr',
    template:_.template(jQuery("#cuf_tbody_file").html()),
    render: function() {
       console.log('Render tr with object');
       console.log(this.mCUFFile);
       this.$el.html(this.template({mCUFFile:this.mCUFFile,mCUFOption:this.mCUFOption}));
       return this;
    }
});

var VCUFNothingSearch= Backbone.View.extend({
    
    template:_.template(jQuery("#cuf_nothing_search").html()),
    render: function() {
       console.log('Render nothing search');
       this.$el.html(this.template());
       return this;
    }
});

var VCUFNothingBackup= Backbone.View.extend({
    template:_.template(jQuery("#cuf_nothing_backup").html()),
    render: function() {
        console.log('Render nothing backup');
       this.$el.html(this.template());
       return this;
    }
});


var VCUFWait= Backbone.View.extend({
    template:_.template(jQuery("#cuf_wait").html()),
    render: function() {
      
       this.$el.html(this.template());
       return this;
    }
});

var MCUFNameToDelete= Backbone.Model.extend({
    defaults :{
        fileName:''
    }
})

var CCUFFilesToDelete=Backbone.Collection.extend({
   url:ajaxurl,
   mCUFSelectedFolder:{},
   model:MCUFNameToDelete,
   parse:function(response) {
        if(response.status==200){
            this.mCUFSelectedFolder.trigger('change'); 
            return;
        }else{
            //TODO: do something with error
            console.log(response.status);
            return;
        }
    
  }
})

var VCUFDeleteAllSelectedFileFolder= Backbone.View.extend({
    mCUFSelectedFolder:{},
    
    template:_.template(jQuery("#cuf_folder_button").html()),
    render: function() {
       this.$el.html(this.template());
       return this;
    },
    events:{
        'click .cuf_folder_delete':'deleteAllSelectedFileFolder'
    },
    deleteAllSelectedFileFolder:function(){
        var cCUFFilesToDelete= new CCUFFilesToDelete();
       cCUFFilesToDelete.mCUFSelectedFolder=this.mCUFSelectedFolder;
        var mCUFNameToDelete;
       // alert('cCUFFilesToDelete');
        jQuery("#folder-file input:checked").each(function(index,element){
            mCUFNameToDelete= new MCUFNameToDelete();
            mCUFNameToDelete.set('fileName',jQuery(element).data('name'));
            cCUFFilesToDelete.add(mCUFNameToDelete);
        });
        console.log(this.mCUFSelectedFolder.get('folderName'));
        console.log(cCUFFilesToDelete.toJSON());
        cCUFFilesToDelete.fetch({type:'POST',data:{action: "cuf_delete_files",dir:this.mCUFSelectedFolder.get('folderName'),files:cCUFFilesToDelete.toJSON()}})
        
    }

})




var VCUFSelectFolder=Backbone.View.extend({
    tagName:'select',
    mCUFSelectedFolder:{},
    cCUFFolder:{},
    className:"select-folder",
    template:_.template(jQuery("#cuf_select_folder").html()),
    render: function() {
       console.log(this.cCUFFolder);
       this.$el.html(this.template({cCUFFolder:this.cCUFFolder}));
       return this;
    },
    events: {
        "click .select-folder":"selectFolder"
    },
    selectFolder:function(evt){
       this.mCUFSelectedFolder.set('folderName',evt.currentTarget.value);
    }
    
});


var MCUFOption=Backbone.Model.extend({
    url:ajaxurl
});


var VCUFOption= Backbone.View.extend({
    mCUFOption:{},
    className:'form-table wp-list-table widefat fixed',
    tagName:'table',
    template:_.template(jQuery("#cuf_option").html()),
    render: function() {
       console.log('Render option with object:');
       console.log(this.mCUFOption);
       this.$el.html(this.template({mCUFOption:this.mCUFOption}));
       return this;
    },
    events:{
      "change .cuf_check" :"updateCheck",
    },
    updateCheck:function(evt){
         this.mCUFOption.set(jQuery(evt.target).data("cuf"),jQuery(evt.target).attr("checked")=== 'checked'?true:false);
    }
  
});



jQuery(document).ready(function() {
    
    var mCUFOption= new MCUFOption();
    
    var vCUFOption = new VCUFOption();
    vCUFOption.mCUFOption=mCUFOption;
    
    vCUFOption.listenTo(mCUFOption,"sync", function(){
      vCUFOption.render();
    });
    mCUFOption.fetch({type:'POST',data:{action: "cuf_get_option"}});
    
    
    var vCUFTabsOption= new VCUFTabsOption();
    
    vCUFTabsOption.$el.append(vCUFOption.el);
    
    var mCUFSelectedFolder= new MCUFSelectedFolder();
    
    var vCUFTableFiles= new VCUFTableFiles();
    
    var vCUFNothingBackup=new VCUFNothingBackup();
    vCUFNothingBackup.render();
    var vCUFNothingSearch=new VCUFNothingSearch();
    vCUFNothingSearch.render();
    var vCUFWait= new VCUFWait();
    vCUFWait.render();
    
    var cCUFFolderFiles= new CCUFFolderFiles();
    

    vCUFTableFiles.listenTo(cCUFFolderFiles,"sync",function(){
        vCUFTableFiles.render();
        
        if(cCUFFolderFiles.size()==0){
            vCUFTableFiles.$el.html(vCUFNothingSearch.el);
        }
       console.log(cCUFFolderFiles.size());
        cCUFFolderFiles.forEach(function(mCUFFile){
            console.log(mCUFFile);
            var vCUFTrFile= new VCUFTrFile();
            vCUFTrFile.mCUFFile=mCUFFile;
            vCUFTrFile.mCUFOption=mCUFOption;
            vCUFTrFile.render();
            vCUFTableFiles.$el.find('tbody').append(vCUFTrFile.el);
        });
    });
    
    mCUFSelectedFolder.listenTo(mCUFSelectedFolder,'change',function(){
       vCUFTableFiles.$el.html(vCUFWait.$el.html());
       cCUFFolderFiles.fetch({type:'POST',data:{action: "cuf_get_files",dir:mCUFSelectedFolder.get('folderName')}});
    });
    
    var cCUFFolder= new CCUFFolder();
    
    var vCUFSelectFolder= new VCUFSelectFolder();
    
    vCUFSelectFolder.mCUFSelectedFolder=mCUFSelectedFolder;
    
    
    var vCUFTabsFolder= new VCUFTabsFolder();
    
    //add the select of folder
    vCUFTabsFolder.$el.append(vCUFSelectFolder.el);
    
    vCUFTableFiles.render();
    
    //if nothing is found, tell nothing is found, this if for the firts part
    vCUFTableFiles.$el.html(vCUFNothingSearch.el);
    
    //View fot the delete
    var vCUFDeleteAllSelectedFileFolder = new VCUFDeleteAllSelectedFileFolder();
    vCUFDeleteAllSelectedFileFolder.mCUFSelectedFolder=mCUFSelectedFolder;
    vCUFDeleteAllSelectedFileFolder.render();
    //Add button delete begin
    vCUFTabsFolder.$el.append(vCUFDeleteAllSelectedFileFolder.el);
    
    //add table of file get by the folder
    vCUFTabsFolder.$el.append(vCUFTableFiles.el);
    
    //Add button delete end
    //vCUFTabsFolder.$el.append(vCUFDeleteAllSelectedFileFolder.el);
    
    
    vCUFSelectFolder.cCUFFolder=cCUFFolder;
    
    vCUFSelectFolder.listenTo(cCUFFolder,"sync", function(){
        vCUFSelectFolder.render();
    });
    
    cCUFFolder.fetch({type:'POST',data:{action: "cuf_get_dirs"}});
    
    
    var vCUFTabsButton= new VCUFTabsButton();
    vCUFTabsButton.mCUFOption=mCUFOption;
    vCUFTabsButton.mCUFSelectedFolder=mCUFSelectedFolder;
    var vCUFGeneral= new VCUFGeneral();
    vCUFGeneral.$el.tabs();
    
    
    
});
 