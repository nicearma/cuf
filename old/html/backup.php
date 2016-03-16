<script type="text/template" id="cuf_table_backup">
<thead>
    <tr>
        <th><?php _e('Restore','cuf') ?></th>
        <th><?php _e('ID','cuf') ?></th>
        <th><?php _e('File','cuf') ?></th>
    </tr>
</thead>
</script>


<script type="text/template" id="cuf_tbody_backup">
    <% var src; %>
    <tr>
        <td><input type="checkbox" class="backup" data-id="<%= mCUFBackup.get('id') %>" /></td>
        <td><%= mCUFBackup.get('id') %></td>
            
        <td>
        <%
        var only=true;            
        _.each(mCUFBackup.get('files'),function(file){
            if(file.indexOf('.backup')==-1){
                if(only){

                only=false;
                src=mCUFBackup.get('urlBase')+'/'+mCUFBackup.get('id')+'/'+file;
               %>
               <a href="<%= src %>">
            <img width="40px" height="40px" src="<%= src %>" />  </a>
                    <%
            }
            }
        }); %>    
          </td>
    </tr>

</script>


<script type="text/template" id="dnui_button_backup">
   
<h2>
    <button class="button-primary cuf_restore_backup" type="button"><?php _e('Restore selected','cuf') ?> </button> 
    <button class="button-primary cuf_cleanup_backup right" type="button"><?php _e('Cleanup all backup','cuf') ?> </button> 
    <button class="button-primary cuf_delet_backup right"  type="button"><?php _e('Delete selected','cuf') ?> </button> 
</h2>

</script>